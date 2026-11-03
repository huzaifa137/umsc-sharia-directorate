@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Inheritance and estates" subtitle="Sharia-compliant asset distribution and legal heirship."
            :crumbs="['Dashboard' => url('/dashboard'), 'Inheritance' => null]">
            <a href="{{ url('reports/inheritance') }}" class="ui-btn"><i class="bx bx-bar-chart-alt-2"></i> Reports</a>
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Total" :value="$all ?? 0" note="All applications" icon="bx-buildings"
                :href="route('inheritance.status.applications', ['statusId' => 100])" />
            <x-ui.stat label="Approved" :value="$Finalised ?? 0" note="Distribution completed" icon="bx-check-circle"
                :href="route('inheritance.status.applications', ['statusId' => 10])" />
            <x-ui.stat label="Pending" :value="$pending ?? 0" note="Awaiting review" icon="bx-time-five" tone="warn"
                :href="route('inheritance.status.applications', ['statusId' => 0])" />
            <x-ui.stat label="Cancelled" :value="$Rejected ?? 0" note="Rejected applications" icon="bx-x-circle" tone="bad"
                :href="route('inheritance.status.applications', ['statusId' => -10])" />
        </x-ui.stats>

        <x-ui.card class="mt-4" title="Recent applications" subtitle="Latest estates in your scope" :flush="true">
            <x-slot:actions>
                <label class="ui-search mb-0">
                    <i class="bx bx-search" aria-hidden="true"></i>
                    <input type="search" id="inheritanceSearch" class="form-control form-control-sm"
                        placeholder="Search file ID, deceased, value, status" aria-label="Search applications">
                </label>
            </x-slot:actions>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 ui-table">
                    <thead>
                        <tr>
                            <th>File ID</th>
                            <th>Deceased</th>
                            <th>Estimated value</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr>
                                <td><span class="ui-id">#{{ $application->application_id }}</span></td>
                                <td>
                                    Late {{ $application->deceased_name }}
                                    <span class="ui-sub">Died {{ \Carbon\Carbon::parse($application->date_of_death)->format('d M Y') }}</span>
                                </td>
                                <td>UGX {{ number_format($application->total_estate_value) }}</td>
                                <td><x-ui.status-badge :status="$application->status" /></td>
                                @include('layouts.views.inheritance-actions')
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <x-ui.empty-state title="No inheritance applications yet"
                                        text="Applications submitted in your area will appear here." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @include('layouts.views.inheritance-actions-modals')
            @include('layouts.views.shared-status-modal')
            @include('layouts.views.case-modal-styles')

            @if ($applications->hasPages())
                <div class="card-footer">{{ $applications->links('pagination::bootstrap-5') }}</div>
            @endif
        </x-ui.card>

        <x-ui.report-card class="mt-4" :href="url('reports/inheritance')" module="inheritance records" />
    </div>

    <script>
        (function () {
            var input = document.getElementById('inheritanceSearch');
            if (!input) return;
            input.addEventListener('keyup', function () {
                var q = this.value.toLowerCase();
                document.querySelectorAll('.ui-table tbody tr').forEach(function (row) {
                    if (row.querySelector('td[colspan]')) return;
                    row.style.display = row.innerText.toLowerCase().includes(q) ? '' : 'none';
                });
            });
        })();
    </script>
@endsection
