@php
    use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Guardianship" subtitle="Applications for the care and custody of wards."
            :crumbs="['Dashboard' => url('/dashboard'), 'Guardianship' => null]">
            <a href="{{ url('guardianship-application') }}" class="ui-btn ui-btn--primary"><i class="bx bx-plus"></i> New application</a>
            <a href="{{ url('reports/guardianship') }}" class="ui-btn"><i class="bx bx-bar-chart-alt-2"></i> Reports</a>
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Total" :value="$stats['total']" note="All applications" icon="bx-folder-open"
                :href="route('guardianship.status.applications', ['statusId' => 100])" />
            <x-ui.stat label="Pending review" :value="$stats['pending']" note="Awaiting processing" icon="bx-time-five" tone="warn"
                :href="route('guardianship.status.applications', ['statusId' => 0])" />
            <x-ui.stat label="Approved" :value="$stats['approved']" note="Successfully approved" icon="bx-check-circle"
                :href="route('guardianship.status.applications', ['statusId' => 10])" />
            <x-ui.stat label="Rejected" :value="$stats['rejected']" note="Declined applications" icon="bx-x-circle" tone="bad"
                :href="route('guardianship.status.applications', ['statusId' => -10])" />
        </x-ui.stats>

        <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
            <h2 class="h5 mb-0">Latest applications</h2>
            <a href="{{ route('guardianship.status.applications', ['statusId' => 100]) }}" class="ui-link">View all <i class="bx bx-right-arrow-alt rtl-flip"></i></a>
        </div>

        @if ($applications->count())
            <div class="ui-grid-3">
                @foreach ($applications as $application)
                    <article class="card ui-case">
                        <div class="ui-case__top">
                            <span class="ui-id">#{{ $application->application_id }}</span>
                            <x-ui.status-badge :status="$application->status" />
                        </div>
                        <div class="ui-case__who">
                            @if ($application->ward_photo_path)
                                <img class="ui-avatar" src="{{ Storage::url($application->ward_photo_path) }}" alt="{{ $application->ward_name }}">
                            @else
                                <span class="ui-avatar"><i class="bx bx-child"></i></span>
                            @endif
                            <div>
                                <h3>{{ $application->ward_name }}</h3>
                                <span class="ui-sub">{{ $application->ward_age }} years · {{ ucfirst($application->ward_gender) }}</span>
                            </div>
                        </div>
                        <dl>
                            <div><dt>Guardian</dt><dd>{{ $application->guardian_name }}</dd></div>
                            <div><dt>Relationship</dt><dd>{{ ucfirst($application->relationship_to_ward) }}</dd></div>
                            <div><dt>Type</dt><dd>{{ ucfirst($application->guardianship_type) }}</dd></div>
                            <div><dt>Contact</dt><dd>{{ $application->guardian_phone }}</dd></div>
                        </dl>
                        <div class="ui-case__foot">
                            <span><i class="bx bx-calendar"></i> {{ $application->created_at->format('d M Y') }}</span>
                            <a href="{{ url('guardianship-status-applications/100') }}" class="ui-link">View details</a>
                        </div>
                    </article>
                @endforeach
            </div>
            @if ($applications->hasPages())
                <div class="mt-4">{{ $applications->links('pagination::bootstrap-5') }}</div>
            @endif
        @else
            <x-ui.card>
                <x-ui.empty-state title="No guardianship applications yet" text="Applications submitted in your area will appear here." />
            </x-ui.card>
        @endif

        <x-ui.report-card class="mt-4" :href="url('reports/guardianship')" module="guardianship records" />
    </div>
@endsection
