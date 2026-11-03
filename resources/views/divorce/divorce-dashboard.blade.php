@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Divorce" subtitle="Applications, hearings and finalised cases."
            :crumbs="['Dashboard' => url('/dashboard'), 'Divorce' => null]">
            <a href="{{ url('divorce-application') }}" class="ui-btn ui-btn--primary"><i class="bx bx-plus"></i> New application</a>
            <a href="{{ url('reports/divorce') }}" class="ui-btn"><i class="bx bx-bar-chart-alt-2"></i> Reports</a>
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Total" :value="$all" note="All applications" icon="bx-group"
                :href="route('divorce.status.applications', ['statusId' => 100])" />
            <x-ui.stat label="Pending" :value="$pending" note="Awaiting review" icon="bx-time-five" tone="warn"
                :href="route('divorce.status.applications', ['statusId' => 0])" />
            <x-ui.stat label="Finalised" :value="$Finalised" note="Approved divorces" icon="bx-check-circle"
                :href="route('divorce.status.applications', ['statusId' => 10])" />
            <x-ui.stat label="Rejected" :value="$Rejected" note="Declined applications" icon="bx-x-circle" tone="bad"
                :href="route('divorce.status.applications', ['statusId' => -10])" />
        </x-ui.stats>

        <div class="ui-grid-2 mt-4">
            <x-ui.breakdown title="Case status" subtitle="Open a status to see the matching applications"
                :items="[
                    ['label' => 'Pending', 'value' => $pending, 'tone' => 'warn', 'href' => route('divorce.status.applications', ['statusId' => 0])],
                    ['label' => 'Approved', 'value' => $Finalised, 'tone' => 'ok', 'href' => route('divorce.status.applications', ['statusId' => 10])],
                    ['label' => 'Rejected', 'value' => $Rejected, 'tone' => 'bad', 'href' => route('divorce.status.applications', ['statusId' => -10])],
                ]"
                :footer-href="route('divorce.status.applications', ['statusId' => 100])" footer-label="View all divorce records" />

            <x-ui.report-card :href="url('reports/divorce')" module="divorce records" />
        </div>
    </div>
@endsection
