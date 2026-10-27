@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mb-4">
            <div class="card-header" style="background: linear-gradient(135deg, #0d4b1e 0%, #08300f 100%); color: #fff;">
                <h5 class="mb-0"><i class="bx bx-certification me-2"></i> Certificates</h5>
                <small class="opacity-75">Search, preview, correct, and print certificates across every module.</small>
            </div>

            <div class="card-body">
                <form method="GET" action="{{ route('certificates.index') }}" id="certFilterForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Certificate Type *</label>
                            <select name="type" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                @foreach ($modules as $module)
                                    <option value="{{ $module['slug'] }}" {{ $selectedType === $module['slug'] ? 'selected' : '' }}>
                                        {{ $module['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold">Year</label>
                            <select name="year" class="form-select">
                                <option value="">Any</option>
                                @for ($y = now()->year; $y >= now()->year - 10; $y--)
                                    <option value="{{ $y }}" {{ ($filters['year'] ?? '') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold">Month</label>
                            <select name="month" class="form-select">
                                <option value="">Any</option>
                                @foreach (['1'=>'January','2'=>'February','3'=>'March','4'=>'April','5'=>'May','6'=>'June','7'=>'July','8'=>'August','9'=>'September','10'=>'October','11'=>'November','12'=>'December'] as $num => $name)
                                    <option value="{{ $num }}" {{ ($filters['month'] ?? '') == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold">Day <small class="text-muted">(optional)</small></label>
                            <input type="number" name="day" min="1" max="31" class="form-control" value="{{ $filters['day'] ?? '' }}" placeholder="e.g. 14">
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn w-100" style="background:#0d4b1e; color:#fff;">
                                <i class="bx bx-search-alt me-1"></i> Search
                            </button>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">Region</label>
                            <input type="text" name="region" class="form-control" list="certRegionList" value="{{ $filters['region'] ?? '' }}" placeholder="e.g. Busoga Muslim Region">
                            <datalist id="certRegionList"></datalist>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">District</label>
                            <input type="text" name="district" class="form-control" list="certDistrictList" value="{{ $filters['district'] ?? '' }}" placeholder="e.g. Bugweri">
                            <datalist id="certDistrictList"></datalist>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold">County</label>
                            <input type="text" name="county" class="form-control" value="{{ $filters['county'] ?? '' }}" placeholder="e.g. Namalemba County">
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if ($results !== null)
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h6 class="mb-0">
                        {{ collect($modules)->firstWhere('slug', $selectedType)['label'] }} —
                        {{ $results->total() }} certified {{ $results->total() === 1 ? 'record' : 'records' }} found
                    </h6>
                    <button id="printSelectedBtn" class="btn btn-sm btn-danger" disabled>
                        <i class="bx bx-printer me-1"></i> Print Selected (<span id="selectedCount">0</span>)
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background:#0d4b1e; color:#fff;">
                            <tr>
                                <th style="width:40px;"><input type="checkbox" id="selectAllCerts"></th>
                                <th>Application ID</th>
                                <th>Name(s)</th>
                                <th>Region / District</th>
                                <th>Registered</th>
                                <th style="width:220px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($results as $record)
                                <tr>
                                    <td><input type="checkbox" class="certRowCheckbox" value="{{ $record->id }}"></td>
                                    <td>{{ $record->application_id ?? $record->id }}</td>
                                    <td>{{ \App\Http\Controllers\Helper::certificateDisplayName($selectedType, $record) }}</td>
                                    <td>{{ $record->officer_region ?? '—' }} / {{ $record->officer_district ?? '—' }}</td>
                                    <td>{{ $record->created_at?->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('certificates.preview', [$selectedType, $record->id]) }}" target="_blank"
                                            class="btn btn-sm btn-outline-success">
                                            <i class="bx bx-show"></i> Preview / Print
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-warning quickEditBtn"
                                            data-id="{{ $record->id }}"
                                            data-fields="{{ json_encode($editableFields) }}">
                                            <i class="bx bx-edit"></i> Edit
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No certified records match those filters.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $results->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </div>

    <!-- Quick Edit Modal -->
    <div class="modal fade" id="quickEditModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background:#0d4b1e; color:#fff;">
                    <h5 class="modal-title">Quick Edit Before Printing</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="quickEditFieldsContainer">
                    <!-- injected fields go here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn" style="background:#0d4b1e;color:#fff;" id="saveQuickEditBtn">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Cascading region/district suggestions (same endpoints used elsewhere in the admin panel)
        fetch('{{ route("locations.regions") }}').then(r => r.json()).then(list => {
            document.getElementById('certRegionList').innerHTML = list.map(r => `<option value="${r}">`).join('');
        });
        fetch('{{ route("locations.districts") }}').then(r => r.json()).then(list => {
            document.getElementById('certDistrictList').innerHTML = list.map(d => `<option value="${d}">`).join('');
        });

        // Select-all + running count for bulk print
        const selectAll = document.getElementById('selectAllCerts');
        const printBtn = document.getElementById('printSelectedBtn');
        const countLabel = document.getElementById('selectedCount');

        function refreshSelection() {
            const checked = document.querySelectorAll('.certRowCheckbox:checked');
            countLabel.textContent = checked.length;
            printBtn.disabled = checked.length === 0;
        }

        selectAll?.addEventListener('change', function () {
            document.querySelectorAll('.certRowCheckbox').forEach(cb => cb.checked = selectAll.checked);
            refreshSelection();
        });

        document.querySelectorAll('.certRowCheckbox').forEach(cb => cb.addEventListener('change', refreshSelection));

        printBtn?.addEventListener('click', function () {
            const ids = Array.from(document.querySelectorAll('.certRowCheckbox:checked')).map(cb => cb.value);
            const type = {!! json_encode($selectedType) !!};
            window.open(`{{ route('certificates.bulk-print') }}?type=${type}&ids=${ids.join(',')}`, '_blank');
        });

        // Quick edit modal wiring
        let quickEditRecordId = null;
        const quickEditModalEl = document.getElementById('quickEditModal');
        const quickEditModal = new bootstrap.Modal(quickEditModalEl);
        const fieldLabels = {
            imam_name: 'Imam Name',
            masjid_name: 'Masjid / Mosque Name',
            mosque_name: 'Masjid / Mosque Name',
            divorce_place: 'Place of Divorce Pronouncement',
            place_of_death: 'Place of Death',
            conversion_place: 'Place of Conversion',
            officer_name: 'Verifying Officer Name',
        };

        document.querySelectorAll('.quickEditBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                quickEditRecordId = this.dataset.id;
                const fields = JSON.parse(this.dataset.fields);
                const container = document.getElementById('quickEditFieldsContainer');
                container.innerHTML = fields.map(f => `
                    <div class="mb-3">
                        <label class="form-label fw-bold">${fieldLabels[f] || f}</label>
                        <input type="text" class="form-control quickEditInput" data-field="${f}">
                    </div>
                `).join('');
                quickEditModal.show();
            });
        });

        document.getElementById('saveQuickEditBtn').addEventListener('click', async function () {
            const type = {!! json_encode($selectedType) !!};
            const inputs = document.querySelectorAll('.quickEditInput');

            for (const input of inputs) {
                if (!input.value.trim()) continue;

                await fetch(`/certificates/${type}/${quickEditRecordId}/update-field`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: `field=${encodeURIComponent(input.dataset.field)}&value=${encodeURIComponent(input.value)}`,
                });
            }

            quickEditModal.hide();
        });
    </script>
@endsection
