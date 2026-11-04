<?php

namespace App\Services;

use App\Http\Controllers\CertificateController;
use App\Models\ConsultancyApplication;
use Carbon\Carbon;

/**
 * Public certificate verification.
 *
 * Every printed certificate carries a QR code that opens
 * /certificates/verify/{type}/{id}?c={code}. The code is an HMAC of the
 * certificate type and id, keyed with the application key, so a person who
 * only knows a record id cannot forge a link that shows as "verified".
 *
 * The public page never prints full names: parties are masked, and nothing
 * else about the record leaves the building.
 */
class CertificateVerifier
{
    public const CONSULTANCY = 'consultancy';

    /** Statuses at which each type counts as an issued certificate. */
    private const CONSULTANCY_ISSUED = ['approved', 'accomplished'];

    public static function types(): array
    {
        return array_merge(array_keys(CertificateController::registry()), [self::CONSULTANCY]);
    }

    public static function code(string $type, $id): string
    {
        $hash = strtoupper(substr(hash_hmac('sha256', $type . '|' . $id, (string) config('app.key')), 0, 8));

        return substr($hash, 0, 4) . '-' . substr($hash, 4, 4);
    }

    public static function url(string $type, $id): string
    {
        return url('/certificates/verify/' . $type . '/' . $id . '?c=' . self::code($type, $id));
    }

    public static function codeMatches(string $type, $id, ?string $given): bool
    {
        $given = strtoupper(trim((string) $given));

        return $given !== '' && hash_equals(self::code($type, $id), $given);
    }

    /**
     * The date printed as "Date of issue". Prefers the date the record was
     * signed or concluded, and only falls back to when it was last saved, so
     * reprinting a certificate next year does not change what it says.
     */
    public static function issuedOn($record): Carbon
    {
        foreach (['signed_at', 'conversion_date', 'guardianship_date', 'updated_at', 'created_at'] as $field) {
            $value = $record->{$field} ?? null;
            if ($value) {
                return Carbon::parse($value);
            }
        }

        return Carbon::now();
    }

    /** "Aisha Namutebi" becomes "A••• N•••". */
    public static function maskName(?string $name): string
    {
        $words = preg_split('/\s+/u', trim((string) $name), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        return implode(' ', array_map(
            fn ($w) => mb_substr($w, 0, 1) . '•••',
            array_slice($words, 0, 6)
        ));
    }

    /**
     * Look a certificate up. Returns null when no such record exists,
     * otherwise a small array describing it. `issued` is false when the
     * record exists but has not reached a certificate-eligible status.
     */
    public static function find(string $type, int $id): ?array
    {
        if ($type === self::CONSULTANCY) {
            $record = ConsultancyApplication::find($id);
            if (! $record) {
                return null;
            }

            return [
                'type' => $type,
                'label' => 'Consultation',
                'record' => $record,
                'reference' => $record->application_id,
                'issued' => in_array($record->status, self::CONSULTANCY_ISSUED, true),
                'parties' => [self::maskName($record->applicant_name)],
                'place' => $record->officer_district,
                'on' => self::issuedOn($record),
            ];
        }

        $registry = CertificateController::registry();
        if (! isset($registry[$type])) {
            return null;
        }

        $module = $registry[$type];
        $record = $module['model']::find($id);
        if (! $record) {
            return null;
        }

        $parties = [];
        if (in_array($type, ['nikah', 'divorce'], true)) {
            $parties = [
                self::maskName(trim($record->groom_given_name . ' ' . $record->groom_surname)),
                self::maskName(trim($record->bride_given_name . ' ' . $record->bride_surname)),
            ];
        } elseif ($type === 'inheritance') {
            $parties = [self::maskName($record->deceased_name)];
        } elseif ($type === 'guardianship') {
            $parties = [self::maskName($record->ward_name)];
        } elseif ($type === 'convert') {
            $parties = [self::maskName($record->new_names ?: $record->former_names)];
        }

        return [
            'type' => $type,
            'label' => $module['label'],
            'record' => $record,
            'reference' => $record->application_id ?? ('UMSC-' . strtoupper($type) . '-' . $record->id),
            'issued' => in_array($record->status, $module['completed_status'], true),
            'parties' => $parties,
            'place' => $record->officer_district ?? null,
            'on' => self::issuedOn($record),
        ];
    }

    /** Find a record by the reference number printed on the certificate. */
    public static function findByReference(string $type, string $reference): ?array
    {
        $reference = trim($reference);
        if ($reference === '' || ! in_array($type, self::types(), true)) {
            return null;
        }

        $model = $type === self::CONSULTANCY
            ? ConsultancyApplication::class
            : (CertificateController::registry()[$type]['model'] ?? null);

        $record = $model ? $model::where('application_id', $reference)->first() : null;

        return $record ? self::find($type, (int) $record->id) : null;
    }
}
