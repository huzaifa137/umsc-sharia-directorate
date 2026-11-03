<?php

namespace App\Services;

use App\Models\ConvertApplication;
use App\Models\DivorceApplication;
use App\Models\GuardianshipApplication;
use App\Models\InheritanceApplication;
use App\Models\NikkahApplication;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * Describes how each module's record is laid out on the shared record page
 * (/records/{module}/{id}). Nothing here touches the database schema: it only
 * maps existing columns to labelled sections.
 *
 * Field shape: [label, column | [columns], type?, separator?]
 * Types: text (default), date, dmy, phone, nin, yesno, money, long, address, chips
 */
class RecordSchema
{
    public const MODULES = ['nikah', 'divorce', 'inheritance', 'guardianship', 'convert'];

    public static function has(string $module): bool
    {
        return in_array($module, self::MODULES, true);
    }

    public static function for(string $module): array
    {
        return match ($module) {
            'nikah' => self::nikah(),
            'divorce' => self::divorce(),
            'inheritance' => self::inheritance(),
            'guardianship' => self::guardianship(),
            'convert' => self::convert(),
        };
    }

    /* ------------------------------------------------------------------
     * Module definitions
     * ------------------------------------------------------------------ */

    private static function nikah(): array
    {
        $person = fn (string $p, string $nin, string $phone) => [
            ['Full name', [$p . '_given_name', $p . '_surname'], 'text', ' '],
            ['National ID (NIN)', $nin, 'nin'],
            ['Date of birth', [$p . '_day_date_of_birth', $p . '_month_date_of_birth', $p . '_year_date_of_birth'], 'dmy'],
            ['Telephone', $phone, 'phone'],
            ['Email', $p . '_email'],
            ['Tribe', $p . '_tribe'],
            ['Country', $p . '_country'],
            ['Residence', [$p . '_village', $p . '_parish', $p . '_sub_county', $p . '_county', $p . '_district'], 'address'],
            ['Plot', $p . '_plot'],
        ];

        $parent = fn (string $statusCol, string $given, string $sur, string $nin, string $district, ?string $extra = null, string $extraLabel = '') => array_values(array_filter([
            ['Status', $statusCol],
            ['Name', [$given, $sur], 'text', ' '],
            $extra ? [$extraLabel, $extra] : null,
            ['National ID (NIN)', $nin, 'nin'],
            ['District', $district],
        ]));

        $witness = fn (int $n) => [
            ['Full name', ["witness{$n}_given_name", "witness{$n}_surname"], 'text', ' '],
            ['National ID (NIN)', "witness{$n}_nin", 'nin'],
            ['Telephone', "witness{$n}_telephone", 'phone'],
            ['Address', "witness{$n}_address"],
            ['District', "witness{$n}District"],
        ];

        return [
            'label' => 'Nikah',
            'noun' => 'Marriage registration',
            'icon' => 'bx-heart',
            'model' => NikkahApplication::class,
            'permission' => 'nikah',
            'list' => 'nikah-status-applications/0',
            'dashboard' => 'nikah-dashboard',
            'certificate' => 'nikah',
            'status' => [
                'url' => '/applications/{id}/update-status',
                'options' => ['submitted' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'],
                // The Nikah endpoint only accepts pending|approved|rejected, and 'pending' is not the
                // stored "awaiting" value ('submitted'), so reverting is not offered here.
                'offer' => ['approved', 'rejected'],
                'done' => ['approved'],
            ],
            'title' => fn ($r) => self::pair(
                self::join($r->groom_given_name, $r->groom_surname),
                self::join($r->bride_given_name, $r->bride_surname)
            ),
            'facts' => fn ($r) => [
                ['Groom', self::join($r->groom_given_name, $r->groom_surname)],
                ['Bride', self::join($r->bride_given_name, $r->bride_surname)],
                ['Imam', $r->imam_name],
                ['Masjid', $r->masjid_name ?? null],
            ],
            'sections' => [
                ['id' => 'groom', 'title' => 'Groom', 'fields' => $person('groom', 'groomNIN', 'groom_telephone')],
                ['id' => 'bride', 'title' => 'Bride', 'fields' => $person('bride', 'brideNIN', 'bride_telephone')],
                ['id' => 'groom-family', 'title' => "Groom's parents", 'groups' => [
                    ['Father', $parent('groomFatherStatus', 'groom_father_given_name', 'groom_father_surname', 'groom_father_nin', 'groomFatherDistrict', 'groomFatherTribe', 'Tribe')],
                    ['Mother', $parent('groomMotherStatus', 'groom_mother_given_name', 'groom_mother_surname', 'groomMotherNIN', 'groomMotherDistrict', 'groomMotherMaidenName', 'Maiden name')],
                ]],
                ['id' => 'bride-family', 'title' => "Bride's parents", 'groups' => [
                    ['Father', $parent('brideFatherStatus', 'bride_father_given_name', 'bride_father_surname', 'brideFatherNIN', 'brideFatherDistrict', 'brideFatherTribe', 'Tribe')],
                    ['Mother', $parent('brideMotherStatus', 'bride_mother_given_name', 'bride_mother_surname', 'brideMotherNIN', 'brideMotherDistrict', 'brideMotherMaidenName', 'Maiden name')],
                ]],
                ['id' => 'witnesses', 'title' => 'Witnesses', 'groups' => [
                    ['First witness', $witness(1)],
                    ['Second witness', $witness(2)],
                ]],
                ['id' => 'solemnisation', 'title' => 'Solemnisation and dowry', 'fields' => [
                    ['Officiating Imam', 'imam_name'],
                    ['Masjid', 'masjid_name'],
                    ['Dowry type', 'dowery_type'],
                    ['Dowry details', 'dowery_specify', 'long'],
                ]],
            ],
            'files' => [
                ['Groom photo', 'groom_photo_path', 'image'],
                ['Bride photo', 'bride_photo_path', 'image'],
            ],
        ];
    }

    private static function divorce(): array
    {
        $spouse = fn (string $p) => [
            ['Full name', [$p . '_given_name', $p . '_surname'], 'text', ' '],
            ['National ID (NIN)', $p . '_nin', 'nin'],
            ['Telephone', $p . '_phone', 'phone'],
            ['Email', $p . '_email'],
            ['Tribe', $p . '_tribe'],
            ['Residence', [$p . '_village', $p . '_parish', $p . '_sub_county', $p . '_municipality', $p . '_district'], 'address'],
            ['Plot number', $p . '_plot_number'],
        ];
        $witness = fn (string $p) => [
            ['Full name', [$p . '_given_name', $p . '_surname'], 'text', ' '],
            ['National ID (NIN)', $p . '_nin', 'nin'],
            ['Telephone', $p . '_phone', 'phone'],
            ['Address', $p . '_address'],
        ];

        return [
            'label' => 'Divorce',
            'noun' => 'Divorce registration',
            'icon' => 'bx-unlink',
            'model' => DivorceApplication::class,
            'permission' => 'divorce',
            'list' => 'divorce-status-applications/0',
            'dashboard' => 'divorce-dashboard',
            'certificate' => 'divorce',
            'edit' => 'divorce/{id}/edit',
            'status' => [
                'url' => '/divorce-status-update/{id}',
                'options' => ['submitted' => 'Pending', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'done' => ['accomplished'],
            ],
            'title' => fn ($r) => self::pair(
                self::join($r->groom_given_name, $r->groom_surname),
                self::join($r->bride_given_name, $r->bride_surname)
            ),
            'facts' => fn ($r) => [
                ['Husband', self::join($r->groom_given_name, $r->groom_surname)],
                ['Wife', self::join($r->bride_given_name, $r->bride_surname)],
                ['Type', $r->divorce_type ? Str::headline($r->divorce_type) : null],
                ['Imam', $r->imam_name],
            ],
            'sections' => [
                ['id' => 'husband', 'title' => 'Husband', 'fields' => $spouse('groom')],
                ['id' => 'wife', 'title' => 'Wife', 'fields' => $spouse('bride')],
                ['id' => 'divorce', 'title' => 'Divorce details', 'fields' => [
                    ['Type of divorce', 'divorce_type', 'headline'],
                    ['Talaq count', 'talaq_count'],
                    ['Initiated by', 'divorce_initiated_by', 'headline'],
                    ['Place', 'divorce_place'],
                    ['Reason', 'divorce_reason', 'long'],
                ]],
                ['id' => 'children', 'title' => 'Children and custody', 'fields' => [
                    ['Children involved', 'children_involved', 'yesno'],
                    ['Number of children', 'num_children'],
                    ['Custody arrangement', 'custody_arrangement', 'long'],
                ]],
                ['id' => 'witnesses', 'title' => 'Witnesses', 'groups' => [
                    ['First witness', $witness('w1')],
                    ['Second witness', $witness('w2')],
                ]],
                ['id' => 'verification', 'title' => 'Verification', 'fields' => [
                    ['Imam', 'imam_name'],
                    ['Imam registration', 'imam_reg'],
                    ['Qadhi area', 'qadhi_area'],
                    ['Mosque', 'mosque_name'],
                ]],
            ],
            'files' => [
                ['Husband photo', 'groom_photo_path', 'image'],
                ['Wife photo', 'bride_photo_path', 'image'],
            ],
        ];
    }

    private static function inheritance(): array
    {
        return [
            'label' => 'Inheritance',
            'noun' => 'Estate and inheritance',
            'icon' => 'bx-pie-chart-alt',
            'model' => InheritanceApplication::class,
            'permission' => 'inheritance',
            'list' => 'inheritance-status-applications/0',
            'dashboard' => 'inheritance-dashboard',
            'certificate' => 'inheritance',
            'with' => ['properties', 'heirs', 'verification'],
            'status' => [
                'url' => '/inheritance-status-update/{id}',
                'options' => ['submitted' => 'Pending', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'done' => ['accomplished'],
            ],
            'title' => fn ($r) => $r->deceased_name ? 'Estate of ' . $r->deceased_name : '',
            'facts' => fn ($r) => [
                ['Deceased', $r->deceased_name],
                ['Date of death', self::date($r->date_of_death)],
                ['Applicant', $r->applicant_name],
                ['Estate value', self::money($r->total_estate_value)],
            ],
            'sections' => [
                ['id' => 'deceased', 'title' => 'The deceased', 'fields' => [
                    ['Full name', 'deceased_name'],
                    ['National ID (NIN)', 'deceased_nin', 'nin'],
                    ['Gender', 'gender', 'headline'],
                    ['Marital status', 'marital_status', 'headline'],
                    ['Occupation', 'occupation'],
                    ['Date of death', 'date_of_death', 'date'],
                    ['Place of death', 'place_of_death'],
                    ['Cause of death', 'cause_of_death'],
                    ['Last residence', 'last_residence'],
                ]],
                ['id' => 'applicant', 'title' => 'Applicant', 'fields' => [
                    ['Full name', 'applicant_name'],
                    ['Relationship to the deceased', 'relationship', 'headline'],
                    ['National ID (NIN)', 'applicant_nin', 'nin'],
                    ['Telephone', 'applicant_phone', 'phone'],
                ]],
                ['id' => 'estate', 'title' => 'Estate and liabilities', 'fields' => [
                    ['Total estate value', 'total_estate_value', 'money'],
                    ['Outstanding debts', 'outstanding_debts', 'money'],
                    ['Funeral expenses', 'funeral_expenses', 'money'],
                    ['Unpaid zakat', 'unpaid_zakat', 'money'],
                    ['Other liabilities', 'other_liabilities', 'money'],
                ]],
                ['id' => 'properties', 'title' => 'Properties', 'relation' => 'properties', 'columns' => [
                    ['Type', 'type'], ['Description', 'description'], ['Location', 'location'], ['Value', 'value', 'money'],
                ]],
                ['id' => 'heirs', 'title' => 'Heirs', 'relation' => 'heirs', 'single' => true, 'fields' => [
                    ['Spouse', 'spouse_name'],
                    ['Spouse NIN', 'spouse_nin', 'nin'],
                    ['Sons', 'sons_count'],
                    ['Daughters', 'daughters_count'],
                    ['Father', 'father_name'],
                    ['Father alive', 'father_alive', 'yesno'],
                    ['Mother', 'mother_name'],
                    ['Mother alive', 'mother_alive', 'yesno'],
                    ['Full brothers', 'full_brothers'],
                    ['Full sisters', 'full_sisters'],
                    ['Uterine brothers', 'uterine_brothers'],
                    ['Uterine sisters', 'uterine_sisters'],
                    ['Pregnant heir', 'pregnant_heir', 'yesno'],
                    ['Minor heirs', 'minor_heirs', 'yesno'],
                ]],
                ['id' => 'verification', 'title' => 'Verification', 'relation' => 'verification', 'single' => true, 'fields' => [
                    ['Imam', 'imam_name'],
                    ['Imam registration', 'imam_reg_number'],
                    ['Mosque', 'mosque_name'],
                    ['Verified on', 'verification_date', 'date'],
                    ['Notes', 'verification_notes', 'long'],
                ]],
            ],
            'files' => [
                ['Death certificate', 'death_certificate_path', 'document'],
            ],
        ];
    }

    private static function guardianship(): array
    {
        return [
            'label' => 'Guardianship',
            'noun' => 'Guardianship case',
            'icon' => 'bx-shield-quarter',
            'model' => GuardianshipApplication::class,
            'permission' => 'guardianship',
            'list' => 'guardianship-status-applications/0',
            'dashboard' => 'guardianship-dashboard',
            'certificate' => 'guardianship',
            'status' => [
                'url' => '/guardianship-status-update/{id}',
                'options' => ['submitted' => 'Pending', 'active' => 'Active', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'done' => ['accomplished', 'active'],
            ],
            'title' => fn ($r) => (string) $r->ward_name,
            'facts' => fn ($r) => [
                ['Ward', $r->ward_name],
                ['Guardian', $r->guardian_name],
                ['Type', $r->guardianship_type ? Str::headline($r->guardianship_type) : null],
                ['Duration', $r->guardianship_duration ? Str::headline($r->guardianship_duration) : null],
            ],
            'sections' => [
                ['id' => 'ward', 'title' => 'The ward', 'fields' => [
                    ['Full name', 'ward_name'],
                    ['Gender', 'ward_gender', 'headline'],
                    ['Date of birth', 'ward_dob', 'date'],
                    ['Age', 'ward_age'],
                    ['Birth certificate no.', 'birth_certificate_number'],
                    ['Ward type', 'ward_type', 'headline'],
                    ['Guardianship type', 'guardianship_type', 'headline'],
                    ['Education level', 'ward_education_level', 'headline'],
                    ['Health conditions', 'health_conditions', 'long'],
                ]],
                ['id' => 'parents', 'title' => 'Parents', 'groups' => [
                    ['Father', [['Name', 'father_name'], ['Status', 'father_status', 'headline']]],
                    ['Mother', [['Name', 'mother_name'], ['Status', 'mother_status', 'headline']]],
                ]],
                ['id' => 'guardian', 'title' => 'Guardian applicant', 'fields' => [
                    ['Full name', 'guardian_name'],
                    ['Gender', 'guardian_gender', 'headline'],
                    ['Date of birth', 'guardian_dob', 'date'],
                    ['National ID (NIN)', 'guardian_nin', 'nin'],
                    ['Relationship to ward', 'relationship_to_ward', 'headline'],
                    ['Telephone', 'guardian_phone', 'phone'],
                    ['Address', 'guardian_address', 'long'],
                    ['Health status', 'health_status'],
                    ['Criminal record', 'criminal_record', 'headline'],
                    ['Previous experience', 'previous_experience', 'long'],
                    ['Religious background', 'religious_background', 'long'],
                    ['Motivation', 'motivation', 'long'],
                ]],
                ['id' => 'terms', 'title' => 'Terms of guardianship', 'fields' => [
                    ['Duration', 'guardianship_duration', 'headline'],
                    ['Reporting frequency', 'reporting_frequency', 'headline'],
                    ['Powers granted', 'powers_granted', 'chips'],
                    ['Restrictions', 'restrictions', 'long'],
                ]],
                ['id' => 'verification', 'title' => 'Verification', 'fields' => [
                    ['Imam', 'imam_name'],
                    ['Imam registration', 'imam_reg_number'],
                    ['Mosque', 'mosque_name'],
                ]],
                ['id' => 'witnesses', 'title' => 'Witnesses', 'groups' => [
                    ['First witness', [['Name', 'witness1_name'], ['National ID (NIN)', 'witness1_nin', 'nin']]],
                    ['Second witness', [['Name', 'witness2_name'], ['National ID (NIN)', 'witness2_nin', 'nin']]],
                ]],
            ],
            'files' => [
                ['Ward photo', 'ward_photo_path', 'image'],
                ['Guardian photo', 'guardian_photo_path', 'image'],
                ['Birth certificate', 'birth_certificate_path', 'document'],
            ],
        ];
    }

    private static function convert(): array
    {
        return [
            'label' => 'Convert',
            'noun' => 'Conversion registration',
            'icon' => 'bx-user-plus',
            'model' => ConvertApplication::class,
            'permission' => 'convert',
            'list' => 'convert-status-applications/0',
            'dashboard' => 'convert-dashboard',
            'certificate' => 'convert',
            'status' => [
                'url' => '/convert-status-update/{id}',
                'options' => ['pending' => 'Pending', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'done' => ['accomplished'],
            ],
            'title' => fn ($r) => (string) ($r->new_names ?: $r->former_names),
            'facts' => fn ($r) => [
                ['Former name', $r->former_names],
                ['New name', $r->new_names],
                ['Former religion', $r->former_religion],
                ['Converted on', self::date($r->conversion_date)],
            ],
            'sections' => [
                ['id' => 'person', 'title' => 'The convert', 'fields' => [
                    ['Former name', 'former_names'],
                    ['New name', 'new_names'],
                    ['Former religion', 'former_religion'],
                    ['Date of birth', 'date_of_birth', 'date'],
                    ['Occupation', 'occupation'],
                    ['Contact', 'contact', 'phone'],
                    ['Current residence', 'current_residence'],
                    ['Home address', 'home_address'],
                    ['County / District', ['county', 'district'], 'text', ' / '],
                ]],
                ['id' => 'family', 'title' => 'Family', 'fields' => [
                    ['Father', 'father_name'],
                    ['Mother', 'mother_name'],
                ]],
                ['id' => 'conversion', 'title' => 'Conversion', 'fields' => [
                    ['Date of conversion', 'conversion_date', 'date'],
                    ['Place of conversion', 'conversion_place'],
                    ['Reasons', 'conversion_reasons', 'long'],
                    ['Declaration date', 'declaration_date', 'date'],
                    ['Declaration agreed', 'declaration_agreement', 'yesno'],
                ]],
                ['id' => 'guardian', 'title' => 'Sponsor', 'fields' => [
                    ['Name', 'guardian_name'],
                    ['Occupation', 'guardian_occupation'],
                    ['Declaration date', 'guardian_declaration_date', 'date'],
                    ['Declaration', 'guardian_declaration', 'long'],
                ]],
                ['id' => 'verification', 'title' => 'Officer verification', 'fields' => [
                    ['Officer', 'officer_name'],
                    ['Position', 'officer_position'],
                    ['Registration number', 'registration_number'],
                    ['Verified on', 'verification_date', 'date'],
                    ['Remarks', 'officer_remarks', 'long'],
                ]],
            ],
            'files' => [],
        ];
    }

    /* ------------------------------------------------------------------
     * Value formatting
     * ------------------------------------------------------------------ */

    /** Read one field off a record and return ['text' => string|null, 'kind' => type, 'raw' => mixed]. */
    public static function read($record, array $field): array
    {
        [$label, $cols] = $field;
        $type = $field[2] ?? 'text';
        $sep = $field[3] ?? ', ';

        $vals = [];
        foreach ((array) $cols as $c) {
            $v = $record->{$c} ?? null;
            if (is_string($v)) {
                $v = trim($v);
            }
            if ($v !== null && $v !== '' && $v !== []) {
                $vals[] = $v;
            }
        }

        if (!$vals) {
            return ['label' => $label, 'text' => null, 'kind' => $type, 'raw' => null];
        }

        $first = $vals[0];

        $text = match ($type) {
            'date' => self::date($first),
            'dmy' => self::dmy($vals),
            'yesno' => self::yesno($first),
            'money' => self::money($first),
            'headline' => Str::headline((string) $first),
            'chips' => implode(', ', array_map(fn ($v) => Str::headline((string) $v), (array) $first)),
            default => implode($sep, array_map('strval', $vals)),
        };

        return ['label' => $label, 'text' => $text, 'kind' => $type, 'raw' => $first];
    }

    public static function join(...$parts): string
    {
        return trim(implode(' ', array_filter(array_map(fn ($p) => trim((string) $p), $parts))));
    }

    private static function pair(string $a, string $b): string
    {
        return trim($a . ($a && $b ? ' & ' : '') . $b);
    }

    public static function date($v): ?string
    {
        if (!$v) {
            return null;
        }
        try {
            return Carbon::parse($v)->format('d M Y');
        } catch (\Throwable $e) {
            return (string) $v;
        }
    }

    private static function dmy(array $parts): ?string
    {
        // Nikah stores day, month and year in three columns.
        if (count($parts) < 3) {
            return implode(' ', array_map('strval', $parts));
        }
        [$d, $m, $y] = $parts;
        if (is_numeric($m) && (int) $m >= 1 && (int) $m <= 12) {
            $m = Carbon::create(2000, (int) $m, 1)->format('M');
        }

        return trim("{$d} {$m} {$y}");
    }

    private static function yesno($v): string
    {
        if (is_string($v)) {
            $l = strtolower($v);
            if (in_array($l, ['yes', 'y', 'true', '1'], true)) {
                return 'Yes';
            }
            if (in_array($l, ['no', 'n', 'false', '0'], true)) {
                return 'No';
            }

            return Str::headline($v);
        }

        return $v ? 'Yes' : 'No';
    }

    public static function money($v): ?string
    {
        if ($v === null || $v === '') {
            return null;
        }

        return is_numeric($v) ? 'UGX ' . number_format((float) $v) : (string) $v;
    }
}
