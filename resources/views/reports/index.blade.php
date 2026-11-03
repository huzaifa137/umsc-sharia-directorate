@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header :title="$definition['title']" subtitle="Filter the records below, then export."
            :crumbs="['Reports' => route('reports.hub'), $moduleLabel => null]">
            <a href="{{ url($module . '-dashboard') }}" class="ui-btn"><i class="bx bx-arrow-back rtl-flip"></i> {{ $moduleLabel }}</a>
            <a id="exportPdfBtn" href="{{ url('reports/' . $module . '/export/pdf') }}?{{ http_build_query($filters) }}" class="ui-btn ui-btn--primary"><i class="bx bxs-file-pdf"></i> Export PDF</a>
        </x-ui.page-header>

        <section class="card">
            <form id="filterForm" method="GET" action="{{ url('reports/' . $module) }}" class="ui-toolbar">
                <select name="status" class="ui-field" style="width:auto" aria-label="Status">
                    <option value="">All statuses</option>
                    @foreach ($definition['statusOptions'] as $value => $label)
                        <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <label class="d-flex align-items-center gap-2 mb-0 small text-muted">From <input type="date" name="date_from" class="ui-field" style="width:auto" value="{{ $filters['date_from'] ?? '' }}"></label>
                <label class="d-flex align-items-center gap-2 mb-0 small text-muted">To <input type="date" name="date_to" class="ui-field" style="width:auto" value="{{ $filters['date_to'] ?? '' }}"></label>
                <button type="submit" class="ui-btn ui-btn--primary"><i class="bx bx-filter-alt"></i> Apply</button>
                @if (array_filter($filters))<a href="{{ url('reports/' . $module) }}" class="ui-btn">Clear</a>@endif
                <span class="ms-auto small text-muted">{{ number_format($totalCount) }} {{ $totalCount === 1 ? 'record matches' : 'records match' }}</span>
            </form>

            @if ($rows->count())
                <div class="table-responsive">
                    <table class="table table-hover adm-table">
                        <thead><tr>@foreach ($definition['columns'] as $col)<th>{{ $col['label'] }}</th>@endforeach</tr></thead>
                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    @foreach ($definition['columns'] as $col)
                                        <td>
                                            @if ($col['key'] === 'status' && !empty($row[$col['key']]) && $row[$col['key']] !== '-')
                                                <x-ui.status-badge :status="$row[$col['key']]" />
                                            @elseif ($col['key'] === 'application_id')
                                                <span class="ui-id">{{ $row[$col['key']] ?? '-' }}</span>
                                            @else
                                                {{ $row[$col['key']] ?? '-' }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="adm-foot">
                    <span>Word and Excel exports are not available yet.</span>
                    {{ $records->links('pagination::bootstrap-5') }}
                </div>
            @else
                <x-ui.empty-state icon="bx-folder-open" title="No records match these filters" text="Widen the date range or clear the status filter.">
                    <a href="{{ url('reports/' . $module) }}" class="ui-btn">Clear filters</a>
                </x-ui.empty-state>
            @endif
        </section>
    </div>
@endsection
