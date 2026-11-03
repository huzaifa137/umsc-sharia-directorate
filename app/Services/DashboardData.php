<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\ConsultancyApplication;
use App\Models\ConvertApplication;
use App\Models\DivorceApplication;
use App\Models\Fatwa;
use App\Models\GuardianshipApplication;
use App\Models\InheritanceApplication;
use App\Models\NikkahApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Throwable;

/**
 * Builds everything the role-aware staff dashboard shows.
 *
 * Every query goes through AccessControl::scopeApplications(), so an Imaam
 * only ever sees their own records, a Khadhi their district, and so on.
 * Modules the user has no ".view" permission for are left out entirely.
 * Each block is wrapped so one failing query can never take the page down.
 */
class DashboardData
{
    /**
     * Module definitions. `pending` / `done` / `rejected` are the status values
     * each module actually uses in the database.
     */
    private const MODULES = [
        'nikah' => [
            'model' => NikkahApplication::class, 'label' => 'Nikah', 'icon' => 'bx-heart',
            'pending' => ['submitted'], 'done' => ['approved'], 'rejected' => ['rejected'],
            'dashboard' => 'nikah-dashboard', 'create' => 'nikah', 'list' => 'nikah-status-applications/0',
            'color' => '#136a3b',
        ],
        'divorce' => [
            'model' => DivorceApplication::class, 'label' => 'Divorce', 'icon' => 'bx-unlink',
            'pending' => ['submitted'], 'done' => ['accomplished'], 'rejected' => ['rejected'],
            'dashboard' => 'divorce-dashboard', 'create' => 'divorce-application', 'list' => 'divorce-status-applications/0',
            'color' => '#c9a500',
        ],
        'inheritance' => [
            'model' => InheritanceApplication::class, 'label' => 'Inheritance', 'icon' => 'bx-pie-chart-alt',
            'pending' => ['submitted'], 'done' => ['accomplished'], 'rejected' => ['rejected'],
            'dashboard' => 'inheritance-dashboard', 'create' => 'inheritance-application', 'list' => 'inheritance-status-applications/0',
            'color' => '#2f7fa3',
        ],
        'guardianship' => [
            'model' => GuardianshipApplication::class, 'label' => 'Guardianship', 'icon' => 'bx-shield-quarter',
            'pending' => ['submitted'], 'done' => ['accomplished', 'active'], 'rejected' => ['rejected'],
            'dashboard' => 'guardianship-dashboard', 'create' => 'guardianship-application', 'list' => 'guardianship-status-applications/0',
            'color' => '#8a5a9e',
        ],
        'convert' => [
            'model' => ConvertApplication::class, 'label' => 'Converts', 'icon' => 'bx-user-plus',
            'pending' => ['pending'], 'done' => ['accomplished'], 'rejected' => ['rejected'],
            'dashboard' => 'convert-dashboard', 'create' => 'convert-application', 'list' => 'convert-status-applications/0',
            'color' => '#d9722b',
        ],
        'consultancy' => [
            'model' => ConsultancyApplication::class, 'label' => 'Consultancy', 'icon' => 'bx-conversation',
            'pending' => ['submitted', 'under_review', 'reviewed'], 'done' => ['approved', 'accomplished'], 'rejected' => ['rejected'],
            'dashboard' => 'consultancy/dashboard', 'create' => 'consultancy/create', 'list' => 'consultancy',
            'color' => '#5d6b62',
        ],
    ];

    /** Which column the "where is the work coming from" panel groups by, per data scope. */
    private const BREAKDOWN = [
        'global' => ['officer_region', 'Region'],
        'region' => ['officer_district', 'District'],
        'district' => ['officer_county', 'County'],
    ];

    public static function build(): array
    {
        $user = AccessControl::user();
        $role = $user?->role;

        $modules = [];
        foreach (self::MODULES as $key => $def) {
            if (!AccessControl::can("{$key}.view")) {
                continue;
            }
            $modules[$key] = $def;
        }

        $now = now();
        $monthKeys = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthKeys[] = $now->copy()->startOfMonth()->subMonths($i)->format('Y-m');
        }

        $cards = [];
        $trend = [];
        $statusMix = [];
        foreach ($modules as $key => $def) {
            $cards[$key] = self::safe(fn () => self::card($key, $def, $now), self::emptyCard($key, $def));
            $trend[$key] = self::safe(fn () => self::monthly($def, $monthKeys), array_fill_keys($monthKeys, 0));
        }

