@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-3" style="background: #F0FDF4;">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-circle me-3" style="background: #00580f;">
                                <i class="bx bx-file text-white fs-3"></i>
                            </div>
                            <div>
                                <h1 class="fw-bold mb-1" style="color: #111827; font-size: 1.6rem;">{{ $definition['title'] }}</h1>
                                <p class="text-muted mb-0">Filter the records below, then export in your preferred format</p>
                            </div>
                        </div>
                        <a href="{{ url($module . '-dashboard') }}" class="btn" style="background: white; border: 1px solid #dee2e6;">
                            <i class="bx bx-arrow-back me-1"></i> Back to {{ $moduleLabel }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-body p-4">
                <form id="filterForm" method="GET" action="{{ url('reports/' . $module) }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Status</label>
                            <select name="status" class="form-select">
                                <option value="">All statuses</option>
                                @foreach ($definition['statusOptions'] as $value => $label)
                                    <option value="{{ $value }}" {{ ($filters['status'] ?? '') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">From</label>
                            <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">To</label>
                            <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                        </div>
                        <div class="col-md-3 d-flex gap-2">
                            <button type="submit" class="btn flex-grow-1" style="background: #00580f; color: white;">
                                <i class="bx bx-filter-alt me-1"></i> Apply
                            </button>
                            <a href="{{ url('reports/' . $module) }}" class="btn" style="background: #f1f5f9; color: #475569;" title="Clear filters">
                                <i class="bx bx-x"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Export actions -->
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h6 class="fw-bold mb-1">Export</h6>
                        <p class="text-muted small mb-0">{{ $totalCount }} record{{ $totalCount === 1 ? '' : 's' }} match the filters above</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a id="exportPdfBtn" href="{{ url('reports/' . $module . '/export/pdf') }}?{{ http_build_query($filters) }}"
                            class="btn fw-bold" style="background: #dc2626; color: white;">
                            <i class="bx bxs-file-pdf me-1"></i> Export PDF
                        </a>
                        <button type="button" class="btn fw-bold" style="background: #e9ecef; color: #6c757d;" disabled
                            title="Coming soon">
                            <i class="bx bxs-file-doc me-1"></i> Export Word
                        </button>
                        <button type="button" class="btn fw-bold" style="background: #e9ecef; color: #6c757d;" disabled
                            title="Coming soon">
                            <i class="bx bxs-spreadsheet me-1"></i> Export Excel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview table -->
        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #F8FAFC;">
                            <tr>
                                @foreach ($definition['columns'] as $col)
                                    <th class="text-uppercase small fw-bold text-muted px-4 py-3">{{ $col['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    @foreach ($definition['columns'] as $col)
                                        <td class="px-4">{{ $row[$col['key']] ?? '-' }}</td>
                                    @endforeach
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($definition['columns']) }}" class="text-center text-muted py-5">
                                        <i class="bx bx-folder-open fs-1 mb-2 d-block"></i>
                                        No records match these filters.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $records->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
