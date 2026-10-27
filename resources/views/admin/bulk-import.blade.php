@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-3" style="background: rgba(181, 227, 209, 0.2);">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: #b58900;">
                            <i class="bx bx-cloud-upload text-white fs-3"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-1" style="color: #111827; font-size: 1.6rem;">Bulk Import</h1>
                            <p class="text-muted mb-0">Import Imaam directory, District Khadhi accounts, or Regional Assistant accounts</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: rgba(5,88,15,.1);">
                            <i class="bx bx-mosque fs-4" style="color:#00580f;"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4" style="color:#00580f;">{{ $mosqueCount }}</div>
                            <small class="text-muted">Mosques</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: rgba(5,149,128,.1);">
                            <i class="bx bx-user-check fs-4" style="color:#059580;"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4" style="color:#059580;">{{ $imaamAccountCount }}</div>
                            <small class="text-muted">Imaams</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: rgba(181, 0, 0, .1);">
                            <i class="bx bx-landscape fs-4" style="color:#b50000;"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4" style="color:#b50000;">{{ $districtKhadhiCount }}</div>
                            <small class="text-muted">District Khadhis</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm p-4" style="border-radius: 16px;">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: rgba(91, 42, 134, .1);">
                            <i class="bx bx-map-alt fs-4" style="color:#5b2a86;"></i>
                        </div>
                        <div>
                            <div class="fw-bold fs-4" style="color:#5b2a86;">{{ $regionalAssistantCount }}</div>
                            <small class="text-muted">Regional Assistants</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Upload Panel -->
            <div class="col-xl-7">
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3" style="color:#00580f;">Step 1 — Select Import Type & Upload File</h6>

                        <!-- Import Type Selector -->
                        <div class="mb-3">
                            <select id="importType" class="form-select" style="border-radius: 12px; border: 1px solid rgba(5,88,15,.2);">
                                <option value="imaam_directory">🕌 Imaam Directory (Mosque + Imaam)</option>
                                <option value="district_khadhi">⚖️ District Khadhi Accounts</option>
                                <option value="regional_assistant">📍 Regional Assistant Accounts</option>
                            </select>
                        </div>

                        <!-- Dynamic Instructions -->
                        <div id="importInstructions" class="mb-3">
                            <div id="instructions_imaam_directory" class="text-muted small">
                                <i class="bx bx-info-circle me-1" style="color:#00580f;"></i>
                                <strong>Required columns:</strong> Region, District, County, Mosque, Imaam, Location, Contact, Deputy Imaam, Contact
                                <br><span class="text-muted">Merged cells for Region/District/County are handled automatically.</span>
                            </div>
                            <div id="instructions_district_khadhi" class="text-muted small d-none">
                                <i class="bx bx-info-circle me-1" style="color:#00580f;"></i>
                                <strong>Required columns:</strong> Name, District, Contact
                                <br><span class="text-muted">Optional: Email</span>
                            </div>
                            <div id="instructions_regional_assistant" class="text-muted small d-none">
                                <i class="bx bx-info-circle me-1" style="color:#00580f;"></i>
                                <strong>Required columns:</strong> Name, Region, Contact
                                <br><span class="text-muted">Optional: Email</span>
                            </div>
                        </div>

                        <!-- Drop Zone -->
                        <div id="dropZone" class="border rounded-4 p-5 text-center mb-3"
                            style="border: 2px dashed rgba(5,88,15,.3) !important; cursor:pointer; background:#FAFFFC;">
                            <i class="bx bx-spreadsheet fs-1" style="color:#00580f;"></i>
                            <p class="fw-bold mb-1 mt-2" style="color:#00580f;">Click to choose or drag your .xlsx file here</p>
                            <small class="text-muted">Maximum size 10MB</small>
                            <input type="file" id="fileInput" accept=".xlsx,.xls" class="d-none">
                        </div>

                        <div id="fileSelectedRow" class="d-none alert d-flex align-items-center justify-content-between"
                            style="background: rgba(5,88,15,.06); border-radius: 12px;">
                            <span><i class="bx bx-file me-2"></i><span id="fileNameLabel"></span></span>
                            <button class="btn btn-sm" id="removeFileBtn"><i class="bx bx-x"></i></button>
                        </div>

                        <button id="previewBtn" class="btn fw-bold w-100 py-2" disabled
                            style="background: #00580f; color:white; border-radius: 12px;">
                            <i class="bx bx-search-alt me-2"></i> Preview Import
                        </button>

                        <!-- Preview Results -->
                        <div id="previewResults" class="d-none mt-4">
                            <hr>
                            <h6 class="fw-bold mb-3" style="color:#00580f;">Step 2 — Review & Confirm</h6>

                            <div class="row g-2 mb-3" id="previewStats">
                                <!-- Dynamically populated -->
                            </div>

                            <div class="table-responsive mb-3" style="max-height: 280px; overflow-y:auto;">
                                <table class="table table-sm table-hover">
                                    <thead class="bg-light">
                                        <tr id="previewHeaders">
                                            <!-- Dynamically populated -->
                                        </tr>
                                    </thead>
                                    <tbody id="previewTableBody"></tbody>
                                </table>
                            </div>

                            <button id="commitBtn" class="btn fw-bold w-100 py-2"
                                style="background: #00580f; color:white; border-radius: 12px;">
                                <i class="bx bx-check-shield me-2"></i> Confirm & Import Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Batches -->
            <div class="col-xl-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h6 class="fw-bold mb-0" style="color:#111827;">Recent Imports</h6>
                    </div>
                    <div class="card-body pt-0">
                        @forelse ($batches as $batch)
                            <div class="p-3 mb-2 rounded-3 d-flex justify-content-between align-items-center"
                                style="background: rgba(5,88,15,.04);">
                                <div>
                                    <div class="fw-bold small">
                                        {{ $batch->type_icon }} {{ $batch->type_label }}
                                    </div>
                                    <div class="small text-muted">
                                        {{ $batch->original_filename ?? 'Unknown' }}<br>
                                        {{ $batch->created_at->format('d M Y, H:i') }} —
                                        {{ $batch->creator->full_name ?? 'System' }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge rounded-pill px-2" style="background: rgba(5,88,15,.12); color:#00580f;">{{ $batch->created_count }} created</span>
                                    @if ($batch->duplicate_count)
                                        <span class="badge rounded-pill px-2" style="background: rgba(255,193,7,.12); color:#b58900;">{{ $batch->duplicate_count }} dup</span>
                                    @endif
                                    @if ($batch->error_count)
                                        <span class="badge rounded-pill px-2" style="background: rgba(220,53,69,.12); color:#dc3545;">{{ $batch->error_count }} errors</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="bx bx-cloud fs-1 mb-2"></i>
                                <p class="mb-0">No imports have been run yet.</p>
                            </div>
                        @endforelse

                        <div class="mt-2">{{ $batches->links('pagination::bootstrap-5') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Credentials Modal -->
    <div class="modal fade" id="credentialsModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 16px;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" style="color:#00580f;">
                        <i class="bx bx-key me-2"></i>Import Complete — Save These Credentials
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert mb-3" style="background: rgba(255,193,7,.12); color:#b58900; border-radius:12px;">
                        <i class="bx bx-error-circle me-1"></i>
                        These temporary passwords are shown only once and are <strong>not</strong> stored anywhere.
                        Download them now and share securely with each user — they'll be asked to set a new
                        password the first time they log in.
                    </div>
                    <div class="table-responsive" style="max-height: 320px; overflow-y:auto;">
                        <table class="table table-sm">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Region</th>
                                    <th>District</th>
                                    <th>Username</th>
                                    <th>Temp Password</th>
                                </tr>
                            </thead>
                            <tbody id="credentialsTableBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn fw-bold" id="downloadCredentialsBtn" style="background: rgba(5,88,15,.1); color:#00580f;">
                        <i class="bx bx-download me-1"></i> Download as CSV
                    </button>
                    <button class="btn fw-bold text-white" data-bs-dismiss="modal" id="closeCredentialsBtn"
                        style="background: #00580f;">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const fileSelectedRow = document.getElementById('fileSelectedRow');
        const fileNameLabel = document.getElementById('fileNameLabel');
        const previewBtn = document.getElementById('previewBtn');
        const previewResults = document.getElementById('previewResults');
        const commitBtn = document.getElementById('commitBtn');
        const importTypeSelect = document.getElementById('importType');

        let currentToken = null;
        let currentFilename = null;
        let lastCredentials = [];
        let currentImportType = 'imaam_directory';

        // Import type change handler
        importTypeSelect.addEventListener('change', function() {
            currentImportType = this.value;
            
            // Hide all instructions
            document.querySelectorAll('[id^="instructions_"]').forEach(el => el.classList.add('d-none'));
            
            // Show relevant instructions
            const instr = document.getElementById(`instructions_${this.value}`);
            if (instr) instr.classList.remove('d-none');
            
            // Reset preview
            previewResults.classList.add('d-none');
            fileInput.value = '';
            fileSelectedRow.classList.add('d-none');
            previewBtn.disabled = true;
        });

        // Drop zone handlers
        dropZone.addEventListener('click', () => fileInput.click());
        dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.style.background = '#F0FDF4'; });
        dropZone.addEventListener('dragleave', () => dropZone.style.background = '#FAFFFC');
        dropZone.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.style.background = '#FAFFFC';
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelected();
            }
        });
        fileInput.addEventListener('change', handleFileSelected);

        function handleFileSelected() {
            const file = fileInput.files[0];
            if (!file) return;
            fileNameLabel.textContent = `${file.name} (${(file.size / 1024).toFixed(0)} KB)`;
            fileSelectedRow.classList.remove('d-none');
            previewBtn.disabled = false;
            previewResults.classList.add('d-none');
        }

        document.getElementById('removeFileBtn').addEventListener('click', () => {
            fileInput.value = '';
            fileSelectedRow.classList.add('d-none');
            previewBtn.disabled = true;
            previewResults.classList.add('d-none');
        });

        // Preview button handler
        previewBtn.addEventListener('click', () => {
            const file = fileInput.files[0];
            if (!file) return;

            previewBtn.disabled = true;
            previewBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i> Reading file...';

            const formData = new FormData();
            formData.append('file', file);
            formData.append('import_type', currentImportType);

            fetch('{{ route("bulk-import.preview") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken },
                body: formData,
            })
            .then(async res => {
                const text = await res.text();
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Server returned an unexpected response (HTTP ' + res.status + ').');
                }

                previewBtn.disabled = false;
                previewBtn.innerHTML = '<i class="bx bx-search-alt me-2"></i> Preview Import';

                if (!data.status) {
                    Swal.fire('Error', data.message || 'Unable to read this file.', 'error');
                    return;
                }

                currentToken = data.token;
                currentFilename = data.original_filename;

                // Build preview stats dynamically
                const statsContainer = document.getElementById('previewStats');
                const summary = data.summary;
                
                let statsHtml = '';
                if (data.import_type === 'imaam_directory') {
                    statsHtml = `
                        <div class="col-3"><div class="text-center p-2 rounded-3" style="background: rgba(5,88,15,.06);">
                            <div class="fw-bold">${summary.total_rows}</div><small class="text-muted">Total Rows</small>
                        </div></div>
                        <div class="col-3"><div class="text-center p-2 rounded-3" style="background: rgba(5,149,128,.08);">
                            <div class="fw-bold">${summary.mosques_found}</div><small class="text-muted">Mosques</small>
                        </div></div>
                        <div class="col-3"><div class="text-center p-2 rounded-3" style="background: rgba(255,193,7,.12);">
                            <div class="fw-bold">${summary.with_imaam}</div><small class="text-muted">With Imaam</small>
                        </div></div>
                        <div class="col-3"><div class="text-center p-2 rounded-3" style="background: rgba(220,53,69,.08);">
                            <div class="fw-bold">${summary.context_errors}</div><small class="text-muted">Issues</small>
                        </div></div>
                    `;
                } else {
                    statsHtml = `
                        <div class="col-6"><div class="text-center p-2 rounded-3" style="background: rgba(5,88,15,.06);">
                            <div class="fw-bold">${summary.total_rows}</div><small class="text-muted">Total Rows</small>
                        </div></div>
                        <div class="col-6"><div class="text-center p-2 rounded-3" style="background: rgba(5,149,128,.08);">
                            <div class="fw-bold">${summary.accounts_to_create}</div><small class="text-muted">Accounts to Create</small>
                        </div></div>
                    `;
                }
                statsContainer.innerHTML = statsHtml;

                // Build preview table
                const tbody = document.getElementById('previewTableBody');
                const headers = document.getElementById('previewHeaders');
                
                if (data.import_type === 'imaam_directory') {
                    headers.innerHTML = '<th>Row</th><th>District / County</th><th>Mosque</th><th>Imaam</th>';
                    tbody.innerHTML = data.preview.filter(r => r.type !== 'blank').map(r => {
                        if (r.type === 'error') {
                            return `<tr class="table-danger"><td>${r.row_number}</td><td colspan="3"><i class="bx bx-error-circle me-1"></i>${r.message}</td></tr>`;
                        }
                        return `<tr><td>${r.row_number}</td><td>${r.district} / ${r.county}</td><td>${r.mosque}</td><td>${r.imaam ?? '<span class="text-muted">—</span>'}</td></tr>`;
                    }).join('');
                } else {
                    headers.innerHTML = '<th>Row</th><th>Region</th><th>District</th><th>Full Name</th><th>Contact</th>';
                    tbody.innerHTML = data.preview.filter(r => r.type !== 'blank').map(r => {
                        if (r.type === 'error') {
                            return `<tr class="table-danger"><td>${r.row_number}</td><td colspan="4"><i class="bx bx-error-circle me-1"></i>${r.message}</td></tr>`;
                        }
                        return `<tr><td>${r.row_number}</td><td>${r.region}</td><td>${r.district ?? 'N/A'}</td><td>${r.full_name}</td><td>${r.contact ?? '—'}</td></tr>`;
                    }).join('');
                }

                previewResults.classList.remove('d-none');
                previewResults.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .catch((err) => {
                previewBtn.disabled = false;
                previewBtn.innerHTML = '<i class="bx bx-search-alt me-2"></i> Preview Import';
                Swal.fire('Error', err.message || 'Unable to read this file.', 'error');
            });
        });

        // Commit button handler
        commitBtn.addEventListener('click', () => {
            if (!currentToken) return;

            Swal.fire({
                title: 'Confirm Import',
                text: 'This will create the accounts shown above. Continue?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#00580f',
                confirmButtonText: 'Yes, import now',
            }).then(result => {
                if (!result.isConfirmed) return;

                commitBtn.disabled = true;
                commitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-2"></i> Importing...';

                fetch('{{ route("bulk-import.commit") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ 
                        token: currentToken, 
                        original_filename: currentFilename,
                        import_type: currentImportType,
                    }),
                })
                .then(async res => {
                    const text = await res.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        throw new Error('Server returned an unexpected response.');
                    }

                    commitBtn.disabled = false;
                    commitBtn.innerHTML = '<i class="bx bx-check-shield me-2"></i> Confirm & Import Now';

                    if (!data.status) {
                        Swal.fire('Error', data.message || 'Import failed.', 'error');
                        return;
                    }

                    lastCredentials = data.credentials || [];

                    if (lastCredentials.length) {
                        const tbody = document.getElementById('credentialsTableBody');
                        tbody.innerHTML = lastCredentials.map(c => `
                            <tr>
                                <td>${c.full_name}</td>
                                <td>${c.region}</td>
                                <td>${c.district}</td>
                                <td><code>${c.username}</code></td>
                                <td><code>${c.temp_password}</code></td>
                            </tr>
                        `).join('');

                        bootstrap.Modal.getOrCreateInstance(document.getElementById('credentialsModal')).show();
                    } else {
                        Swal.fire('Done', `Import completed — ${data.created} created, ${data.duplicates} skipped, ${data.errors} errors.`, 'success')
                            .then(() => location.reload());
                    }
                })
                .catch((err) => {
                    commitBtn.disabled = false;
                    commitBtn.innerHTML = '<i class="bx bx-check-shield me-2"></i> Confirm & Import Now';
                    Swal.fire('Error', err.message || 'Import failed.', 'error');
                });
            });
        });

        // Download credentials
        document.getElementById('downloadCredentialsBtn').addEventListener('click', () => {
            if (!lastCredentials.length) return;

            const header = 'Name,Region,District,Username,Temporary Password\n';
            const rows = lastCredentials.map(c =>
                [c.full_name, c.region, c.district, c.username, c.temp_password]
                    .map(v => `"${(v ?? '').toString().replace(/"/g, '""')}"`).join(',')
            ).join('\n');

            const blob = new Blob([header + rows], { type: 'text/csv' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `credentials-${Date.now()}.csv`;
            a.click();
            URL.revokeObjectURL(url);
        });

        document.getElementById('closeCredentialsBtn').addEventListener('click', () => location.reload());
    </script>
@endsection