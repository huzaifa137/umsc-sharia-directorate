@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Nikah" subtitle="Marriage registrations, certificates and monthly activity."
            :crumbs="['Dashboard' => url('/dashboard'), 'Nikah' => null]">
            <a href="{{ url('nikah-applications') }}" class="ui-btn ui-btn--primary"><i class="bx bx-plus"></i> New application</a>
            <a href="{{ url('reports/nikah') }}" class="ui-btn"><i class="bx bx-bar-chart-alt-2"></i> Reports</a>
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Total" :value="$totalNikah" note="All applications" icon="bx-heart"
                :href="route('nikah.status.applications', ['statusId' => 100])" />
            <x-ui.stat label="Pending" :value="$submittedNikah" note="Awaiting review" icon="bx-time-five" tone="warn"
                :href="route('nikah.status.applications', ['statusId' => 0])" />
            <x-ui.stat label="Approved" :value="$approvedNikah" note="Completed Nikah" icon="bx-check-circle"
                :href="route('nikah.status.applications', ['statusId' => 10])" />
            <x-ui.stat label="Rejected" :value="$rejectedNikah" note="Declined applications" icon="bx-x-circle" tone="bad"
                :href="route('nikah.status.applications', ['statusId' => -10])" />
        </x-ui.stats>

        <div class="ui-grid-2 mt-4">
            <x-ui.breakdown title="This month" subtitle="Records handled in the current month"
                :items="[
                    ['label' => 'Pending', 'value' => $pendingNikah, 'tone' => 'warn', 'href' => route('nikah.status.applications', ['statusId' => 0])],
                    ['label' => 'Approved', 'value' => $approvedNikah, 'tone' => 'ok', 'href' => route('nikah.status.applications', ['statusId' => 10])],
                    ['label' => 'Rejected', 'value' => $rejectedNikah, 'tone' => 'bad', 'href' => route('nikah.status.applications', ['statusId' => -10])],
                    ['label' => 'Month total', 'value' => $thisMonthNikah, 'tone' => 'idle'],
                ]"
                :footer-href="url('nikah-applications')" footer-label="View all Nikah records" />

            <x-ui.report-card :href="url('reports/nikah')" module="Nikah records" />
        </div>
    </div>
@endsection
