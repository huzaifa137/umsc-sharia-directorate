<?php

namespace App\Services;

use App\Models\ConvertApplication;
use App\Models\DivorceApplication;
use App\Models\GuardianshipApplication;
use App\Models\InheritanceApplication;
use App\Models\NikkahApplication;
use Carbon\Carbon;

/**
 * Single source of truth for what a "report" looks like per module — used
 * by both the on-screen preview table and the PDF/CSV/Word exporters, so
 * they never drift out of sync with each other.
 */
class ReportDefinitions
{
    public static function modules(): array
    {
        return [
            'nikah' => 'Nikah',
            'divorce' => 'Divorce',
            'inheritance' => 'Inheritance',
            'guardianship' => 'Guardianship',
            'convert' => 'Converts',
        ];
    }

    public static function for(string $module): array
    {
        return match ($module) {
            'nikah' => [
                'title' => 'Nikah Applications Report',
                'permission' => 'nikah.view',
                'model' => NikkahApplication::class,
                'statusOptions' => ['submitted' => 'Submitted', 'approved' => 'Approved', 'rejected' => 'Rejected'],
                'columns' => [
                    ['key' => 'application_id', 'label' => 'Application ID', 'weight' => 1.3],
                    ['key' => 'groom', 'label' => 'Groom', 'weight' => 1.4],
                    ['key' => 'bride', 'label' => 'Bride', 'weight' => 1.4],
                    ['key' => 'district', 'label' => 'District', 'weight' => 1.1],
                    ['key' => 'status', 'label' => 'Status', 'weight' => 0.8],
                    ['key' => 'date', 'label' => 'Date', 'weight' => 0.9],
                ],
                'map' => fn ($a) => [
                    'application_id' => $a->application_id,
                    'groom' => trim(($a->groom_given_name ?? '') . ' ' . ($a->groom_surname ?? '')),
                    'bride' => trim(($a->bride_given_name ?? '') . ' ' . ($a->bride_surname ?? '')),
                    'district' => $a->officer_district ?? '-',
                    'status' => ucfirst($a->status ?? '-'),
                    'date' => optional($a->created_at)->format('d M Y') ?? '-',
                ],
            ],

            'divorce' => [
                'title' => 'Divorce Applications Report',
                'permission' => 'divorce.view',
                'model' => DivorceApplication::class,
                'statusOptions' => ['submitted' => 'Submitted', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'columns' => [
                    ['key' => 'application_id', 'label' => 'Application ID', 'weight' => 1.3],
                    ['key' => 'husband', 'label' => 'Husband', 'weight' => 1.3],
                    ['key' => 'wife', 'label' => 'Wife', 'weight' => 1.3],
                    ['key' => 'type', 'label' => 'Type', 'weight' => 0.9],
                    ['key' => 'district', 'label' => 'District', 'weight' => 1.1],
                    ['key' => 'status', 'label' => 'Status', 'weight' => 0.8],
                    ['key' => 'date', 'label' => 'Date', 'weight' => 0.9],
                ],
                'map' => fn ($a) => [
                    'application_id' => $a->application_id,
                    'husband' => trim(($a->groom_given_name ?? '') . ' ' . ($a->groom_surname ?? '')),
                    'wife' => trim(($a->bride_given_name ?? '') . ' ' . ($a->bride_surname ?? '')),
                    'type' => ucfirst($a->divorce_type ?? '-'),
                    'district' => $a->officer_district ?? '-',
                    'status' => ucfirst($a->status ?? '-'),
                    'date' => optional($a->created_at)->format('d M Y') ?? '-',
                ],
            ],

            'inheritance' => [
                'title' => 'Inheritance Applications Report',
                'permission' => 'inheritance.view',
                'model' => InheritanceApplication::class,
                'statusOptions' => ['submitted' => 'Submitted', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'columns' => [
                    ['key' => 'application_id', 'label' => 'Application ID', 'weight' => 1.2],
                    ['key' => 'deceased', 'label' => 'Deceased', 'weight' => 1.3],
                    ['key' => 'applicant', 'label' => 'Applicant', 'weight' => 1.3],
                    ['key' => 'estate_value', 'label' => 'Estate Value (UGX)', 'weight' => 1.2],
                    ['key' => 'district', 'label' => 'District', 'weight' => 1.0],
                    ['key' => 'status', 'label' => 'Status', 'weight' => 0.8],
                    ['key' => 'date', 'label' => 'Date', 'weight' => 0.9],
                ],
                'map' => fn ($a) => [
                    'application_id' => $a->application_id,
                    'deceased' => $a->deceased_name ?? '-',
                    'applicant' => $a->applicant_name ?? '-',
                    'estate_value' => $a->total_estate_value !== null ? number_format((float) $a->total_estate_value) : '-',
                    'district' => $a->officer_district ?? '-',
                    'status' => ucfirst($a->status ?? '-'),
                    'date' => optional($a->created_at)->format('d M Y') ?? '-',
                ],
            ],

            'guardianship' => [
                'title' => 'Guardianship Applications Report',
                'permission' => 'guardianship.view',
                'model' => GuardianshipApplication::class,
                'statusOptions' => ['pending' => 'Pending', 'active' => 'Active', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'columns' => [
                    ['key' => 'application_id', 'label' => 'Application ID', 'weight' => 1.2],
                    ['key' => 'ward', 'label' => 'Ward', 'weight' => 1.2],
                    ['key' => 'guardian', 'label' => 'Guardian', 'weight' => 1.2],
                    ['key' => 'relationship', 'label' => 'Relationship', 'weight' => 1.0],
                    ['key' => 'district', 'label' => 'District', 'weight' => 1.0],
                    ['key' => 'status', 'label' => 'Status', 'weight' => 0.8],
                    ['key' => 'date', 'label' => 'Date', 'weight' => 0.9],
                ],
                'map' => fn ($a) => [
                    'application_id' => $a->application_id,
                    'ward' => $a->ward_name ?? '-',
                    'guardian' => $a->guardian_name ?? '-',
                    'relationship' => $a->relationship_to_ward ?? '-',
                    'district' => $a->officer_district ?? '-',
                    'status' => ucfirst($a->status ?? '-'),
                    'date' => optional($a->created_at)->format('d M Y') ?? '-',
                ],
            ],

            'convert' => [
                'title' => 'Convert Applications Report',
                'permission' => 'convert.view',
                'model' => ConvertApplication::class,
                'statusOptions' => ['pending' => 'Pending', 'accomplished' => 'Accomplished', 'rejected' => 'Rejected'],
                'columns' => [
                    ['key' => 'application_id', 'label' => 'Application ID', 'weight' => 1.2],
                    ['key' => 'former_name', 'label' => 'Former Name', 'weight' => 1.3],
                    ['key' => 'new_name', 'label' => 'New Name', 'weight' => 1.3],
                    ['key' => 'former_religion', 'label' => 'Former Religion', 'weight' => 1.1],
                    ['key' => 'district', 'label' => 'District', 'weight' => 1.0],
                    ['key' => 'status', 'label' => 'Status', 'weight' => 0.8],
                    ['key' => 'date', 'label' => 'Date', 'weight' => 0.9],
                ],
                'map' => fn ($a) => [
                    'application_id' => $a->application_id,
                    'former_name' => $a->former_names ?? '-',
                    'new_name' => $a->new_names ?? '-',
                    'former_religion' => $a->former_religion ?? '-',
                    'district' => $a->officer_district ?? '-',
                    'status' => ucfirst($a->status ?? '-'),
                    'date' => optional($a->created_at)->format('d M Y') ?? '-',
                ],
            ],

            default => throw new \InvalidArgumentException("Unknown report module: {$module}"),
        };
    }

    /**
     * Apply the standard set of report filters (status + date range) on top
     * of whatever jurisdiction scope the caller has already applied.
     */
    public static function applyFilters($query, array $filters)
    {
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', Carbon::parse($filters['date_from']));
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', Carbon::parse($filters['date_to']));
        }

        return $query;
    }
}
