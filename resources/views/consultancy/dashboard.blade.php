@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <x-ui.page-header title="Consultancy" subtitle="Consultation requests, guidance and review activity."
        :crumbs="['Dashboard' => url('/dashboard'), 'Consultancy' => null]">
        <a href="{{ route('consultancy.index') }}" class="ui-btn ui-btn--primary"><i class="bx bx-list-check"></i> All requests</a>
        <a href="{{ url('reports/consultancy') }}" class="ui-btn"><i class="bx bx-bar-chart-alt-2"></i> Reports</a>
    </x-ui.page-header>

    <x-ui.stats :cols="4">
        <x-ui.stat label="Total" :value="$stats['total']" note="All requests" icon="bx-message-square-detail"
            :href="route('consultancy.index')" />
        <x-ui.stat label="Submitted" :value="$stats['submitted']" note="Newly received" icon="bx-send"
            :href="route('consultancy.index', ['status' => 'submitted'])" />
        <x-ui.stat label="Under review" :value="$stats['under_review']" note="Being assessed" icon="bx-time-five" tone="warn"
            :href="route('consultancy.index', ['status' => 'under_review'])" />
        <x-ui.stat label="Approved" :value="$stats['approved']" note="Cleared" icon="bx-check-circle"
            :href="route('consultancy.index', ['status' => 'approved'])" />
    </x-ui.stats>

    <div class="ui-grid-2 mt-4">
        <x-ui.breakdown title="Request status" subtitle="Open a status to filter the list"
            :items="[
                ['label' => 'Submitted', 'value' => $stats['submitted'], 'tone' => 'info', 'href' => route('consultancy.index', ['status' => 'submitted'])],
                ['label' => 'Under review', 'value' => $stats['under_review'], 'tone' => 'warn', 'href' => route('consultancy.index', ['status' => 'under_review'])],
                ['label' => 'Reviewed', 'value' => $stats['reviewed'], 'tone' => 'info', 'href' => route('consultancy.index', ['status' => 'reviewed'])],
                ['label' => 'Approved', 'value' => $stats['approved'], 'tone' => 'ok', 'href' => route('consultancy.index', ['status' => 'approved'])],
                ['label' => 'Accomplished', 'value' => $stats['accomplished'], 'tone' => 'ok', 'href' => route('consultancy.index', ['status' => 'accomplished'])],
                ['label' => 'Rejected', 'value' => $stats['rejected'], 'tone' => 'bad', 'href' => route('consultancy.index', ['status' => 'rejected'])],
            ]"
            :footer-href="route('consultancy.index')" footer-label="View all consultancy records" />

        <x-ui.card title="Recent requests" :flush="true">
            @if ($recent->count())
                <ul class="ui-breakdown">
                    @foreach ($recent->take(6) as $item)
                        <li>
                            <a class="ui-breakdown__row" href="{{ route('consultancy.show', $item->id) }}">
                                <span class="ui-breakdown__label">
                                    {{ $item->applicant_name }}
                                    <span class="ui-sub">#{{ $item->application_id }} · {{ $item->created_at->format('d M Y') }}</span>
                                </span>
                                <x-ui.status-badge :status="$item->status" />
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-ui.empty-state title="No requests yet" text="New consultation requests will show up here." />
            @endif
        </x-ui.card>
    </div>

    <x-ui.report-card class="mt-4" :href="url('reports/consultancy')" module="consultancy records" />
</div>
@endsection
