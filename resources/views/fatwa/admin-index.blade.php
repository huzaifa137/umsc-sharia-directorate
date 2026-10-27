@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <h2 class="mb-0 fw-bold">FATWA MANAGEMENT</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#fatwaModal" id="openCreateModalBtn">
            <i class="bx bx-plus me-1"></i> New Fatwa
        </button>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th class="pe-4 text-end" style="width:170px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fatwas as $fatwa)
                        <tr data-id="{{ $fatwa->id }}">
                            <td class="ps-4">
                                <div class="fw-bold">{{ $fatwa->title }}</div>
                                <small class="text-muted">{{ \Illuminate\Support\Str::limit($fatwa->question, 70) }}</small>
                            </td>
                            <td>{{ $fatwa->category ?: '—' }}</td>
                            <td>
                                <span class="badge rounded-pill status-badge"
                                    style="background: {{ $fatwa->status === 'published' ? '#05956815' : '#FFF7E6' }}; color: {{ $fatwa->status === 'published' ? '#059568' : '#FF9F43' }};">
                                    {{ ucfirst($fatwa->status) }}
                                </span>
                            </td>
                            <td>{{ optional($fatwa->published_at)->format('d M Y') ?: '—' }}</td>
                            <td class="pe-4 text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('fatwa.public.show', $fatwa->slug) }}" target="_blank"
                                       class="btn btn-outline-primary" title="Preview">
                                        <i class="bx bx-show-alt"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-secondary toggle-status-btn"
                                            title="{{ $fatwa->status === 'published' ? 'Unpublish' : 'Publish' }}">
                                        <i class="bx bx-revision"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-success edit-fatwa-btn" title="Edit">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger delete-fatwa-btn" title="Delete">
                                        <i class="bx bx-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bx bx-book-open fs-1 mb-2"></i>
                                <p class="mb-0">No fatwas yet — click "New Fatwa" to publish the first one.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Create / Edit Modal --}}
