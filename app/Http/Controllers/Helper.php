<?php
namespace App\Http\Controllers;


use App\Models\SearchIndex;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

class Helper extends Controller
{

    public static function app_name()
    {
        return $appname = 'UMSC';
    }


    public static function logged_username()
    {
        return $username = DB::table('users')->where('id', Session('LoggedAdmin'))->value('username');
    }

    public static function fullname()
    {
        return DB::table('users')
            ->where('id', Session('LoggedAdmin'))
            ->value(DB::raw("CONCAT(firstname, ' ', lastname) as fullname"));
    }

    /**
     * Display name of the role of the currently logged in user, reading
     * from the new `roles` table (via `role_id`) and falling back to the
     * legacy integer `user_role` mapping for any record that was never
     * migrated onto the new role system.
     */
    public static function activerUSerRole()
    {
        $user = DB::table('users')->where('id', Session('LoggedAdmin'))->first();

        if (!$user) {
            return 'Un Known';
        }

        if ($user->role_id) {
            $name = DB::table('roles')->where('id', $user->role_id)->value('name');
            if ($name) {
                return $name;
            }
        }

        return self::legacyRoleName($user->user_role);
    }

    public static function generateApplicationId()
    {
        $prefix = 'UMSC';
        $dateTime = now()->format('ymdH'); // YYMMDDHH
        $random = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);

        return $prefix . $dateTime . $random;
    }

    /**
     * Legacy helper kept for any historic record that only ever had the old
     * integer `user_role` column populated (no `role_id`). New code should
     * read a user's role through $user->role / $user->role_name instead.
     */
    public static function getUserRole($legacyRoleId)
    {
        return self::legacyRoleName($legacyRoleId);
    }

    public static function getIconForRole($legacyRoleId)
    {
        switch ($legacyRoleId) {
            case 1:
                return 'bx-user-check'; // Imaam
            case 2:
                return 'bx-buildings'; // District Qadh
            case 3:
                return 'bx-crown'; // Directorate Sharia
            case 4:
                return 'bx-map-alt'; // Regional Assistant
            default:
                return 'bx-user'; // Default icon
        }
    }

    private static function legacyRoleName($roleId)
    {
        switch ($roleId) {
            case 1:
                return 'Imaam'; // Imaam
            case 2:
                return 'District Qadh'; // District Qadh
            case 3:
                return 'Directorate Sharia'; // Directorate Sharia
            case 4:
                return 'Regional Assistant'; // Regional Assistant
            default:
                return 'Un Known'; // Default icon
        }
    }

    public static function auditTrail(
        string $action,
        string $targetType = null,
        int $targetId = null,
        string $status = 'success',
        array $oldValues = null,
        array $newValues = null,
        string $description = null
    ) {
        $adminId = Session::get('LoggedAdmin');

        $admin = $adminId
            ? DB::table('users')->where('id', $adminId)->first()
            : null;

        $roleLabel = 'System';
        if ($admin) {
            $roleLabel = $admin->role_id
                ? (DB::table('roles')->where('id', $admin->role_id)->value('name') ?? self::legacyRoleName($admin->user_role))
                : self::legacyRoleName($admin->user_role);
        }

        ActivityLog::create([
            'user_id' => $admin->id ?? null,
            'user_role' => $roleLabel,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'status' => $status,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
        ]);
    }

    public static function syncSearchIndex(array $data)
    {
        $admin = Session::get('LoggedAdmin')
            ? DB::table('users')->where('id', Session::get('LoggedAdmin'))->first()
            : null;

        SearchIndex::updateOrCreate(
            [
                'module' => $data['module'],
                'reference_id' => $data['reference_id'],
            ],
            [
                'application_id' => $data['application_id'],
                'title' => $data['title'],
                'keywords' => $data['keywords'],
                'status' => $data['status'],
                'application_date' => $data['application_date'],
                'required_role' => $data['required_role'] ?? null,
                'created_by' => $admin->id ?? null,
                'officer_district' => $admin->district ?? null,
                'officer_county' => $admin->county ?? null,
            ]
        );
    }

    public static function removeFromSearchIndex(string $module, int $referenceId)
    {
        SearchIndex::where('module', $module)
            ->where('reference_id', $referenceId)
            ->delete();
    }

    /**
     * A human-readable "who/what this certificate is about" string for the
     * Director's Certificates dashboard table — each module names its
     * records differently (groom & bride, deceased & applicant, ward &
     * guardian, etc.) so this centralises the per-type formatting.
     */
    public static function certificateDisplayName(string $type, $record): string
    {
        return match ($type) {
            'nikah' => trim("{$record->groom_given_name} {$record->groom_surname}")
                . ' & ' . trim("{$record->bride_given_name} {$record->bride_surname}"),
            'divorce' => trim("{$record->groom_given_name} {$record->groom_surname}")
                . ' & ' . trim("{$record->bride_given_name} {$record->bride_surname}"),
            'inheritance' => "Estate of {$record->deceased_name}"
                . ($record->applicant_name ? " (applicant: {$record->applicant_name})" : ''),
            'guardianship' => trim((string) $record->ward_name)
                . ($record->guardian_name ? " (guardian: {$record->guardian_name})" : ''),
            'convert' => trim((string) $record->former_names)
                . ($record->new_names ? " (now {$record->new_names})" : ''),
            default => (string) ($record->application_id ?? $record->id),
        };
    }
}
