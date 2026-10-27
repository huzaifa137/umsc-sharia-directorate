<?php

namespace App\Http\Controllers;

use App\Models\BulkImportBatch;
use App\Models\BulkImportRow;
use App\Models\Mosque;
use App\Models\Role;
use App\Models\User;
use App\Services\AccessControl;
use App\Services\SimpleXlsxReader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class BulkImportController extends Controller
{
    /**
     * Column definitions for each import type
     */
    private const COLUMNS_IMAAM = ['region', 'district', 'county', 'mosque', 'imaam', 'location', 'contact', 'deputy', 'deputy_contact'];
    private const COLUMNS_DISTRICT_KHADHI = ['name', 'district', 'region', 'contact', 'email'];
    private const COLUMNS_REGIONAL_ASSISTANT = ['name', 'region', 'contact', 'email'];

    public function index()
    {
        $batches = BulkImportBatch::with('creator')
            ->orderByDesc('id')
            ->paginate(10);

        $mosqueCount = Mosque::count();
        $imaamAccountCount = Mosque::whereNotNull('imaam_user_id')->count();
        
        // Role-based stats
        $districtKhadhiCount = User::whereHas('role', function($q) {
            $q->where('slug', 'district_khadhi');
        })->count();
        
        $regionalAssistantCount = User::whereHas('role', function($q) {
            $q->where('slug', 'regional_assistant');
        })->count();

        return view('admin.bulk-import', compact(
            'batches', 
            'mosqueCount', 
            'imaamAccountCount',
            'districtKhadhiCount',
            'regionalAssistantCount'
        ));
    }

    /**
     * Step 1 — Preview with support for multiple import types
     */
    public function preview(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:10240',
            'import_type' => 'required|in:imaam_directory,district_khadhi,regional_assistant',
        ]);

        $token = (string) Str::uuid();
        $path = $request->file('file')->storeAs('bulk-imports', $token . '.xlsx');

        try {
            $rows = $this->parseRows(Storage::path($path), $request->import_type);
        } catch (Throwable $e) {
            Log::error('Bulk import preview failed: ' . $e->getMessage());
            @Storage::delete($path);

            return response()->json([
                'status' => false,
                'message' => 'We could not read that file: ' . $e->getMessage(),
            ], 422);
        }

        $summary = $this->buildSummary($rows, $request->import_type);

        return response()->json([
            'status' => true,
            'token' => $token,
            'original_filename' => $request->file('file')->getClientOriginalName(),
            'import_type' => $request->import_type,
            'summary' => $summary,
            'preview' => array_slice($rows, 0, 25),
        ]);
    }

    /**
     * Step 2 — Commit with support for multiple import types
     */
    public function commit(Request $request)
    {
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $request->validate([
            'token' => 'required|string',
            'original_filename' => 'nullable|string',
            'import_type' => 'required|in:imaam_directory,district_khadhi,regional_assistant',
        ]);

        $stagedPath = 'bulk-imports/' . $request->token . '.xlsx';

        if (!Storage::exists($stagedPath)) {
            return response()->json([
                'status' => false,
                'message' => 'This import session has expired. Please upload the file again.',
            ], 422);
        }

        try {
            $rows = $this->parseRows(Storage::path($stagedPath), $request->import_type);
        } catch (Throwable $e) {
            Log::error('Bulk import commit failed: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'We could not read that file: ' . $e->getMessage(),
            ], 422);
        }

        // Dispatch to the appropriate import handler
        $result = match($request->import_type) {
            'imaam_directory' => $this->commitImaamDirectory($rows, $request),
            'district_khadhi' => $this->commitRoleAccounts($rows, $request, 'district_khadhi'),
            'regional_assistant' => $this->commitRoleAccounts($rows, $request, 'regional_assistant'),
        };

        @Storage::delete($stagedPath);

        return response()->json($result);
    }

    /**
     * Commit Imaam Directory import
     */
    private function commitImaamDirectory(array $rows, Request $request): array
    {
        $imaamRole = Role::where('slug', 'imaam')->first();
        if (!$imaamRole) {
            throw new \RuntimeException('Imaam role is not configured.');
        }

        $me = AccessControl::user();

        $batch = BulkImportBatch::create([
            'type' => 'imaam_directory',
            'original_filename' => $request->original_filename,
            'total_rows' => count($rows),
            'status' => 'processing',
            'created_by' => $me?->id,
        ]);

        $created = 0;
        $duplicates = 0;
        $errors = 0;
        $credentials = [];
        $usedUsernames = DB::table('users')->pluck('username')->filter()->flip()->all();
        $pendingRowLogs = [];
        $now = now();

        $logRow = function (array $attributes) use (&$pendingRowLogs, $batch, $now) {
            $pendingRowLogs[] = array_merge([
                'batch_id' => $batch->id,
                'message' => null,
                'created_user_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ], $attributes, [
                'payload' => json_encode($attributes['payload'] ?? null),
            ]);
        };

        foreach ($rows as $row) {
            if ($row['type'] === 'blank') {
                continue;
            }

            if ($row['type'] === 'error') {
                $errors++;
                $logRow([
                    'row_number' => $row['row_number'],
                    'status' => 'error',
                    'message' => $row['message'],
                    'payload' => $row,
                ]);
                continue;
            }

            try {
                DB::transaction(function () use (
                    $row,
                    $batch,
                    $imaamRole,
                    $me,
                    &$created,
                    &$duplicates,
                    &$credentials,
                    &$usedUsernames,
                    $logRow
                ) {
                    // Upsert the mosque directory entry
                    $mosque = Mosque::where('district', $row['district'])
                        ->where('county', $row['county'])
                        ->where('name', $row['mosque'])
                        ->first();

                    if (!$mosque) {
                        $mosque = Mosque::create([
                            'region' => $row['region'],
                            'district' => $row['district'],
                            'county' => $row['county'],
                            'name' => $row['mosque'],
                            'imaam_name' => $row['imaam'],
                            'imaam_contact' => $row['contact'],
                            'imported_batch_id' => $batch->id,
                        ]);
                    } else {
                        $mosque->fill([
                            'region' => $row['region'],
                            'imaam_name' => $row['imaam'] ?: $mosque->imaam_name,
                            'imaam_contact' => $row['contact'] ?: $mosque->imaam_contact,
                        ])->save();
                    }

                    // Create Imaam account
                    if (!$row['imaam']) {
                        $duplicates++;
                        $logRow([
                            'row_number' => $row['row_number'],
                            'status' => 'duplicate',
                            'message' => 'Mosque saved — no Imaam name supplied, so no account was created.',
                            'payload' => $row,
                        ]);
                        return;
                    }

                    if ($mosque->imaam_user_id) {
                        $duplicates++;
                        $logRow([
                            'row_number' => $row['row_number'],
                            'status' => 'duplicate',
                            'message' => 'An account already exists for the Imaam of this mosque.',
                            'payload' => $row,
                            'created_user_id' => $mosque->imaam_user_id,
                        ]);
                        return;
                    }

                    $username = $this->generateUsername($row['imaam'], $usedUsernames);
                    $usedUsernames[$username] = true;
                    $tempPassword = $this->generateTempPassword();
                    $hashed = Hash::make($tempPassword, ['rounds' => 4]);

                    $nameParts = preg_split('/\s+/', trim($row['imaam']), 2);

                    $user = User::create([
                        'username' => $username,
                        'email' => null,
                        'password' => $hashed,
                        'user_role' => 1,
                        'role_id' => $imaamRole->id,
                        'account_status' => 10,
                        'registration_status' => 0,
                        'firstname' => $nameParts[0] ?? $row['imaam'],
                        'lastname' => $nameParts[1] ?? '',
                        'phonenumber' => $row['contact'],
                        'country' => 'Uganda',
                        'region' => $row['region'],
                        'district' => $row['district'],
                        'county' => $row['county'],
                        'mosque_name' => $row['mosque'],
                        'created_by' => $me?->id,
                        'must_change_password' => true,
                        'bulk_imported' => true,
                        'generated_password' => $tempPassword,
                    ]);

                    $mosque->imaam_user_id = $user->id;
                    $mosque->save();

                    $created++;
                    $credentials[] = [
                        'full_name' => $row['imaam'],
                        'region' => $row['region'],
                        'district' => $row['district'],
                        'mosque' => $row['mosque'],
                        'username' => $username,
                        'temp_password' => $tempPassword,
                    ];

                    $logRow([
                        'row_number' => $row['row_number'],
                        'status' => 'created',
                        'message' => "Imaam account created for {$row['imaam']}.",
                        'payload' => $row,
                        'created_user_id' => $user->id,
                    ]);
                });
            } catch (Throwable $e) {
                Log::error("Bulk import row {$row['row_number']} failed: " . $e->getMessage());
                $errors++;
                $logRow([
                    'row_number' => $row['row_number'],
                    'status' => 'error',
                    'message' => 'Row failed and was skipped: ' . $e->getMessage(),
                    'payload' => $row,
                ]);
            }
        }

        foreach (array_chunk($pendingRowLogs, 500) as $chunk) {
            BulkImportRow::insert($chunk);
        }

        $batch->update([
            'created_count' => $created,
            'duplicate_count' => $duplicates,
            'error_count' => $errors,
            'status' => 'completed',
        ]);

        // Log the audit trail - using Log instead of Helper
        Log::info('Bulk Import Completed (Imaam Directory)', [
            'batch_id' => $batch->id,
            'created' => $created,
            'duplicates' => $duplicates,
            'errors' => $errors,
            'user_id' => $me?->id,
            'message' => "Imported the Mosque/Imaam directory — {$created} accounts created, {$duplicates} skipped, {$errors} errors."
        ]);

        return [
            'status' => true,
            'message' => 'Import completed successfully.',
            'batch_id' => $batch->id,
            'created' => $created,
            'duplicates' => $duplicates,
            'errors' => $errors,
            'credentials' => $credentials,
        ];
    }

    /**
     * Generic role account import for District Khadhi / Regional Assistant
     */
    private function commitRoleAccounts(array $rows, Request $request, string $roleSlug): array
    {
        $targetRole = Role::where('slug', $roleSlug)->first();
        if (!$targetRole) {
            throw new \RuntimeException("Role '{$roleSlug}' is not configured.");
        }

        $me = AccessControl::user();
        
        $batch = BulkImportBatch::create([
            'type' => $roleSlug,
            'original_filename' => $request->original_filename,
            'total_rows' => count($rows),
            'status' => 'processing',
            'created_by' => $me?->id,
        ]);

        $created = 0;
        $duplicates = 0;
        $errors = 0;
        $credentials = [];
        $usedUsernames = DB::table('users')->pluck('username')->filter()->flip()->all();
        $usedEmails = DB::table('users')->pluck('email')->filter()->flip()->all();
        $pendingRowLogs = [];
        $now = now();

        $logRow = function (array $attributes) use (&$pendingRowLogs, $batch, $now) {
            $pendingRowLogs[] = array_merge([
                'batch_id' => $batch->id,
                'message' => null,
                'created_user_id' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ], $attributes, [
                'payload' => json_encode($attributes['payload'] ?? null),
            ]);
        };

        foreach ($rows as $row) {
            if ($row['type'] === 'blank' || $row['type'] === 'error') {
                if ($row['type'] === 'error') {
                    $errors++;
                    $logRow([
                        'row_number' => $row['row_number'],
                        'status' => 'error',
                        'message' => $row['message'],
                        'payload' => $row,
                    ]);
                }
                continue;
            }

            try {
                DB::transaction(function () use (
                    $row,
                    $targetRole,
                    $me,
                    $roleSlug,
                    $batch,
                    &$created,
                    &$duplicates,
                    &$credentials,
                    &$usedUsernames,
                    &$usedEmails,
                    $logRow
                ) {
                    // Check for existing user
                    $username = $this->generateUsername($row['full_name'], $usedUsernames);
                    $existingUser = null;

                    // Check by email if provided
                    if (!empty($row['email'])) {
                        $existingUser = User::where('email', $row['email'])->first();
                    }
                    
                    // Check by username if no email match
                    if (!$existingUser) {
                        $existingUser = User::where('username', $username)->first();
                    }

                    // Also check by phone number
                    if (!$existingUser && !empty($row['contact'])) {
                        $existingUser = User::where('phonenumber', $row['contact'])->first();
                    }

                    if ($existingUser) {
                        // Check if user already has this role
                        if ($existingUser->role_id == $targetRole->id) {
                            $duplicates++;
                            $logRow([
                                'row_number' => $row['row_number'],
                                'status' => 'duplicate',
                                'message' => "An account already exists for this {$roleSlug}.",
                                'payload' => $row,
                                'created_user_id' => $existingUser->id,
                            ]);
                            return;
                        }

                        // User exists but has different role - update role
                        $existingUser->role_id = $targetRole->id;
                        $existingUser->user_role = $targetRole->level;
                        
                        // Update region/district if applicable
                        if ($roleSlug === 'district_khadhi') {
                            $existingUser->region = $row['region'];
                            $existingUser->district = $row['district'];
                        } else {
                            $existingUser->region = $row['region'];
                        }
                        
                        if (!empty($row['contact'])) {
                            $existingUser->phonenumber = $row['contact'];
                        }
                        
                        if (!empty($row['email']) && empty($existingUser->email)) {
                            $existingUser->email = $row['email'];
                        }
                        
                        $existingUser->save();
                        
                        $created++;
                        $duplicates++;
                        $logRow([
                            'row_number' => $row['row_number'],
                            'status' => 'duplicate',
                            'message' => "Existing user '{$existingUser->firstname} {$existingUser->lastname}' was assigned the {$roleSlug} role.",
                            'payload' => $row,
                            'created_user_id' => $existingUser->id,
                        ]);
                        return;
                    }

                    // Create new user
                    $usedUsernames[$username] = true;
                    if (!empty($row['email'])) {
                        $usedEmails[$row['email']] = true;
                    }
                    
                    $tempPassword = $this->generateTempPassword();
                    $hashed = Hash::make($tempPassword, ['rounds' => 4]);

                    $nameParts = preg_split('/\s+/', trim($row['full_name']), 2);

                    $userData = [
                        'username' => $username,
                        'email' => $row['email'] ?? null,
                        'password' => $hashed,
                        'user_role' => $targetRole->level,
                        'role_id' => $targetRole->id,
                        'account_status' => 10,
                        'registration_status' => 1,
                        'firstname' => $nameParts[0] ?? $row['full_name'],
                        'lastname' => $nameParts[1] ?? '',
                        'phonenumber' => $row['contact'],
                        'country' => 'Uganda',
                        'created_by' => $me?->id,
                        'must_change_password' => true,
                        'bulk_imported' => true,
                        'generated_password' => $tempPassword,
                    ];

                    // Role-specific fields
                    if ($roleSlug === 'district_khadhi') {
                        // District Khadhi - store both region and district
                        $userData['region'] = $row['region'];
                        $userData['district'] = $row['district'];
                    } else {
                        // Regional Assistant - region only
                        $userData['region'] = $row['region'];
                    }

                    $user = User::create($userData);

                    $created++;
                    $credentials[] = [
                        'full_name' => $row['full_name'],
                        'region' => $row['region'],
                        'district' => $row['district'] ?? 'N/A',
                        'username' => $username,
                        'temp_password' => $tempPassword,
                    ];

                    $logRow([
                        'row_number' => $row['row_number'],
                        'status' => 'created',
                        'message' => "{$roleSlug} account created for {$row['full_name']}.",
                        'payload' => $row,
                        'created_user_id' => $user->id,
                    ]);
                });
            } catch (Throwable $e) {
                Log::error("Bulk import row {$row['row_number']} failed: " . $e->getMessage());
                $errors++;
                $logRow([
                    'row_number' => $row['row_number'],
                    'status' => 'error',
                    'message' => 'Row failed and was skipped: ' . $e->getMessage(),
                    'payload' => $row,
                ]);
            }
        }

        // Flush logs
        foreach (array_chunk($pendingRowLogs, 500) as $chunk) {
            BulkImportRow::insert($chunk);
        }

        $batch->update([
            'created_count' => $created,
            'duplicate_count' => $duplicates,
            'error_count' => $errors,
            'status' => 'completed',
        ]);

        // Log the audit trail - using Log instead of Helper
        Log::info("Bulk Import Completed ({$roleSlug})", [
            'batch_id' => $batch->id,
            'created' => $created,
            'duplicates' => $duplicates,
            'errors' => $errors,
            'user_id' => $me?->id,
            'message' => "Imported {$roleSlug} accounts — {$created} created, {$duplicates} skipped, {$errors} errors."
        ]);

        return [
            'status' => true,
            'message' => 'Import completed successfully.',
            'batch_id' => $batch->id,
            'created' => $created,
            'duplicates' => $duplicates,
            'errors' => $errors,
            'credentials' => $credentials,
        ];
    }

    public function batchRows(BulkImportBatch $batch)
    {
        return response()->json([
            'batch' => $batch,
            'rows' => $batch->rows()->orderBy('row_number')->get(),
        ]);
    }

    /**
     * Enhanced row parsing with support for multiple import types
     */
    private function parseRows(string $absolutePath, string $importType): array
    {
        $reader = new SimpleXlsxReader();
        $sheet = $reader->readFirstSheet($absolutePath);

        if (empty($sheet)) {
            throw new \RuntimeException('The workbook appears to be empty.');
        }

        $highestRow = max(array_keys($sheet));

        return match($importType) {
            'imaam_directory' => $this->parseImaamRows($sheet, $highestRow),
            'district_khadhi' => $this->parseDistrictKhadhiRows($sheet, $highestRow),
            'regional_assistant' => $this->parseRegionalAssistantRows($sheet, $highestRow),
        };
    }

    private function parseImaamRows(array $sheet, int $highestRow): array
    {
        $region = $district = $county = null;
        $rows = [];

        for ($r = 2; $r <= $highestRow; $r++) {
            $line = $sheet[$r] ?? [];
            $cells = [];

            foreach (self::COLUMNS_IMAAM as $i => $key) {
                $cells[$key] = trim($line[$i] ?? '');
            }

            if ($cells['region'] !== '') $region = $cells['region'];
            if ($cells['district'] !== '') $district = $cells['district'];
            if ($cells['county'] !== '') $county = $cells['county'];

            if ($cells['mosque'] === '' && $cells['imaam'] === '') {
                $rows[] = ['type' => 'blank', 'row_number' => $r];
                continue;
            }

            if (!$region || !$district || !$county) {
                $rows[] = [
                    'type' => 'error',
                    'row_number' => $r,
                    'mosque' => $cells['mosque'],
                    'message' => 'Could not determine the Region/District/County for this mosque.',
                ];
                continue;
            }

            $mosqueName = $cells['mosque'] !== '' ? $cells['mosque'] : 'Unspecified Mosque (' . $cells['imaam'] . ')';

            $rows[] = [
                'type' => 'mosque',
                'row_number' => $r,
                'region' => $region,
                'district' => $district,
                'county' => $county,
                'mosque' => $mosqueName,
                'imaam' => $cells['imaam'] !== '' ? $cells['imaam'] : null,
                'contact' => $this->normalizePhone($cells['contact']),
            ];
        }

        return $rows;
    }

    /**
     * Parse District Khadhi rows - columns: Name, District, Region, Contact, Email
     * Excel columns: A=Name, B=District, C=Region, D=Contact, E=Email
     */
    private function parseDistrictKhadhiRows(array $sheet, int $highestRow): array
    {
        $rows = [];

        for ($r = 2; $r <= $highestRow; $r++) {
            $line = $sheet[$r] ?? [];
            
            // Map columns: A=Name, B=District, C=Region, D=Contact, E=Email
            $name = trim($line[0] ?? '');
            $district = trim($line[1] ?? '');
            $region = trim($line[2] ?? '');
            $contact = trim($line[3] ?? '');
            $email = trim($line[4] ?? '');

            // Skip blank rows
            if ($name === '' && $district === '' && $region === '' && $contact === '' && $email === '') {
                $rows[] = ['type' => 'blank', 'row_number' => $r];
                continue;
            }

            // Validate required fields
            if (empty($name)) {
                $rows[] = [
                    'type' => 'error',
                    'row_number' => $r,
                    'message' => 'Missing required field: Name.',
                    'full_name' => null,
                    'district' => $district,
                    'region' => $region,
                    'contact' => $this->normalizePhone($contact),
                    'email' => $email,
                ];
                continue;
            }

            if (empty($district)) {
                $rows[] = [
                    'type' => 'error',
                    'row_number' => $r,
                    'message' => 'Missing required field: District.',
                    'full_name' => $name,
                    'district' => null,
                    'region' => $region,
                    'contact' => $this->normalizePhone($contact),
                    'email' => $email,
                ];
                continue;
            }

            if (empty($region)) {
                $rows[] = [
                    'type' => 'error',
                    'row_number' => $r,
                    'message' => 'Missing required field: Region.',
                    'full_name' => $name,
                    'district' => $district,
                    'region' => null,
                    'contact' => $this->normalizePhone($contact),
                    'email' => $email,
                ];
                continue;
            }

            // Valid row
            $rows[] = [
                'type' => 'user',
                'row_number' => $r,
                'full_name' => $name,
                'district' => $district,
                'region' => $region,
                'contact' => $this->normalizePhone($contact),
                'email' => $email ?: null,
            ];
        }

        return $rows;
    }

    /**
     * Parse Regional Assistant rows - columns: Name, Region, Contact, Email
     * Excel columns: A=Name, B=Region, C=Contact, D=Email
     */
    private function parseRegionalAssistantRows(array $sheet, int $highestRow): array
    {
        $rows = [];

        for ($r = 2; $r <= $highestRow; $r++) {
            $line = $sheet[$r] ?? [];
            
            // Map columns: A=Name, B=Region, C=Contact, D=Email
            $name = trim($line[0] ?? '');
            $region = trim($line[1] ?? '');
            $contact = trim($line[2] ?? '');
            $email = trim($line[3] ?? '');

            // Skip blank rows
            if ($name === '' && $region === '' && $contact === '' && $email === '') {
                $rows[] = ['type' => 'blank', 'row_number' => $r];
                continue;
            }

            // Validate required fields
            if (empty($name)) {
                $rows[] = [
                    'type' => 'error',
                    'row_number' => $r,
                    'message' => 'Missing required field: Name.',
                    'full_name' => null,
                    'region' => $region,
                    'contact' => $this->normalizePhone($contact),
                    'email' => $email,
                ];
                continue;
            }

            if (empty($region)) {
                $rows[] = [
                    'type' => 'error',
                    'row_number' => $r,
                    'message' => 'Missing required field: Region.',
                    'full_name' => $name,
                    'region' => null,
                    'contact' => $this->normalizePhone($contact),
                    'email' => $email,
                ];
                continue;
            }

            // Valid row
            $rows[] = [
                'type' => 'user',
                'row_number' => $r,
                'full_name' => $name,
                'region' => $region,
                'contact' => $this->normalizePhone($contact),
                'email' => $email ?: null,
            ];
        }

        return $rows;
    }

    private function buildSummary(array $rows, string $importType): array
    {
        $summary = [
            'total_rows' => count($rows),
            'valid_rows' => 0,
            'errors' => 0,
        ];

        foreach ($rows as $row) {
            if ($row['type'] === 'blank') continue;
            if ($row['type'] === 'error') {
                $summary['errors']++;
                continue;
            }
            $summary['valid_rows']++;
        }

        // Role-specific summary fields
        if ($importType === 'imaam_directory') {
            $summary['mosques_found'] = collect($rows)->where('type', 'mosque')->count();
            $summary['with_imaam'] = collect($rows)->where('type', 'mosque')->whereNotNull('imaam')->count();
            $summary['context_errors'] = $summary['errors'];
        } else {
            $summary['accounts_to_create'] = $summary['valid_rows'];
        }

        return $summary;
    }

    /**
     * Normalize phone numbers (add leading zero for 9-digit numbers)
     */
    private function normalizePhone(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $digits = preg_replace('/\D/', '', $value);

        if ($digits === '') {
            return null;
        }

        if (strlen($digits) === 9) {
            return '0' . $digits;
        }

        return $digits;
    }

    /**
     * Username = first name only, lowercased, with suffix on collision
     */
    private function generateUsername(string $fullName, array &$usedUsernames): string
    {
        $firstName = trim(preg_split('/\s+/', trim($fullName))[0] ?? '');
        $base = Str::slug($firstName, '');
        $base = $base !== '' ? $base : 'user';

        $candidate = $base;
        $suffix = 2;

        while (isset($usedUsernames[$candidate])) {
            $candidate = $base . $suffix;
            $suffix++;
        }

        return $candidate;
    }

    /**
     * Generate a 4-digit temporary password
     */
    private function generateTempPassword(): string
    {
        return (string) random_int(1000, 9999);
    }
}