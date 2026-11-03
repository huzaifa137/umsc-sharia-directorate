@extends('layouts.app')

@section('content')
@php
    $t = $dash['totals'];
    $cards = $dash['cards'];
    $user = $dash['user'];

    $deltaOf = function ($now, $before) {
        if ($before > 0) {
            return round((($now - $before) / $before) * 100);
        }
        return $now > 0 ? null : 0; // null = "new" (no previous month to compare with)
    };
    $monthDelta = $deltaOf($t['month'], $t['last_month']);

    $other = max(0, $t['all'] - $t['pending'] - $t['done'] - $t['rejected']);
    $segments = [
        ['key' => 'seg_pending', 'label' => 'Awaiting action', 'value' => $t['pending'], 'class' => 'is-pending'],
        ['key' => 'seg_done', 'label' => 'Completed', 'value' => $t['done'], 'class' => 'is-done'],
        ['key' => 'seg_rejected', 'label' => 'Rejected', 'value' => $t['rejected'], 'class' => 'is-rejected'],
        ['key' => 'seg_other', 'label' => 'In progress', 'value' => $other, 'class' => 'is-other'],
    ];

    $canApproveAnything = false;
    foreach (array_keys($dash['modules']) as $mk) {
        if (\App\Services\AccessControl::can($mk === 'consultancy' ? 'consultancy.review' : $mk . '.approve')) { $canApproveAnything = true; break; }
    }

    $chart = [
        'monthKeys' => $dash['monthKeys'],
        'series' => collect($dash['modules'])->map(fn ($def, $k) => [
            'key' => $k, 'label' => $def['label'], 'color' => $def['color'],
            'values' => array_values($dash['trend'][$k] ?? []),
        ])->values()->all(),
    ];
    $trendTotal = collect($chart['series'])->sum(fn ($s) => array_sum($s['values']));
    $maxBreakdown = $dash['breakdown'] ? max(1, max($dash['breakdown']['rows'] ?: [1])) : 1;
    $maxModule = max(1, collect($cards)->max('total') ?: 1);
@endphp

<link rel="stylesheet" href="{{ asset('css/umsc-dashboard.css') }}">