        $totals = ['all' => 0, 'pending' => 0, 'done' => 0, 'rejected' => 0, 'month' => 0, 'last_month' => 0];
        foreach ($cards as $c) {
            $totals['all'] += $c['total'];
            $totals['pending'] += $c['pending'];
            $totals['done'] += $c['done'];
            $totals['rejected'] += $c['rejected'];
            $totals['month'] += $c['month'];
            $totals['last_month'] += $c['last_month'];
        }

        $scope = $role?->data_scope ?? 'self';
        if (AccessControl::hasFullAccess()) {
            $scope = 'global';
        }

        return [
            'user' => $user,
            'roleName' => $role?->name ?? 'Officer',
            'scope' => $scope,
            'scopeLabel' => $role ? $role->visibilityLabel() : 'Own records only',
            'jurisdiction' => self::jurisdiction($user, $scope),
            'modules' => $modules,
            'cards' => $cards,
            'totals' => $totals,
            'months' => array_map(fn ($m) => Carbon::createFromFormat('Y-m', $m)->format('M'), $monthKeys),
            'monthKeys' => $monthKeys,
            'trend' => $trend,
            'statusMix' => $totals,
            'pending' => self::safe(fn () => self::pendingList($modules), []),
            'breakdown' => self::safe(fn () => self::breakdown($modules, $scope), null),
            'activity' => self::safe(fn () => self::activity(), []),
            'glance' => self::safe(fn () => self::glance(), []),
            'actions' => self::quickActions($modules),
        ];
    }

    /* ------------------------------------------------------------------ */

    private static function base(array $def): Builder
    {
        return AccessControl::scopeApplications($def['model']::query());
    }

    private static function card(string $key, array $def, Carbon $now): array
    {
        $start = $now->copy()->startOfMonth();
        $prevStart = $start->copy()->subMonth();

        $counts = self::base($def)
            ->selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status');

        $sum = fn (array $statuses) => (int) collect($statuses)->sum(fn ($s) => (int) ($counts[$s] ?? 0));

        return [
            'key' => $key,
            'label' => $def['label'],
            'icon' => $def['icon'],
            'color' => $def['color'],
            'total' => (int) $counts->sum(),
            'pending' => $sum($def['pending']),
            'done' => $sum($def['done']),
            'rejected' => $sum($def['rejected']),
            'month' => self::base($def)->where('created_at', '>=', $start)->count(),
            'last_month' => self::base($def)->whereBetween('created_at', [$prevStart, $start->copy()->subSecond()])->count(),
            'dashboard' => url($def['dashboard']),
            'list' => url($def['list']),
        ];
    }

    private static function emptyCard(string $key, array $def): array
    {
        return [
            'key' => $key, 'label' => $def['label'], 'icon' => $def['icon'], 'color' => $def['color'],
            'total' => 0, 'pending' => 0, 'done' => 0, 'rejected' => 0, 'month' => 0, 'last_month' => 0,
            'dashboard' => url($def['dashboard']), 'list' => url($def['list']),
        ];
    }

    /** Applications created per month for the last 12 months (one grouped query). */
    private static function monthly(array $def, array $monthKeys): array
    {
        $first = Carbon::createFromFormat('Y-m-d', $monthKeys[0] . '-01')->startOfDay();
        $expr = DB::connection()->getDriverName() === 'sqlite'
            ? "strftime('%Y-%m', created_at)"
            : "DATE_FORMAT(created_at, '%Y-%m')";

        $rows = self::base($def)
            ->where('created_at', '>=', $first)
            ->selectRaw("{$expr} as m, COUNT(*) as c")
            ->groupBy('m')
            ->pluck('c', 'm');

        $out = [];
        foreach ($monthKeys as $m) {
            $out[$m] = (int) ($rows[$m] ?? 0);
        }

        return $out;
    }

    /** Oldest waiting items first, across every module the user can approve. */
    private static function pendingList(array $modules): array
    {
        $items = [];

        foreach ($modules as $key => $def) {
            $approve = $key === 'consultancy' ? 'consultancy.review' : "{$key}.approve";
            if (!AccessControl::can($approve)) {
                continue;
            }

            $rows = self::base($def)->whereIn('status', $def['pending'])->orderBy('created_at')->limit(8)->get();

            foreach ($rows as $r) {
                $items[] = [
                    'module' => $key,
                    'label' => $def['label'],
                    'color' => $def['color'],
                    'ref' => $r->application_id ?: ('#' . $r->id),
                    'title' => self::title($key, $r),
                    'place' => $r->officer_district ?: ($r->officer_region ?: ''),
                    'created' => $r->created_at,
                    'days' => $r->created_at ? (int) $r->created_at->diffInDays(now()) : 0,
                    'url' => self::recordUrl($key, $r, $def),
                ];
            }
        }

        usort($items, fn ($a, $b) => $a['created'] <=> $b['created']);

        return array_map(function ($i) {
            $i['created'] = $i['created']?->format('d M Y');
            return $i;
        }, array_slice($items, 0, 8));
    }

    private static function title(string $key, $r): string
    {
        $join = fn (...$p) => trim(implode(' ', array_filter(array_map('trim', array_map('strval', $p)))));

        return match ($key) {
            'nikah', 'divorce' => trim($join($r->groom_given_name, $r->groom_surname) . ' & ' . $join($r->bride_given_name, $r->bride_surname), ' &'),
            'inheritance' => (string) ($r->deceased_name ?? ''),
            'guardianship' => (string) ($r->ward_name ?? ''),
            'convert' => (string) ($r->new_names ?: $r->former_names ?: ''),
            'consultancy' => (string) ($r->applicant_name ?? ''),
            default => '',
        } ?: 'Unnamed record';
    }

    /** Every module opens its record page; consultancy keeps its own workflow page. */
    private static function recordUrl(string $key, $r, array $def): string
    {
        return $key === 'consultancy'
            ? url("consultancy/{$r->id}")
            : url("records/{$key}/{$r->id}");
    }

    /** Where the work is coming from, one level below the viewer's own scope. */
    private static function breakdown(array $modules, string $scope): ?array
    {
        if (!isset(self::BREAKDOWN[$scope]) || !$modules) {
            return null;
        }

        [$col, $label] = self::BREAKDOWN[$scope];
        $tally = [];

        foreach ($modules as $key => $def) {
            $rows = self::base($def)->selectRaw("{$col} as place, COUNT(*) as c")->groupBy($col)->pluck('c', 'place');
            foreach ($rows as $place => $c) {
                $place = trim((string) $place) !== '' ? (string) $place : 'Unassigned';
                $tally[$place] = ($tally[$place] ?? 0) + (int) $c;
            }
        }

        arsort($tally);

        return ['label' => $label, 'rows' => array_slice($tally, 0, 8, true), 'more' => max(0, count($tally) - 8)];
    }

    private static function activity(): array
    {
        if (!AccessControl::can('activity_logs.view') || !Schema::hasTable('activity_logs')) {
            return [];
        }

        return ActivityLog::query()->visibleToOfficer()->latest()->limit(6)->get()->map(fn ($a) => [
            'text' => $a->description ?: trim(($a->action ?? '') . ' ' . ($a->target_type ?? '')),
            'when' => $a->created_at?->diffForHumans(),
            'iso' => $a->created_at?->toIso8601String(),
            'ok' => !in_array(strtolower((string) $a->status), ['failed', 'failure', 'error', 'denied'], true),
        ])->all();
    }

    /** Small "directorate at a glance" numbers, shown only where permitted. */
    private static function glance(): array
    {
        $g = [];

        if (AccessControl::can('fatwa.view') && Schema::hasTable('fatwas')) {
            $g[] = ['label' => 'Published Fatwa', 'value' => Fatwa::published()->count(), 'icon' => 'bx-book-open', 'url' => url('fatwa-admin')];
        }
        if (AccessControl::can('users.view')) {
            $q = User::query();
            if (!AccessControl::hasFullAccess()) {
                $q = self::scopeUsers($q);
            }
            $g[] = ['label' => 'Staff accounts', 'value' => $q->count(), 'icon' => 'bx-group', 'url' => url('manage-users')];
        }

        return $g;
    }

    /** Staff the viewer is allowed to see, mirroring the application scoping. */
    private static function scopeUsers(Builder $q): Builder
    {
        $u = AccessControl::user();
        $scope = $u?->role?->data_scope ?? 'self';

        return match ($scope) {
            'global' => $q,
            'region' => $q->where('region', $u->region),
            'district' => $q->where('district', $u->district),
            'county' => $q->where('county', $u->county),
            default => $q->where('id', $u?->id),
        };
    }

    private static function quickActions(array $modules): array
    {
        $out = [];
        foreach ($modules as $key => $def) {
            if (AccessControl::can("{$key}.create")) {
                $out[] = ['label' => $def['label'], 'icon' => $def['icon'], 'url' => url($def['create'])];
            }
        }

        return $out;
    }

    private static function jurisdiction(?User $u, string $scope): string
    {
        if (!$u) {
            return '';
        }

        return match ($scope) {
            'region' => (string) $u->region,
            'district' => trim($u->district . ($u->region ? ', ' . $u->region : ''), ', '),
            'county', 'self' => trim(implode(', ', array_filter([$u->county, $u->district])), ', '),
            default => '',
        };
    }

    private static function safe(callable $fn, $fallback)
    {
        try {
            return $fn();
        } catch (Throwable $e) {
            report($e);
            return $fallback;
        }
    }
}
