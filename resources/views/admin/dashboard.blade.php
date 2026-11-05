@extends('layouts.app')

@section('content')
    @php($services = $payload['services_available'])

    <link rel="stylesheet" href="{{ asset('css/umsc-dashboard.css') }}?v={{ @filemtime(public_path('css/umsc-dashboard.css')) }}">

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="ud" id="ud" data-url="{{ $dataUrl }}" data-apex="{{ asset('js/vendor/apexcharts.min.js') }}">
            <div class="ud-busy" aria-hidden="true"></div>

            @if (!$services)
                <section class="ud-panel">
                    <div class="ud-empty">
                        <i class="bx bx-lock-alt" aria-hidden="true"></i>
                        <h2 class="ud-panel__title" data-d="no_modules_title">No modules are assigned to your role yet</h2>
                        <div data-d="no_modules_text">Ask the Director to grant your role access to the services you work with. Your dashboard will fill in automatically.</div>
                    </div>
                </section>
            @else
                {{-- ============ MASTHEAD ============ --}}
                <section class="ud-mast" aria-label="Welcome">
                    <div>
                        <div class="ud-date" id="ud-date">&nbsp;</div>
                        <h1 class="ud-title"><span id="ud-greet">Welcome back</span>@if ($payload['meta']['first_name']), {{ $payload['meta']['first_name'] }}@endif</h1>
                        <p class="ud-lede" data-d="hero_sub">A live view of registrations, approvals and workload across the services you manage.</p>
                        <div class="ud-who">
                            <span><i class="bx bx-id-card" aria-hidden="true"></i>{{ $payload['meta']['role'] }}</span>
                            <span><i class="bx bx-shield-quarter" aria-hidden="true"></i>{{ $payload['meta']['scope_label'] }}</span>
                            @if ($payload['meta']['jurisdiction'])
                                <span><i class="bx bx-map" aria-hidden="true"></i>{{ $payload['meta']['jurisdiction'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="ud-focus" id="ud-focus" aria-live="polite"></div>
                </section>

                {{-- ============ CONTROL STRIP ============ --}}
                <section class="ud-strip" aria-label="Dashboard controls">
                    <div class="ud-tabs" id="ud-tabs" role="tablist" aria-label="Service"></div>

                    <div class="ud-tools">
                        <span class="ud-stamp" id="ud-stamp" data-d="updated_now">Updated now</span>
                        <div class="ud-range" id="ud-range" role="group" aria-label="Period">
                            <button type="button" data-value="30" data-d="pc_30">30d</button>
                            <button type="button" data-value="90" data-d="pc_90">90d</button>
                            <button type="button" data-value="365" data-d="pc_365">12m</button>
                            <button type="button" data-value="all" data-d="pc_all">All</button>
                        </div>
                        <button type="button" class="ud-live" id="ud-live" aria-pressed="true" data-d-title="auto_title" title="Refresh the numbers every 2 minutes while this tab is open"><span class="pulse"></span><span data-d="live">Live</span></button>
                        <button type="button" class="ud-icon-btn" id="btn-refresh" data-d-title="refresh" title="Refresh"><i class="bx bx-refresh" aria-hidden="true"></i></button>
                        <button type="button" class="ud-icon-btn" id="btn-print" data-d-title="print" title="Print"><i class="bx bx-printer" aria-hidden="true"></i></button>
                    </div>
                </section>

                <div class="ud-main">
                    <section class="ud-notices" id="ud-notices" aria-label="Needs attention"></section>
                    <section class="ud-band" id="ud-band" aria-label="Key figures"></section>

                    <h2 class="ud-heading"><i class="bx bx-grid-alt" aria-hidden="true"></i><span data-d="h_services">Services</span></h2>
                    <div class="ud-svcs" id="ud-svcs"></div>

                    <h2 class="ud-heading"><i class="bx bx-line-chart" aria-hidden="true"></i><span data-d="h_overview">Registrations &amp; status</span></h2>
                    <div class="ud-grid">
                        <div class="ud-panel ud-c8">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_trend">Registration activity</h3>
                                    <p class="ud-panel__sub" data-d="c_trend_sub">New records by service</p>
                                </div>
                                <div class="ud-toggle" id="ud-trange" role="group" aria-label="Time range">
                                    <button type="button" data-value="daily" class="is-on" data-d="r_30d">30 days</button>
                                    <button type="button" data-value="monthly" data-d="r_12m">12 months</button>
                                </div>
                            </div>
                            <div class="ud-panel__body"><div id="chart-trend" class="ud-chart"></div></div>
                        </div>

                        <div class="ud-panel ud-c4">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_status">Where records stand</h3>
                                    <p class="ud-panel__sub" data-d="c_status_sub">Status of everything in the selected period</p>
                                </div>
                            </div>
                            <div class="ud-panel__body"><div id="chart-status" class="ud-chart"></div></div>
                            <div class="ud-panel__foot" id="status-foot"></div>
                        </div>
                    </div>

                    <div class="ud-grid">
                        <div class="ud-panel ud-c7">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_compare">Service comparison</h3>
                                    <p class="ud-panel__sub" data-d="c_compare_sub">Completed, waiting and rejected, per service</p>
                                </div>
                            </div>
                            <div class="ud-panel__body"><div id="chart-compare" class="ud-chart"></div></div>
                        </div>

                        <div class="ud-panel ud-c5">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" id="break-title" data-d="c_weekday">Busiest days</h3>
                                    <p class="ud-panel__sub" id="break-sub" data-d="c_weekday_sub">New records by weekday, last 12 weeks</p>
                                </div>
                            </div>
                            <div class="ud-panel__body"><div id="chart-break" class="ud-chart"></div></div>
                        </div>
                    </div>

                    <h2 class="ud-heading"><i class="bx bx-task" aria-hidden="true"></i><span data-d="h_queue">Work queue</span></h2>
                    <div class="ud-grid">
                        <div class="ud-panel ud-c7">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_pending">Waiting for your decision</h3>
                                    <p class="ud-panel__sub" data-d="c_pending_sub">Oldest first, across every service you can approve</p>
                                </div>
                            </div>
                            <div class="ud-panel__body ud-scroll" id="pending-table"></div>
                        </div>

                        <div class="ud-panel ud-c5">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_aging">How long records have waited</h3>
                                    <p class="ud-panel__sub" data-d="c_aging_sub">Current pending queue, by age</p>
                                </div>
                            </div>
                            <div class="ud-panel__body"><div id="chart-aging" class="ud-chart"></div></div>
                            <p class="ud-minihead" id="actions-head" data-d="h_actions">Quick actions</p>
                            <div class="ud-shortcuts" id="actions"></div>
                        </div>
                    </div>

                    <div id="insights-section" hidden>
                        <h2 class="ud-heading"><i class="bx bx-pie-chart-alt-2" aria-hidden="true"></i><span data-d="h_insights">Insights</span></h2>
                        <div class="ud-grid" id="insights"></div>
                    </div>

                    <h2 class="ud-heading"><i class="bx bx-pulse" aria-hidden="true"></i><span data-d="h_recent">Recent activity</span></h2>
                    <div class="ud-grid">
                        <div class="ud-panel ud-c6">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_recent">Latest registrations</h3>
                                    <p class="ud-panel__sub" data-d="c_recent_sub">Newest records across your services</p>
                                </div>
                            </div>
                            <div class="ud-panel__body" id="recent"></div>
                        </div>

                        <div class="ud-panel ud-c6">
                            <div class="ud-panel__head">
                                <div>
                                    <h3 class="ud-panel__title" data-d="c_activity">System activity</h3>
                                    <p class="ud-panel__sub" data-d="c_activity_sub">What staff have done recently</p>
                                </div>
                            </div>
                            <div class="ud-panel__body" id="activity"></div>
                        </div>
                    </div>

                    <div id="glance-section" hidden>
                        <div class="ud-panel">
                            <div class="ud-panel__head"><h3 class="ud-panel__title" data-d="h_glance">Directorate at a glance</h3></div>
                            <div class="ud-facts" id="glance"></div>
                        </div>
                    </div>
                </div>

                <div class="ud-toast" id="ud-toast" role="status" aria-live="polite"></div>
            @endif
        </div>
    </div>

    @if ($services)
        <script type="application/json" id="dash-initial">{!! json_encode($payload, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) !!}</script>
        {{-- ApexCharts comes from the layout footer; the script also waits for it and has a CDN fallback. --}}
        <script src="{{ asset('js/umsc-dashboard.js') }}?v={{ @filemtime(public_path('js/umsc-dashboard.js')) }}" defer></script>
    @endif
@endsection