<div class="container-xxl flex-grow-1 container-p-y d-dash" id="dash-root"
     data-chart="{{ json_encode($chart) }}">

    {{-- ===== Page header ===== --}}
    <header class="d-head">
        <div class="d-head__text">
            <p class="d-eyebrow">
                <span>{{ $dash['roleName'] }}</span>
                <span class="d-dot" aria-hidden="true"></span>
                <span>{{ $dash['scopeLabel'] }}</span>
                @if ($dash['jurisdiction'])
                    <span class="d-dot" aria-hidden="true"></span>
                    <span>{{ $dash['jurisdiction'] }}</span>
                @endif
            </p>
            <h1 class="d-title"><span data-d="welcome">Welcome back</span>@if ($user?->firstname), {{ $user->firstname }}@endif</h1>
            <p class="d-sub"><i class="bx bx-calendar" aria-hidden="true"></i> <span id="d-date">{{ now()->format('l, j F Y') }}</span></p>
        </div>

        @if ($dash['actions'])
            <nav class="d-actions" aria-label="Quick actions">
                @foreach ($dash['actions'] as $a)
                    <a class="d-btn" href="{{ $a['url'] }}">
                        <i class="bx {{ $a['icon'] }}" aria-hidden="true"></i>
                        <span><span data-d="new">New</span> <span data-d="m_{{ strtolower($a['label']) }}">{{ $a['label'] }}</span></span>
                    </a>
                @endforeach
            </nav>
        @endif
    </header>

    @if (!$dash['modules'])
        <section class="d-card d-empty-page">
            <i class="bx bx-lock-alt" aria-hidden="true"></i>
            <h2 data-d="no_modules_title">No modules are assigned to your role yet</h2>
            <p data-d="no_modules_text">Ask the Director to grant your role access to the services you work with. Your dashboard will fill in automatically.</p>
        </section>
    @else

    {{-- ===== Headline numbers ===== --}}
    <section class="d-kpis" aria-label="Headline figures">
        <article class="d-kpi">
            <span class="d-kpi__label" data-d="k_total">All records</span>
            <strong class="d-kpi__value">{{ number_format($t['all']) }}</strong>
            <span class="d-kpi__note" data-d="k_total_note">Across the services you can see</span>
        </article>

        <article class="d-kpi {{ $t['pending'] > 0 ? 'is-alert' : '' }}">
            <span class="d-kpi__label" data-d="k_pending">Awaiting action</span>
            <strong class="d-kpi__value">{{ number_format($t['pending']) }}</strong>
            <span class="d-kpi__note" data-d="{{ $t['pending'] > 0 ? 'k_pending_note' : 'k_pending_none' }}">{{ $t['pending'] > 0 ? 'Submitted and not yet decided' : 'Nothing is waiting' }}</span>
        </article>

        <article class="d-kpi">
            <span class="d-kpi__label" data-d="k_done">Completed</span>
            <strong class="d-kpi__value">{{ number_format($t['done']) }}</strong>
            <span class="d-kpi__note">
                @if ($t['all'] > 0) {{ round($t['done'] / $t['all'] * 100) }}% <span data-d="k_done_note">of all records</span>
                @else <span data-d="k_done_empty">No records yet</span> @endif
            </span>
        </article>

        <article class="d-kpi">
            <span class="d-kpi__label" data-d="k_month">Registered this month</span>
            <strong class="d-kpi__value">{{ number_format($t['month']) }}</strong>
            <span class="d-kpi__note">
                @if ($monthDelta === null)
                    <span class="d-trend is-up"><i class="bx bx-up-arrow-alt" aria-hidden="true"></i> <span data-d="k_new">New this month</span></span>
                @elseif ($monthDelta > 0)
                    <span class="d-trend is-up"><i class="bx bx-up-arrow-alt" aria-hidden="true"></i> {{ $monthDelta }}%</span> <span data-d="k_vs">vs last month</span>
                @elseif ($monthDelta < 0)
                    <span class="d-trend is-down"><i class="bx bx-down-arrow-alt" aria-hidden="true"></i> {{ abs($monthDelta) }}%</span> <span data-d="k_vs">vs last month</span>
                @else
                    <span data-d="k_flat">Same as last month</span>
                @endif
            </span>
        </article>
    </section>

    {{-- ===== Services ===== --}}
    <section aria-labelledby="d-services-h">
        <div class="d-section-head">
            <h2 id="d-services-h" data-d="h_services">Services</h2>
        </div>
        <div class="d-modules">
            @foreach ($cards as $c)
                @php $pct = $c['total'] > 0 ? round($c['done'] / $c['total'] * 100) : 0; @endphp
                <a class="d-module" href="{{ $c['dashboard'] }}" style="--c: {{ $c['color'] }}">
                    <span class="d-module__icon"><i class="bx {{ $c['icon'] }}" aria-hidden="true"></i></span>
                    <span class="d-module__body">
                        <span class="d-module__name" data-d="m_{{ strtolower($c['label']) }}">{{ $c['label'] }}</span>
                        <strong class="d-module__total">{{ number_format($c['total']) }}</strong>
                        <span class="d-module__meta">
                            @if ($c['pending'] > 0)
                                <span class="d-pill is-pending">{{ number_format($c['pending']) }} <span data-d="pending_short">pending</span></span>
                            @endif
                            @if ($c['month'] > 0)
                                <span class="d-module__month">+{{ number_format($c['month']) }} <span data-d="this_month">this month</span></span>
                            @endif
                            @if ($c['pending'] == 0 && $c['month'] == 0)
                                <span class="d-module__month" data-d="quiet">No new activity</span>
                            @endif
                        </span>
                        <span class="d-bar" role="img" aria-label="{{ $pct }}% completed"><i style="width: {{ $pct }}%"></i></span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ===== Trend + status mix ===== --}}
    <div class="d-grid d-grid--wide">
        <section class="d-card" aria-labelledby="d-trend-h">
            <div class="d-card__head">
                <div>
                    <h2 id="d-trend-h" data-d="h_trend">Registrations, last 12 months</h2>
                    <p class="d-muted" data-d="h_trend_sub">New records per month, by service</p>
                </div>
            </div>

            @if ($trendTotal > 0)
                <ul class="d-legend" id="d-legend">
                    @foreach ($chart['series'] as $s)
                        <li><button type="button" class="d-legend__btn" data-series="{{ $s['key'] }}" aria-pressed="true" style="--c: {{ $s['color'] }}">
                            <i></i><span data-d="m_{{ strtolower($s['label']) }}">{{ $s['label'] }}</span>
                        </button></li>
                    @endforeach
                </ul>
                <div class="d-chart" id="d-chart" aria-hidden="true"></div>
                <div class="d-tip" id="d-tip" role="status" hidden></div>

                <div class="d-sr"><table>
                    <caption data-d="h_trend">Registrations, last 12 months</caption>
                    <thead><tr><th scope="col">Month</th>@foreach ($chart['series'] as $s)<th scope="col">{{ $s['label'] }}</th>@endforeach</tr></thead>
                    <tbody>
                        @foreach ($dash['monthKeys'] as $i => $mk)
                            <tr><th scope="row">{{ $mk }}</th>@foreach ($chart['series'] as $s)<td>{{ $s['values'][$i] }}</td>@endforeach</tr>
                        @endforeach
                    </tbody>
                </table></div>
            @else
                <div class="d-empty">
                    <i class="bx bx-bar-chart-alt-2" aria-hidden="true"></i>
                    <p data-d="trend_empty">No registrations in the last 12 months yet. The chart appears once records are added.</p>
                </div>
            @endif
        </section>

        <section class="d-card" aria-labelledby="d-mix-h">
            <div class="d-card__head">
                <div>
                    <h2 id="d-mix-h" data-d="h_mix">Where records stand</h2>
                    <p class="d-muted" data-d="h_mix_sub">Status of everything you can see</p>
                </div>
            </div>

            @if ($t['all'] > 0)
                <div class="d-donut">
                    <svg viewBox="0 0 42 42" role="img" aria-label="Status breakdown">
                        <circle class="d-donut__track" cx="21" cy="21" r="15.9155" />
                        @php $offset = 25; @endphp
                        @foreach ($segments as $s)
                            @if ($s['value'] > 0)
                                @php $len = $s['value'] / $t['all'] * 100; @endphp
                                <circle class="d-donut__seg {{ $s['class'] }}" cx="21" cy="21" r="15.9155"
                                        stroke-dasharray="{{ round($len, 3) }} {{ round(100 - $len, 3) }}"
                                        stroke-dashoffset="{{ round($offset, 3) }}" />
                                @php $offset -= $len; @endphp
                            @endif
                        @endforeach
                    </svg>
                    <div class="d-donut__centre"><strong>{{ number_format($t['all']) }}</strong><span data-d="k_total">All records</span></div>
                </div>
                <ul class="d-keys">
                    @foreach ($segments as $s)
                        <li><i class="d-swatch {{ $s['class'] }}"></i><span data-d="{{ $s['key'] }}">{{ $s['label'] }}</span><strong>{{ number_format($s['value']) }}</strong></li>
                    @endforeach
                </ul>
            @else
                <div class="d-empty">
                    <i class="bx bx-pie-chart-alt" aria-hidden="true"></i>
                    <p data-d="mix_empty">Nothing to show yet.</p>
                </div>
            @endif
        </section>
    </div>

    {{-- ===== Approvals + breakdown ===== --}}
    <div class="d-grid d-grid--wide">
        <section class="d-card" aria-labelledby="d-pending-h">
            <div class="d-card__head">
                <div>
                    <h2 id="d-pending-h" data-d="h_pending">Waiting for your decision</h2>
                    <p class="d-muted" data-d="h_pending_sub">Oldest first, across every service you can approve</p>
                </div>
            </div>

            @if ($dash['pending'])
                <div class="d-table-wrap">
                    <table class="d-table">
                        <thead>
                            <tr>
                                <th scope="col" data-d="th_ref">Reference</th>
                                <th scope="col" data-d="th_record">Record</th>
                                <th scope="col" data-d="th_place">Area</th>
                                <th scope="col" data-d="th_waiting">Waiting</th>
                                <th scope="col"><span class="d-sr" data-d="th_action">Action</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dash['pending'] as $p)
                                <tr>
                                    <td class="d-mono">{{ $p['ref'] }}</td>
                                    <td>
                                        <span class="d-rec">{{ $p['title'] }}</span>
                                        <span class="d-tag" style="--c: {{ $p['color'] }}" data-d="m_{{ strtolower($p['label']) }}">{{ $p['label'] }}</span>
                                    </td>
                                    <td>{{ $p['place'] ?: '—' }}</td>
                                    <td>
                                        <span class="d-age {{ $p['days'] >= 14 ? 'is-late' : ($p['days'] >= 7 ? 'is-warn' : '') }}">
                                            @if ($p['days'] === 0) <span data-d="today">Today</span>
                                            @else {{ $p['days'] }} <span data-d="{{ $p['days'] === 1 ? 'day' : 'days' }}">{{ $p['days'] === 1 ? 'day' : 'days' }}</span> @endif
                                        </span>
                                    </td>
                                    <td class="d-td-end"><a class="d-link" href="{{ $p['url'] }}"><span data-d="review">Review</span> <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($t['pending'] > count($dash['pending']))
                    <p class="d-foot"><span data-d="and_more">Showing the oldest</span> {{ count($dash['pending']) }} <span data-d="of">of</span> {{ number_format($t['pending']) }}. <span data-d="open_service">Open a service to see the rest.</span></p>
                @endif
            @elseif (!$canApproveAnything)
                <div class="d-empty">
                    <i class="bx bx-info-circle" aria-hidden="true"></i>
                    <p data-d="pending_norights">Your role registers records but does not approve them. Approvers see their queue here.</p>
                </div>
            @else
                <div class="d-empty is-good">
                    <i class="bx bx-check-circle" aria-hidden="true"></i>
                    <p data-d="pending_clear">You are all caught up. Nothing is waiting for a decision.</p>
                </div>
            @endif
        </section>

        <section class="d-card" aria-labelledby="d-break-h">
            <div class="d-card__head">
                <div>
                    @if ($dash['breakdown'])
                        <h2 id="d-break-h"><span data-d="h_by">By</span> <span data-d="by_{{ strtolower($dash['breakdown']['label']) }}">{{ $dash['breakdown']['label'] }}</span></h2>
                        <p class="d-muted" data-d="h_by_sub">Records registered, all services together</p>
                    @else
                        <h2 id="d-break-h" data-d="h_by_service">By service</h2>
                        <p class="d-muted" data-d="h_by_service_sub">Your records split by service</p>
                    @endif
                </div>
            </div>

            @if ($dash['breakdown'] && $dash['breakdown']['rows'])
                <ul class="d-rows">
                    @foreach ($dash['breakdown']['rows'] as $place => $count)
                        <li>
                            <span class="d-rows__name">{{ $place }}</span>
                            <span class="d-rows__bar"><i style="width: {{ max(3, round($count / $maxBreakdown * 100)) }}%"></i></span>
                            <strong>{{ number_format($count) }}</strong>
                        </li>
                    @endforeach
                </ul>
                @if ($dash['breakdown']['more'] > 0)
                    <p class="d-foot">+ {{ $dash['breakdown']['more'] }} <span data-d="more_areas">more</span></p>
                @endif
            @elseif (!$dash['breakdown'] && $t['all'] > 0)
                <ul class="d-rows">
                    @foreach ($cards as $c)
                        <li>
                            <span class="d-rows__name" data-d="m_{{ strtolower($c['label']) }}">{{ $c['label'] }}</span>
                            <span class="d-rows__bar" style="--c: {{ $c['color'] }}"><i style="width: {{ max(3, round($c['total'] / $maxModule * 100)) }}%"></i></span>
                            <strong>{{ number_format($c['total']) }}</strong>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="d-empty">
                    <i class="bx bx-map" aria-hidden="true"></i>
                    <p data-d="by_empty">No records to break down yet.</p>
                </div>
            @endif
        </section>
    </div>

    {{-- ===== Activity + at a glance ===== --}}
    @if ($dash['activity'] || $dash['glance'])
        <div class="d-grid d-grid--even">
            @if ($dash['activity'])
                <section class="d-card" aria-labelledby="d-act-h">
                    <div class="d-card__head"><h2 id="d-act-h" data-d="h_activity">Recent activity</h2></div>
                    <ul class="d-feed">
                        @foreach ($dash['activity'] as $a)
                            <li class="{{ $a['ok'] ? '' : 'is-bad' }}">
                                <span class="d-feed__text">{{ \Illuminate\Support\Str::limit($a['text'], 90) }}</span>
                                <time class="d-muted" @if($a['iso']) datetime="{{ $a['iso'] }}" data-ts="{{ $a['iso'] }}" @endif>{{ $a['when'] }}</time>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if ($dash['glance'])
                <section class="d-card" aria-labelledby="d-glance-h">
                    <div class="d-card__head"><h2 id="d-glance-h" data-d="h_glance">Directorate at a glance</h2></div>
                    <div class="d-glance">
                        @foreach ($dash['glance'] as $g)
                            <a class="d-glance__item" href="{{ $g['url'] }}">
                                <i class="bx {{ $g['icon'] }}" aria-hidden="true"></i>
                                <strong>{{ number_format($g['value']) }}</strong>
                                <span data-d="{{ $g['label'] === 'Published Fatwa' ? 'g_fatwa' : 'g_staff' }}">{{ $g['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    @endif

    @endif {{-- /modules --}}
</div>

<script src="{{ asset('js/umsc-dashboard.js') }}" defer></script>
@endsection
