@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="New Muslim converts" subtitle="Conversion records and certification."
            :crumbs="['Dashboard' => url('/dashboard'), 'Converts' => null]">
            <a href="{{ route('convert.application') }}" class="ui-btn ui-btn--primary"><i class="bx bx-plus"></i> Register convert</a>
            <a href="{{ url('reports/convert') }}" class="ui-btn"><i class="bx bx-bar-chart-alt-2"></i> Reports</a>
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Total converts" :value="$stats['total_converts'] ?? 0" note="All records" icon="bx-user-plus"
                :href="route('convert.status.applications', ['statusId' => 100])" />
            <x-ui.stat label="Pending" :value="$stats['pending'] ?? 0" note="Awaiting certification" icon="bx-time-five" tone="warn"
                :href="route('convert.status.applications', ['statusId' => 0])" />
            <x-ui.stat label="Certified" :value="$accomplished ?? 0" note="Certificates issued" icon="bx-badge-check"
                :href="route('convert.status.applications', ['statusId' => 10])" />
            <x-ui.stat label="This month" :value="$stats['this_month'] ?? 0" note="New registrations" icon="bx-calendar" />
        </x-ui.stats>

        <x-ui.card class="mt-4" title="Recent records" subtitle="Latest conversions in your scope" :flush="true">
            <x-slot:actions>
                <label class="ui-search mb-0">
                    <i class="bx bx-search" aria-hidden="true"></i>
                    <input type="search" id="searchInput" class="form-control form-control-sm"
                        placeholder="Search ID, name, date, status" aria-label="Search records">
                </label>
            </x-slot:actions>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 ui-table">
                    <thead>
                        <tr>
                            <th>Record</th>
                            <th>Former name</th>
                            <th>New name</th>
                            <th>Registered</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr class="application-row"
                                data-search="{{ strtolower($application->application_id . ' ' . $application->former_names . ' ' . $application->new_names . ' ' . $application->created_at . ' ' . $application->status) }}">
                                <td><span class="ui-id">#{{ $application->application_id }}</span></td>
                                <td>{{ trim($application->former_names) }}</td>
                                <td>{{ trim($application->new_names) }}</td>
                                <td>{{ $application->created_at }}</td>
                                <td><x-ui.status-badge :status="$application->status" /></td>
                                @include('layouts.views.converts-action')
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-ui.empty-state title="No convert records yet"
                                        text="Registered converts will appear here." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('layouts.views.converts-action-modals')
            @include('layouts.views.shared-status-modal')
            @include('layouts.views.case-modal-styles')

            @if ($applications->hasPages())
                <div class="card-footer">{{ $applications->links('pagination::bootstrap-5') }}</div>
            @endif
        </x-ui.card>

        <div class="ui-grid-2 mt-4">
            <x-ui.card title="Former religions" subtitle="Share of all records">
                <div class="ui-meter" style="padding:0">
                    @forelse (($stats['religions'] ?? []) as $religion => $percentage)
                        <div>
                            <div class="ui-meter__row"><span>{{ $religion }}</span><strong>{{ $percentage }}%</strong></div>
                            <div class="ui-bar"><span style="width: {{ (int) $percentage }}%"></span></div>
                        </div>
                    @empty
                        <p class="text-muted small mb-0">No data yet.</p>
                    @endforelse
                </div>
            </x-ui.card>

            <x-ui.report-card :href="url('reports/convert')" module="convert records" />
        </div>
    </div>

    <script>
        (function () {
            var input = document.getElementById('searchInput');
            if (!input) return;
            input.addEventListener('keyup', function () {
                var q = this.value.toLowerCase();
                document.querySelectorAll('.application-row').forEach(function (row) {
                    row.style.display = (row.getAttribute('data-search') || '').includes(q) ? '' : 'none';
                });
            });
        })();
    </script>
@endsection