<div class="modal fade" id="fatwaModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background:#00580f;">
                <h5 class="modal-title text-white" id="fatwaModalTitle">New Fatwa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="fatwaForm">
                @csrf
                <input type="hidden" id="fatwa_id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="f_title" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Category</label>
                            <input type="text" class="form-control" name="category" id="f_category" placeholder="e.g. Worship, Marriage">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Icon</label>
                            <div class="d-flex align-items-center gap-2">
                                <span id="f_icon_preview" class="d-inline-flex align-items-center justify-content-center flex-shrink-0"
                                      style="width:38px; height:38px; border-radius:50%; background:#f0fdf7; color:#059568; font-size:1.2rem;">
                                    <i class="bx bx-book-open"></i>
                                </span>
                                <select class="form-select" name="icon" id="f_icon">
                                    <option value="bx-book-open">Book (general ruling)</option>
                                    <option value="bx-moon">Moon (fasting / Ramadan)</option>
                                    <option value="bx-sun">Sun (prayer times)</option>
                                    <option value="bx-heart">Heart (marriage / Nikah)</option>
                                    <option value="bx-group">People (divorce / family)</option>
                                    <option value="bx-child">Child (guardianship / children)</option>
                                    <option value="bx-briefcase">Briefcase (business / trade)</option>
                                    <option value="bx-money">Money (inheritance / zakat)</option>
                                    <option value="bx-restaurant">Food (halal / dietary)</option>
                                    <option value="bx-water">Water (purification / wudu)</option>
                                    <option value="bx-calendar-check">Calendar (dates / occasions)</option>
                                    <option value="bx-shield-quarter">Shield (rights / protection)</option>
                                    <option value="bx-star">Star (worship / virtue)</option>
                                    <option value="bx-gift">Gift (charity)</option>
                                    <option value="bx-comment-detail">Speech bubble (etiquette / speech)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Accent Color</label>
                            <input type="color" class="form-control form-control-color w-100" name="color" id="f_color" value="#059568">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" id="f_status">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">The Question (matter being asked about)</label>
                            <textarea class="form-control" name="question" id="f_question" rows="2" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">The Ruling</label>
                            <textarea class="form-control" name="ruling" id="f_ruling" rows="6" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Qur'an Reference</label>
                            <textarea class="form-control" name="quran_reference" id="f_quran" rows="3" placeholder="e.g. Surah Al-Baqarah 2:183 — ..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Hadith Reference</label>
                            <textarea class="form-control" name="hadith_reference" id="f_hadith" rows="3" placeholder="e.g. Sahih Bukhari 1:1 — ..."></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">YouTube Link (optional)</label>
                            <input type="url" class="form-control" name="youtube_url" id="f_youtube" placeholder="https://www.youtube.com/watch?v=...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4">Save Fatwa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('#fatwaForm input[name="_token"]')?.value;

    const modalEl = document.getElementById('fatwaModal');
    const modal = new bootstrap.Modal(modalEl);
    const form = document.getElementById('fatwaForm');

    // Same fix as the Nikah edit modal: force the body's max-height/overflow
    // inline via JS, since inline styles win over any stylesheet rule
    // regardless of selector specificity — this is what actually keeps the
    // header and footer visible instead of the whole modal overflowing.
    modalEl.addEventListener('show.bs.modal', function () {
        const modalBody = this.querySelector('.modal-body');
        if (modalBody) {
            modalBody.style.maxHeight = '60vh';
            modalBody.style.overflowY = 'auto';
        }
    });

    const routes = {
        store: "{{ route('fatwa.admin.store') }}",
        editBase: "{{ url('fatwa-admin') }}", // /{id}/edit, /{id}, /{id}/toggle-status
    };

    function updateIconPreview() {
        const iconClass = document.getElementById('f_icon').value || 'bx-book-open';
        document.getElementById('f_icon_preview').innerHTML = `<i class="bx ${iconClass}"></i>`;
    }
    document.getElementById('f_icon').addEventListener('change', updateIconPreview);

    function resetForm() {
        form.reset();
        document.getElementById('fatwa_id').value = '';
        document.getElementById('f_color').value = '#059568';
        document.getElementById('f_icon').value = 'bx-book-open';
        document.getElementById('fatwaModalTitle').textContent = 'New Fatwa';
        updateIconPreview();
    }

    document.getElementById('openCreateModalBtn').addEventListener('click', resetForm);

    // --- Edit ---
    document.querySelectorAll('.edit-fatwa-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.closest('tr').dataset.id;

            fetch(`${routes.editBase}/${id}/edit`)
                .then(r => r.json())
                .then(res => {
                    if (!res.status) return;
                    const d = res.data;
                    document.getElementById('fatwa_id').value = d.id;
                    document.getElementById('f_title').value = d.title || '';
                    document.getElementById('f_category').value = d.category || '';
                    document.getElementById('f_icon').value = d.icon || 'bx-book-open';
                    updateIconPreview();
                    document.getElementById('f_color').value = d.color || '#059568';
                    document.getElementById('f_status').value = d.status || 'draft';
                    document.getElementById('f_question').value = d.question || '';
                    document.getElementById('f_ruling').value = d.ruling || '';
                    document.getElementById('f_quran').value = d.quran_reference || '';
                    document.getElementById('f_hadith').value = d.hadith_reference || '';
                    document.getElementById('f_youtube').value = d.youtube_url || '';
                    document.getElementById('fatwaModalTitle').textContent = 'Edit Fatwa';
                    modal.show();
                });
        });
    });

    // --- Create / Update ---
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const id = document.getElementById('fatwa_id').value;
        const isEdit = !!id;
        const url = isEdit ? `${routes.editBase}/${id}` : routes.store;

        const payload = {
            title: document.getElementById('f_title').value,
            category: document.getElementById('f_category').value,
            icon: document.getElementById('f_icon').value,
            color: document.getElementById('f_color').value,
            status: document.getElementById('f_status').value,
            question: document.getElementById('f_question').value,
            ruling: document.getElementById('f_ruling').value,
            quran_reference: document.getElementById('f_quran').value,
            hadith_reference: document.getElementById('f_hadith').value,
            youtube_url: document.getElementById('f_youtube').value,
        };

        if (isEdit) payload._method = 'PUT';

        fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            body: JSON.stringify(payload),
        })
            .then(r => r.json())
            .then(res => {
                if (!res.status) {
                    Swal.fire('Error', res.message || 'Could not save this fatwa.', 'error');
                    return;
                }
                Swal.fire({ title: 'Saved!', text: res.message, icon: 'success', timer: 1800, showConfirmButton: false })
                    .then(() => location.reload());
            })
            .catch(() => Swal.fire('Error', 'Something went wrong. Please try again.', 'error'));
    });

    // --- Delete ---
    document.querySelectorAll('.delete-fatwa-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const row = this.closest('tr');
            const id = row.dataset.id;

            Swal.fire({
                title: 'Delete this fatwa?',
                text: 'This cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                confirmButtonText: 'Yes, delete',
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch(`${routes.editBase}/${id}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ _method: 'DELETE' }),
                })
                    .then(r => r.json())
                    .then(res => {
                        if (!res.status) { Swal.fire('Error', res.message || 'Could not delete.', 'error'); return; }
                        row.remove();
                        Swal.fire({ title: 'Deleted', icon: 'success', timer: 1500, showConfirmButton: false });
                    });
            });
        });
    });

    // --- Toggle publish/unpublish ---
    document.querySelectorAll('.toggle-status-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.closest('tr').dataset.id;

            fetch(`${routes.editBase}/${id}/toggle-status`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
            })
                .then(r => r.json())
                .then(res => {
                    if (!res.status) return;
                    location.reload();
                });
        });
    });
});
</script>
@endsection