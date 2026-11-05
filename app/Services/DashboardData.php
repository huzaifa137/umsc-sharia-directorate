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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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


    /** Periods the dashboard can be narrowed to (days). 'all' = no limit. */
    public const PERIODS = ['30', '90', '365', 'all'];

    /** A pending record this old (days) counts as overdue. */
    public const OVERDUE_DAYS = 14;

    private const CACHE_TTL = 60;

    /**
     * "Insight" cards: a breakdown of one column of one service. Only shown when
     * the viewer can see that service and the column has data.
     */
    private const INSIGHTS = [
        ['module' => 'nikah',        'col' => 'dowery_type',          'key' => 'dowry',            'type' => 'donut', 'limit' => 6],
        ['module' => 'nikah',        'col' => 'masjid_name',          'key' => 'mosques',          'type' => 'bar',   'limit' => 6],
        ['module' => 'divorce',      'col' => 'divorce_type',         'key' => 'divorce_type',     'type' => 'donut', 'limit' => 6],
        ['module' => 'divorce',      'col' => 'divorce_initiated_by', 'key' => 'divorce_by',       'type' => 'donut', 'limit' => 4],
        ['module' => 'guardianship', 'col' => 'guardianship_type',    'key' => 'guardian_type',    'type' => 'donut', 'limit' => 6],
        ['module' => 'inheritance',  'col' => 'relationship',         'key' => 'inherit_rel',      'type' => 'bar',   'limit' => 6],
        ['module' => 'convert',      'col' => 'former_religion',      'key' => 'convert_religion', 'type' => 'donut', 'limit' => 6],
        ['module' => 'consultancy',  'col' => 'consultation_type',    'key' => 'consult_type',     'type' => 'donut', 'limit' => 6],
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
    private static function breakdown(array $modules, string $scope, ?Carbon $since = null): ?array
    {
        if (!isset(self::BREAKDOWN[$scope]) || !$modules) {
            return null;
        }

        [$col, $label] = self::BREAKDOWN[$scope];
        $tally = [];

        foreach ($modules as $key => $def) {
            $bq = self::base($def);
            if ($since) {
                $bq->where('created_at', '>=', $since);
            }
            $rows = $bq->selectRaw("{$col} as place, COUNT(*) as c")->groupBy($col)->pluck('c', 'place');
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
            $g[] = ['key' => 'fatwa', 'label' => 'Published Fatwa', 'value' => Fatwa::published()->count(), 'icon' => 'bx-book-open', 'url' => url('fatwa-admin')];
        }
        if (AccessControl::can('users.view')) {
            $q = User::query();
            if (!AccessControl::hasFullAccess()) {
                $q = self::scopeUsers($q);
            }
            $g[] = ['key' => 'staff', 'label' => 'Staff accounts', 'value' => $q->count(), 'icon' => 'bx-group', 'url' => url('manage-users')];
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


    /* ================================================================== */
    /*  Interactive dashboard payload (JSON, filterable, cached briefly)   */
    /* ================================================================== */

    /** Services the viewer may see, keyed like MODULES. */
    public static function visibleModules(): array
    {
        $out = [];
        foreach (self::MODULES as $key => $def) {
            if (AccessControl::can("{$key}.view")) {
                $out[$key] = $def;
            }
        }

        return $out;
    }

    public static function filters(?string $period, ?string $service): array
    {
        $modules = self::visibleModules();

        return [
            'period' => in_array((string) $period, self::PERIODS, true) ? (string) $period : 'all',
            'service' => ($service && isset($modules[$service])) ? $service : 'all',
        ];
    }

    /**
     * Full payload for the dashboard page and its JSON endpoint.
     * The cache key includes the user, so scoped numbers can never leak between officers.
     */
    public static function payload(?string $period = null, ?string $service = null, bool $fresh = false): array
    {
        $f = self::filters($period, $service);
        $user = AccessControl::user();
        $key = 'umsc_dash:v1:' . ($user?->id ?? 0) . ":{$f['period']}:{$f['service']}";

        try {
            if ($fresh) {
                Cache::forget($key);
            }

            return Cache::remember($key, self::CACHE_TTL, fn () => self::compute($f));
        } catch (Throwable $e) {
            // A broken cache store must never take the dashboard down.
            Log::warning('Dashboard cache unavailable: ' . $e->getMessage());

            return self::compute($f);
        }
    }

    private static function compute(array $f): array
    {
        $all = self::visibleModules();
        $modules = $f['service'] === 'all' ? $all : [$f['service'] => $all[$f['service']]];
        $now = now();
        $since = $f['period'] === 'all' ? null : $now->copy()->subDays((int) $f['period'])->startOfDay();

        $user = AccessControl::user();
        $role = $user?->role;
        $scope = AccessControl::hasFullAccess() ? 'global' : ($role?->data_scope ?? 'self');

        // ---- per-service numbers -------------------------------------------------
        $cohort = [];   // inside the selected period
        $queue = [];    // all-time card (pending queue, this month vs last)
        foreach ($modules as $k => $def) {
            $cohort[$k] = self::safe(fn () => self::cohort($def, $since), ['total' => 0, 'pending' => 0, 'done' => 0, 'rejected' => 0, 'other' => 0]);
            $queue[$k] = self::safe(fn () => self::card($k, $def, $now), self::emptyCard($k, $def));
        }

        $sumOf = fn (array $rows, string $col) => (int) array_sum(array_column($rows, $col));
        $tot = [
            'total' => $sumOf($cohort, 'total'),
            'pending' => $sumOf($cohort, 'pending'),
            'done' => $sumOf($cohort, 'done'),
            'rejected' => $sumOf($cohort, 'rejected'),
            'other' => $sumOf($cohort, 'other'),
        ];
        $queuePending = $sumOf($queue, 'pending');

        // ---- time series ---------------------------------------------------------
        $series = self::safe(fn () => self::dailySeries($modules, 84), ['dates' => [], 'by' => [], 'weekday' => array_fill(0, 7, 0)]);
        $monthKeys = [];
        for ($i = 11; $i >= 0; $i--) {
            $monthKeys[] = $now->copy()->startOfMonth()->subMonths($i)->format('Y-m');
        }
        $monthly = [];
        foreach ($modules as $k => $def) {
            $monthly[$k] = array_values(self::safe(fn () => self::monthly($def, $monthKeys), array_fill_keys($monthKeys, 0)));
        }

        $dailyDates = array_slice($series['dates'], -30);
        $dailyBy = [];
        foreach ($modules as $k => $def) {
            $dailyBy[$k] = array_slice($series['by'][$k] ?? [], -30);
        }
        $dailyTotal = self::sumColumns($dailyBy, 30);
        $monthlyTotal = self::sumColumns($monthly, 12);

        $last7 = array_sum(array_slice($dailyTotal, -7));
        $prev7 = array_sum(array_slice($dailyTotal, -14, 7));

        // ---- queue health --------------------------------------------------------
        $queueInfo = self::safe(fn () => self::queueInfo($modules), ['oldest_days' => null, 'overdue' => 0, 'buckets' => [0, 0, 0, 0], 'schools' => 0]);
        $turnaround = self::safe(fn () => self::turnaround($modules, $since), null);
        $decided = $tot['done'] + $tot['rejected'];

        $services = [];
        foreach ($modules as $k => $def) {
            $c = $cohort[$k];
            $q = $queue[$k];
            $services[] = [
                'key' => $k, 'label' => $def['label'], 'icon' => $def['icon'], 'color' => $def['color'],
                'total' => $c['total'], 'pending' => $c['pending'], 'done' => $c['done'], 'rejected' => $c['rejected'], 'other' => $c['other'],
                'queue' => $q['pending'], 'month' => $q['month'], 'last_month' => $q['last_month'],
                'percent' => $c['total'] > 0 ? (int) round($c['done'] / $c['total'] * 100) : 0,
                'spark' => $monthly[$k] ?? [],
                'url' => $q['dashboard'], 'list' => $q['list'],
            ];
        }

        $kpis = [
            [
                'key' => 'total', 'icon' => 'bx-folder-open', 'tone' => 'green', 'value' => $tot['total'],
                'sub' => ['k' => 'sub_services', 'n' => count($modules)],
                'delta' => self::delta($last7, $prev7), 'spark' => array_slice($dailyTotal, -14),
            ],
            [
                'key' => 'pending', 'icon' => 'bx-hourglass', 'tone' => 'amber', 'value' => $queuePending,
                'sub' => $queueInfo['oldest_days'] === null ? ['k' => 'sub_queue_clear'] : ['k' => 'sub_oldest', 'n' => $queueInfo['oldest_days']],
                'pulse' => $queuePending > 0,
            ],
            [
                'key' => 'overdue', 'icon' => 'bx-alarm-exclamation', 'tone' => 'red', 'value' => $queueInfo['overdue'],
                'sub' => ['k' => 'sub_overdue', 'n' => self::OVERDUE_DAYS],
            ],
            [
                'key' => 'done', 'icon' => 'bx-check-circle', 'tone' => 'teal', 'value' => $tot['done'],
                'sub' => $tot['total'] > 0 ? ['k' => 'sub_done_pct', 'n' => (int) round($tot['done'] / $tot['total'] * 100)] : ['k' => 'sub_none'],
                'progress' => $tot['total'] > 0 ? (int) round($tot['done'] / $tot['total'] * 100) : 0,
            ],
            [
                'key' => 'fresh', 'icon' => 'bx-trending-up', 'tone' => 'indigo', 'value' => $last7,
                'sub' => ['k' => 'sub_fresh', 'n' => array_sum($dailyTotal)],
                'delta' => self::delta($last7, $prev7), 'spark' => array_slice($dailyTotal, -14),
            ],
            [
                'key' => 'turnaround', 'icon' => 'bx-time-five', 'tone' => 'gold',
                'value' => $turnaround !== null ? round($turnaround, 1) : null, 'decimals' => 1, 'suffix' => 'd',
                'sub' => $turnaround !== null ? ['k' => 'sub_turnaround'] : ['k' => 'sub_turnaround_none'],
            ],
            [
                'key' => 'rejection', 'icon' => 'bx-x-circle', 'tone' => 'rose',
                'value' => $decided > 0 ? (int) round($tot['rejected'] / $decided * 100) : null, 'suffix' => '%',
                'sub' => $decided > 0 ? ['k' => 'sub_rejected', 'n' => $tot['rejected']] : ['k' => 'sub_none'],
            ],
            [
                'key' => 'trend', 'icon' => 'bx-line-chart', 'tone' => 'purple', 'value' => array_sum(array_slice($monthlyTotal, -1)),
                'sub' => ['k' => 'sub_month_prev', 'n' => $monthlyTotal[10] ?? 0],
                'delta' => self::delta((int) ($monthlyTotal[11] ?? 0), (int) ($monthlyTotal[10] ?? 0)),
                'spark' => array_slice($monthlyTotal, -8),
            ],
        ];

        $glance = self::safe(fn () => self::glance(), []);

        return [
            'meta' => [
                'generated_at' => $now->toIso8601String(),
                'role' => $role?->name ?? 'Officer',
                'scope' => $scope,
                'scope_label' => $role ? $role->visibilityLabel() : 'Own records only',
                'jurisdiction' => self::jurisdiction($user, $scope),
                'overdue_days' => self::OVERDUE_DAYS,
                'first_name' => $user?->firstname,
            ],
            'filters' => $f,
            'services_available' => array_map(fn ($def, $k) => [
                'key' => $k, 'label' => $def['label'], 'color' => $def['color'], 'icon' => $def['icon'],
                // current pending queue per service (all time), for the tab badges
                'queue' => self::safe(fn () => (int) self::base($def)->whereIn('status', $def['pending'])->count(), 0),
            ], $all, array_keys($all)),
            'kpis' => $kpis,
            'alerts' => self::alerts($tot, $queuePending, $queueInfo, $services, $f),
            'pipeline' => ['totals' => $tot, 'completion' => $tot['total'] > 0 ? (int) round($tot['done'] / $tot['total'] * 100) : null,
                           'approval_rate' => $decided > 0 ? (int) round($tot['done'] / $decided * 100) : null],
            'trend' => [
                'daily' => ['dates' => $dailyDates, 'by' => $dailyBy, 'total' => $dailyTotal],
                'monthly' => ['keys' => $monthKeys, 'by' => $monthly, 'total' => $monthlyTotal],
            ],
            'services' => $services,
            'weekday' => $series['weekday'],
            'queue' => ['buckets' => $queueInfo['buckets'], 'overdue' => $queueInfo['overdue'], 'oldest_days' => $queueInfo['oldest_days']],
            'pending' => self::safe(fn () => self::pendingList($modules), []),
            'breakdown' => self::breakdownList(self::safe(fn () => self::breakdown($modules, $scope, $since), null)),
            'insights' => self::safe(fn () => self::insights($modules, $since), []),
            'recent' => self::safe(fn () => self::recent($modules), []),
            'activity' => self::safe(fn () => self::activity(), []),
            'glance' => $glance,
            'actions' => self::quickActions($modules),
        ];
    }

    /** Status counts for one service inside the period. */
    private static function cohort(array $def, ?Carbon $since): array
    {
        $q = self::base($def);
        if ($since) {
            $q->where('created_at', '>=', $since);
        }
        $counts = $q->selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status');
        $sum = fn (array $st) => (int) collect($st)->sum(fn ($s) => (int) ($counts[$s] ?? 0));

        $total = (int) $counts->sum();
        $pending = $sum($def['pending']);
        $done = $sum($def['done']);
        $rejected = $sum($def['rejected']);

        return ['total' => $total, 'pending' => $pending, 'done' => $done, 'rejected' => $rejected,
                'other' => max(0, $total - $pending - $done - $rejected)];
    }

    /**
     * Applications per day for the last $days days, per service, plus the
     * total per weekday (Mon..Sun) over the same window.
     */
    private static function dailySeries(array $modules, int $days): array
    {
        $start = Carbon::today()->subDays($days - 1);
        $dates = [];
        for ($i = 0; $i < $days; $i++) {
            $dates[] = $start->copy()->addDays($i)->toDateString();
        }

        $by = [];
        $weekday = array_fill(0, 7, 0);

        foreach ($modules as $k => $def) {
            $rows = self::base($def)
                ->where('created_at', '>=', $start)
                ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
                ->groupBy('d')
                ->pluck('c', 'd');

            $line = [];
            foreach ($dates as $d) {
                $c = (int) ($rows[$d] ?? 0);
                $line[] = $c;
                if ($c) {
                    $weekday[Carbon::parse($d)->dayOfWeekIso - 1] += $c;
                }
            }
            $by[$k] = $line;
        }

        return ['dates' => $dates, 'by' => $by, 'weekday' => $weekday];
    }

    private static function sumColumns(array $byService, int $len): array
    {
        $out = array_fill(0, $len, 0);
        foreach ($byService as $line) {
            foreach ($line as $i => $v) {
                $out[$i] = ($out[$i] ?? 0) + (int) $v;
            }
        }

        return $out;
    }

    /** Current pending queue: oldest item, overdue count and age buckets (0-3 / 4-7 / 8-14 / 15+ days). */
    private static function queueInfo(array $modules): array
    {
        $buckets = [0, 0, 0, 0];
        $overdue = 0;
        $oldest = null;
        $today = now();

        foreach ($modules as $def) {
            $dates = self::base($def)->whereIn('status', $def['pending'])->limit(5000)->pluck('created_at');
            foreach ($dates as $d) {
                if (!$d) {
                    continue;
                }
                $days = (int) Carbon::parse($d)->diffInDays($today);
                $oldest = $oldest === null ? $days : max($oldest, $days);
                if ($days >= self::OVERDUE_DAYS) {
                    $overdue++;
                }
                $buckets[$days <= 3 ? 0 : ($days <= 7 ? 1 : ($days < self::OVERDUE_DAYS ? 2 : 3))]++;
            }
        }

        return ['oldest_days' => $oldest, 'overdue' => $overdue, 'buckets' => $buckets];
    }

    /** Average days from registration to a completed decision (updated_at stands in for the decision date). */
    private static function turnaround(array $modules, ?Carbon $since): ?float
    {
        $sqlite = DB::connection()->getDriverName() === 'sqlite';
        $diff = $sqlite ? '(julianday(updated_at) - julianday(created_at))' : 'DATEDIFF(updated_at, created_at)';

        $sum = 0.0;
        $n = 0;
        foreach ($modules as $def) {
            $q = self::base($def)->whereIn('status', $def['done']);
            if ($since) {
                $q->where('created_at', '>=', $since);
            }
            $row = $q->selectRaw("AVG({$diff}) as a, COUNT(*) as c")->first();
            if ($row && (int) $row->c > 0) {
                $sum += max(0.0, (float) $row->a) * (int) $row->c;
                $n += (int) $row->c;
            }
        }

        return $n > 0 ? $sum / $n : null;
    }

    private static function insights(array $modules, ?Carbon $since): array
    {
        $out = [];
        foreach (self::INSIGHTS as $spec) {
            if (!isset($modules[$spec['module']]) || count($out) >= 6) {
                continue;
            }
            $def = $modules[$spec['module']];
            $table = (new $def['model'])->getTable();
            if (!Schema::hasColumn($table, $spec['col'])) {
                continue;
            }

            $q = self::base($def)->whereNotNull($spec['col'])->where($spec['col'], '<>', '');
            if ($since) {
                $q->where('created_at', '>=', $since);
            }
            $rows = $q->selectRaw("{$spec['col']} as label, COUNT(*) as c")
                ->groupBy($spec['col'])->orderByDesc('c')->limit($spec['limit'])->get();

            if ($rows->isEmpty()) {
                continue;
            }

            $out[] = [
                'key' => $spec['key'], 'type' => $spec['type'], 'module' => $spec['module'],
                'color' => $def['color'],
                'labels' => $rows->map(fn ($r) => self::pretty((string) $r->label))->all(),
                'values' => $rows->map(fn ($r) => (int) $r->c)->all(),
            ];
        }

        return $out;
    }

    private static function pretty(string $v): string
    {
        $v = trim(str_replace('_', ' ', $v));

        return mb_strlen($v) > 28 ? rtrim(mb_substr($v, 0, 27)) . '…' : ($v === strtolower($v) ? ucfirst($v) : $v);
    }

    /** Newest registrations across the services in view. */
    private static function recent(array $modules): array
    {
        $items = [];
        foreach ($modules as $key => $def) {
            foreach (self::base($def)->latest()->limit(5)->get() as $r) {
                $items[] = [
                    'module' => $key, 'label' => $def['label'], 'color' => $def['color'], 'icon' => $def['icon'],
                    'ref' => $r->application_id ?: ('#' . $r->id),
                    'title' => self::title($key, $r),
                    'status' => (string) $r->status,
                    'state' => in_array($r->status, $def['done'], true) ? 'done' : (in_array($r->status, $def['rejected'], true) ? 'rejected' : (in_array($r->status, $def['pending'], true) ? 'pending' : 'other')),
                    'iso' => $r->created_at?->toIso8601String(),
                    'ts' => $r->created_at?->timestamp ?? 0,
                    'url' => self::recordUrl($key, $r, $def),
                ];
            }
        }
        usort($items, fn ($a, $b) => $b['ts'] <=> $a['ts']);

        return array_map(function ($i) {
            unset($i['ts']);
            return $i;
        }, array_slice($items, 0, 8));
    }

    /** JSON objects do not guarantee key order for numeric-looking names, so ship the breakdown as a list. */
    private static function breakdownList(?array $b): ?array
    {
        if (!$b || empty($b['rows'])) {
            return null;
        }
        $rows = [];
        foreach ($b['rows'] as $name => $value) {
            $rows[] = ['name' => (string) $name, 'value' => (int) $value];
        }

        return ['label' => $b['label'], 'key' => strtolower($b['label']), 'rows' => $rows, 'more' => $b['more']];
    }

    private static function alerts(array $tot, int $queuePending, array $queueInfo, array $services, array $f): array
    {
        $alerts = [];

        if ($queueInfo['overdue'] > 0) {
            $alerts[] = ['tone' => 'red', 'icon' => 'bx-alarm-exclamation', 'k' => 'al_overdue', 'n' => $queueInfo['overdue'], 'd' => self::OVERDUE_DAYS];
        }
        if ($queuePending > 0) {
            $alerts[] = ['tone' => 'amber', 'icon' => 'bx-hourglass', 'k' => 'al_pending', 'n' => $queuePending];
        }

        // Busiest queue
        $busiest = collect($services)->sortByDesc('queue')->first();
        if ($busiest && $busiest['queue'] > 0 && count($services) > 1) {
            $alerts[] = ['tone' => 'blue', 'icon' => $busiest['icon'], 'k' => 'al_busiest', 'n' => $busiest['queue'], 'm' => $busiest['key']];
        }

        $decided = $tot['done'] + $tot['rejected'];
        if ($decided >= 10 && $tot['rejected'] / $decided >= 0.25) {
            $alerts[] = ['tone' => 'rose', 'icon' => 'bx-x-circle', 'k' => 'al_rejection', 'n' => (int) round($tot['rejected'] / $decided * 100)];
        }

        if (!$alerts) {
            $alerts[] = ['tone' => 'green', 'icon' => 'bx-check-circle', 'k' => 'al_clear'];
        }

        return array_slice($alerts, 0, 4);
    }

    private static function delta(int|float $current, int|float $previous): ?array
    {
        if ($previous <= 0) {
            return $current > 0 ? ['direction' => 'up', 'percent' => null] : null;
        }
        $pct = (int) round(($current - $previous) / $previous * 100);

        return ['direction' => $pct > 0 ? 'up' : ($pct < 0 ? 'down' : 'flat'), 'percent' => abs($pct)];
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
