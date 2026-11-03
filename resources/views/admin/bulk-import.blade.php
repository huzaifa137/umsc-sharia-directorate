@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Bulk import" subtitle="Load the mosque and Imaam directory, or create District Khadhi and Regional Assistant accounts from a spreadsheet."
            :crumbs="['Records & publishing' => null, 'Bulk import' => null]" />

        <x-ui.stats :cols="4">
            <x-ui.stat label="Mosques" :value="$mosqueCount" note="In the directory" icon="bx-buildings" />
            <x-ui.stat label="Imaams" :value="$imaamAccountCount" note="Linked to a mosque" icon="bx-user-check" />
            <x-ui.stat label="District Khadhis" :value="$districtKhadhiCount" note="Accounts" icon="bx-landscape" />
            <x-ui.stat label="Regional Assistants" :value="$regionalAssistantCount" note="Accounts" icon="bx-map-alt" />
        </x-ui.stats>

        <ol class="adm-steps" id="importSteps" aria-label="Import progress">
            <li class="is-current" data-step="1">Choose a file</li>
            <li data-step="2">Review the preview</li>
            <li data-step="3">Confirm the import</li>
        </ol>

        <div class="adm-cols">
            <section class="card">
                <div class="card-header">
                    <h2 class="h5 mb-0">Upload</h2>
                    <p class="text-muted small mb-0 mt-1">Nothing is created until you confirm the preview.</p>
                </div>
                <div class="card-body">
                    <div class="ui-field mb-3">
                        <label for="importType">What are you importing?</label>
                        <select id="importType" class="form-select">
                            <option value="imaam_directory">Imaam directory (mosques and Imaams)</option>
                            <option value="district_khadhi">District Khadhi accounts</option>
                            <option value="regional_assistant">Regional Assistant accounts</option>
                        </select>
                    </div>

                    <div id="importInstructions" class="mb-3">
                        <div id="instructions_imaam_directory" class="adm-hintbox"><b>Required columns:</b> Region, District, County, Mosque, Imaam, Location, Contact, Deputy Imaam, Contact. Merged Region, District and County cells are handled automatically.</div>
                        <div id="instructions_district_khadhi" class="adm-hintbox d-none"><b>Required columns:</b> Name, District, Contact. Optional: Email.</div>
                        <div id="instructions_regional_assistant" class="adm-hintbox d-none"><b>Required columns:</b> Name, Region, Contact. Optional: Email.</div>
                    </div>

                    <div id="dropZone" class="adm-drop" tabindex="0" role="button" aria-label="Choose a spreadsheet to upload">
                        <i class="bx bx-spreadsheet" aria-hidden="true"></i>
                        <strong>Drop an Excel file here, or click to browse</strong>
                        <small>.xlsx or .xls, up to 10 MB</small>
                        <input type="file" id="fileInput" accept=".xlsx,.xls" class="d-none">
                    </div>

                    <div id="fileSelectedRow" class="adm-file d-none">
                        <span><i class="bx bx-file" aria-hidden="true"></i><em id="fileNameLabel"></em></span>
                        <button type="button" class="adm-icon-btn" id="removeFileBtn" aria-label="Remove file"><i class="bx bx-x"></i></button>
                    </div>

                    <button type="button" id="previewBtn" class="ui-btn ui-btn--primary mt-3" disabled><i class="bx bx-search-alt"></i> Preview import</button>

                    <div id="previewResults" class="d-none mt-4">
                        <h3 class="h6 mb-3">Preview</h3>
                        <div class="adm-mini" id="previewStats"></div>
                        <div class="adm-scroll mb-3">
                            <table class="table adm-table">
                                <thead><tr id="previewHeaders"></tr></thead>
                                <tbody id="previewTableBody"></tbody>
                            </table>
                        </div>
                        <button type="button" id="commitBtn" class="ui-btn ui-btn--primary"><i class="bx bx-check-shield"></i> Confirm and import</button>
                    </div>
                </div>
            </section>

            <section class="card">
                <div class="card-header"><h2 class="h5 mb-0">Recent imports</h2></div>
                @if ($batches->count())
                    <div class="table-responsive">
                        <table class="table adm-table">
                            <thead><tr><th>Import</th><th>Result</th></tr></thead>
                            <tbody>
                                @foreach ($batches as $batch)
                                    <tr>
                                        <td>
                                            <strong class="d-block" style="font-size:.88rem">{{ $batch->type_label }}</strong>
                                            <span class="ui-sub">{{ $batch->original_filename ?? 'Unknown file' }}</span>
                                            <span class="ui-sub">{{ $batch->created_at->format('d M Y, H:i') }} · {{ $batch->creator->full_name ?? 'System' }}</span>
                                        </td>
                                        <td>
                                            <div class="adm-batch">
                                                <x-ui.status-badge status="approved" :label="$batch->created_count . ' created'" />
                                                @if ($batch->duplicate_count)<x-ui.status-badge status="pending" :label="$batch->duplicate_count . ' skipped'" />@endif
                                                @if ($batch->error_count)<x-ui.status-badge status="rejected" :label="$batch->error_count . ' errors'" />@endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="adm-foot"><span>{{ number_format($batches->total()) }} imports</span>{{ $batches->links('pagination::bootstrap-5') }}</div>
                @else
                    <x-ui.empty-state icon="bx-cloud-upload" title="No imports yet" text="Imports you run will be listed here." />
                @endif
            </section>
        </div>
    </div>

    {{-- Credentials shown once after account imports --}}
    <div class="modal fade adm-modal" id="credentialsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="credTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="credTitle">Import complete: save these credentials</h5></div>
                <div class="modal-body">
                    <p class="adm-hintbox mb-3">These temporary passwords are shown <b>only once</b> and are not stored anywhere readable. Download them now and share each one securely. Each officer must set a new password at first sign-in.</p>
                    <div class="adm-scroll" style="background:#fff">
                        <table class="table adm-table">
                            <thead><tr><th>Name</th><th>Region</th><th>District</th><th>Username</th><th>Temporary password</th></tr></thead>
                            <tbody id="credentialsTableBody"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="ui-btn" id="downloadCredentialsBtn"><i class="bx bx-download"></i> Download CSV</button>
                    <button type="button" class="ui-btn ui-btn--primary" data-bs-dismiss="modal" id="closeCredentialsBtn">Done</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var $ = function (id) { return document.getElementById(id); };
            var dropZone = $('dropZone'), fileInput = $('fileInput'), fileRow = $('fileSelectedRow'), previewBtn = $('previewBtn');
            var results = $('previewResults'), commitBtn = $('commitBtn'), typeSel = $('importType');
            var token = null, filename = null, creds = [], type = 'imaam_directory';

            function esc(v) { var d = document.createElement('div'); d.textContent = v == null ? '' : String(v); return d.innerHTML; }
            function step(n) {
                document.querySelectorAll('#importSteps li').forEach(function (li) {
                    var s = +li.dataset.step;
                    li.classList.toggle('is-current', s === n);
                    li.classList.toggle('is-done', s < n);
                });
            }
            function clearFile() {
                fileInput.value = ''; fileRow.classList.add('d-none'); previewBtn.disabled = true; results.classList.add('d-none'); token = null; step(1);
            }

            typeSel.addEventListener('change', function () {
                type = this.value;
                document.querySelectorAll('[id^="instructions_"]').forEach(function (el) { el.classList.add('d-none'); });
                var ins = $('instructions_' + type); if (ins) ins.classList.remove('d-none');
                clearFile();
            });

            dropZone.addEventListener('click', function () { fileInput.click(); });
            dropZone.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); fileInput.click(); } });
            ['dragenter', 'dragover'].forEach(function (ev) { dropZone.addEventListener(ev, function (e) { e.preventDefault(); dropZone.classList.add('is-over'); }); });
            ['dragleave', 'drop'].forEach(function (ev) { dropZone.addEventListener(ev, function (e) { e.preventDefault(); dropZone.classList.remove('is-over'); }); });
            dropZone.addEventListener('drop', function (e) { if (e.dataTransfer.files.length) { fileInput.files = e.dataTransfer.files; picked(); } });
            fileInput.addEventListener('change', picked);
            $('removeFileBtn').addEventListener('click', clearFile);

            function picked() {
                var file = fileInput.files[0]; if (!file) return;
                if (file.size > 10 * 1024 * 1024) { UMSC.toast('error', 'That file is larger than 10 MB.'); clearFile(); return; }
                $('fileNameLabel').textContent = file.name + ' (' + Math.max(1, Math.round(file.size / 1024)) + ' KB)';
                fileRow.classList.remove('d-none'); previewBtn.disabled = false; results.classList.add('d-none'); step(1);
            }

            function stat(n, label) { return '<div><strong>' + esc(n) + '</strong><span>' + esc(label) + '</span></div>'; }

            previewBtn.addEventListener('click', function () {
                var file = fileInput.files[0]; if (!file) return;
                UMSC.busy(previewBtn, true, 'Reading file…');
                var fd = new FormData(); fd.append('file', file); fd.append('import_type', type);
                fetch('{{ route('bulk-import.preview') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }, body: fd })
                    .then(function (res) {
                        return res.text().then(function (text) {
                            var data; try { data = JSON.parse(text); } catch (e) { throw new Error('The server returned an unexpected response (HTTP ' + res.status + ').'); }
                            return data;
                        });
                    })
                    .then(function (data) {
                        UMSC.busy(previewBtn, false);
                        if (!data.status) { UMSC.toast('error', data.message || 'Unable to read this file.'); return; }
                        token = data.token; filename = data.original_filename;
                        var s = data.summary || {}, head = $('previewHeaders'), body = $('previewTableBody'), rows = (data.preview || []).filter(function (r) { return r.type !== 'blank'; });
                        if (data.import_type === 'imaam_directory') {
                            $('previewStats').innerHTML = stat(s.total_rows, 'Rows') + stat(s.mosques_found, 'Mosques') + stat(s.with_imaam, 'With Imaam') + stat(s.context_errors, 'Issues');
                            head.innerHTML = '<th>Row</th><th>District / county</th><th>Mosque</th><th>Imaam</th>';
                            body.innerHTML = rows.map(function (r) {
                                if (r.type === 'error') return '<tr class="is-error"><td class="adm-num">' + esc(r.row_number) + '</td><td colspan="3">' + esc(r.message) + '</td></tr>';
                                return '<tr><td class="adm-num">' + esc(r.row_number) + '</td><td>' + esc(r.district) + ' / ' + esc(r.county) + '</td><td>' + esc(r.mosque) + '</td><td>' + (r.imaam ? esc(r.imaam) : '<span class="adm-muted">—</span>') + '</td></tr>';
                            }).join('');
                        } else {
                            $('previewStats').innerHTML = stat(s.total_rows, 'Rows') + stat(s.accounts_to_create, 'Accounts to create');
                            head.innerHTML = '<th>Row</th><th>Region</th><th>District</th><th>Name</th><th>Contact</th>';
                            body.innerHTML = rows.map(function (r) {
                                if (r.type === 'error') return '<tr class="is-error"><td class="adm-num">' + esc(r.row_number) + '</td><td colspan="4">' + esc(r.message) + '</td></tr>';
                                return '<tr><td class="adm-num">' + esc(r.row_number) + '</td><td>' + esc(r.region) + '</td><td>' + esc(r.district || 'N/A') + '</td><td>' + esc(r.full_name) + '</td><td>' + (r.contact ? esc(r.contact) : '<span class="adm-muted">—</span>') + '</td></tr>';
                            }).join('');
                        }
                        results.classList.remove('d-none'); step(2);
                        results.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    })
                    .catch(function (err) { UMSC.busy(previewBtn, false); UMSC.toast('error', err.message || 'Unable to read this file.'); });
            });

            commitBtn.addEventListener('click', function () {
                if (!token) return;
                UMSC.confirm({ title: 'Import these records?', text: 'This creates the accounts and records shown in the preview.', confirmText: 'Import now' }).then(function (ok) {
                    if (!ok) return;
                    step(3); UMSC.busy(commitBtn, true, 'Importing…');
                    fetch('{{ route('bulk-import.commit') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                        body: JSON.stringify({ token: token, original_filename: filename, import_type: type })
                    }).then(function (res) {
                        return res.text().then(function (text) { try { return JSON.parse(text); } catch (e) { throw new Error('The server returned an unexpected response.'); } });
                    }).then(function (data) {
                        UMSC.busy(commitBtn, false);
                        if (!data.status) { step(2); UMSC.toast('error', data.message || 'Import failed.'); return; }
                        creds = data.credentials || [];
                        if (creds.length) {
                            $('credentialsTableBody').innerHTML = creds.map(function (c) {
                                return '<tr><td>' + esc(c.full_name) + '</td><td>' + esc(c.region) + '</td><td>' + esc(c.district) + '</td><td class="adm-mono">' + esc(c.username) + '</td><td class="adm-mono">' + esc(c.temp_password) + '</td></tr>';
                            }).join('');
                            bootstrap.Modal.getOrCreateInstance($('credentialsModal')).show();
                        } else {
                            UMSC.toast('success', 'Import complete: ' + data.created + ' created, ' + data.duplicates + ' skipped, ' + data.errors + ' errors.');
                            setTimeout(function () { location.reload(); }, 1400);
                        }
                    }).catch(function (err) { UMSC.busy(commitBtn, false); step(2); UMSC.toast('error', err.message || 'Import failed.'); });
                });
            });

            $('downloadCredentialsBtn').addEventListener('click', function () {
                if (!creds.length) return;
                function cell(v) { v = (v == null ? '' : String(v)); if (/^[=+\-@\t\r]/.test(v)) v = "'" + v; return '"' + v.replace(/"/g, '""') + '"'; }
                var csv = 'Name,Region,District,Username,Temporary Password\n' + creds.map(function (c) {
                    return [c.full_name, c.region, c.district, c.username, c.temp_password].map(cell).join(',');
                }).join('\n');
                var a = document.createElement('a');
                a.href = URL.createObjectURL(new Blob([csv], { type: 'text/csv' }));
                a.download = 'credentials-' + Date.now() + '.csv';
                a.click(); URL.revokeObjectURL(a.href);
            });
            $('closeCredentialsBtn').addEventListener('click', function () { location.reload(); });
        });
    </script>
@endsection
