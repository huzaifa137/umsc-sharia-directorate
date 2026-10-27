{{-- This partial renders the View/Edit modals + their JS exactly ONCE per page.
     It must be included AFTER the loop over applications, NOT inside it, or
     duplicate element IDs and duplicate event listeners break the buttons. --}}


<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- View modal Information --}}

<div class="modal fade" id="viewApplicationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">

            <!-- Header -->
            <div class="modal-header text-white"
                style="background: #00580f; border-radius: 18px 18px 0 0;">
                <div>
                    <h5 class="modal-title fw-bold mb-0"><i class="fas fa-file-contract me-2"></i>Divorce Application Details</h5>
                    <p class="small mb-0 opacity-75">Complete application information</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">

                <!-- Application Info Card -->
                <div class="info-card">
                    <h6 class="section-title mb-3">Application Information</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application ID</label>
                                <div class="value" id="divorceViewApplicationId"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application Date</label>
                                <div class="value" id="divorceViewDate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application Status</label>
                                <div class="value" id="divorceViewStatus"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="section-title mt-4">Couple Information</h6>
                <div class="row g-4">

                    <!-- Groom -->
                    <div class="col-md-6">
                        <div class="info-card person-card h-100">
                            <h6 class="section-title mb-0" style="border:none; padding:0;">Husband</h6>
                            <div class="mt-3">
                                <p><strong>Name:</strong> <span id="groomName"></span></p>
                                <p><strong>NIN:</strong> <span id="groomNin"></span></p>
                                <p><strong>Phone:</strong> <span id="groomPhone"></span></p>
                                <p><strong>Email:</strong> <span id="groomEmail"></span></p>
                                <img id="groomPhoto" class="img-fluid rounded mt-2 d-none" style="max-height:180px;">
                            </div>
                        </div>
                    </div>

                    <!-- Bride -->
                    <div class="col-md-6">
                        <div class="info-card person-card bride-card h-100">
                            <h6 class="section-title mb-0" style="border:none; padding:0;">Wife</h6>
                            <div class="mt-3">
                                <p><strong>Name:</strong> <span id="brideName"></span></p>
                                <p><strong>NIN:</strong> <span id="brideNin"></span></p>
                                <p><strong>Phone:</strong> <span id="bridePhone"></span></p>
                                <p><strong>Email:</strong> <span id="brideEmail"></span></p>
                                <img id="bridePhoto" class="img-fluid rounded mt-2 d-none" style="max-height:180px;">
                            </div>
                        </div>
                    </div>

                    <!-- Mosque / Imam -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Mosque & Imam Details</div>
                            <div class="card-body row">
                                <div class="col-md-4"><strong>Imam:</strong> <span id="imamName"></span></div>
                                <div class="col-md-4"><strong>Reg No:</strong> <span id="imamReg"></span></div>
                                <div class="col-md-4"><strong>Mosque:</strong> <span id="mosqueName"></span></div>
                                <div class="col-md-4 mt-2"><strong>Qadhi Area:</strong> <span id="qadhiArea"></span>
                                </div>
                                <div class="col-md-4 mt-2"><strong>Status:</strong>
                                    <span id="applicationStatus" class="badge bg-warning text-dark"></span>
                                </div>
                                <div class="col-md-4 mt-2"><strong>Submitted:</strong> <span id="createdAt"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

{{-- js for view application Information--}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.view-application').forEach(btn => {
            btn.addEventListener('click', function () {

                const id = this.dataset.id;

                fetch(`/divorce/${id}/details`)
                    .then(res => res.json())
                    .then(data => {

                        document.getElementById('divorceViewApplicationId').textContent = data.application_id;
                        document.getElementById('divorceViewStatus').innerHTML =
                            `<span class="status-badge status-${data.status}">${(data.status ?? '').charAt(0).toUpperCase() + (data.status ?? '').slice(1)}</span>`;
                        document.getElementById('divorceViewDate').textContent = data.created_at
                            ? new Date(data.created_at).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
                            : '-';

                        // Groom
                        document.getElementById('groomName').innerText =
                            `${data.groom_given_name} ${data.groom_surname}`;
                        document.getElementById('groomNin').innerText = data.groom_nin ?? '-';
                        document.getElementById('groomPhone').innerText = data.groom_phone ?? '-';
                        document.getElementById('groomEmail').innerText = data.groom_email ?? '-';

                        if (data.groom_photo_path) {
                            const img = document.getElementById('groomPhoto');
                            img.src = `/storage/${data.groom_photo_path}`;
                            img.classList.remove('d-none');
                        }

                        // Bride
                        document.getElementById('brideName').innerText =
                            `${data.bride_given_name} ${data.bride_surname}`;
                        document.getElementById('brideNin').innerText = data.bride_nin ?? '-';
                        document.getElementById('bridePhone').innerText = data.bride_phone ?? '-';
                        document.getElementById('brideEmail').innerText = data.bride_email ?? '-';

                        if (data.bride_photo_path) {
                            const img = document.getElementById('bridePhoto');
                            img.src = `/storage/${data.bride_photo_path}`;
                            img.classList.remove('d-none');
                        }

                        // Mosque / Imam
                        document.getElementById('imamName').innerText = data.imam_name ?? '-';
                        document.getElementById('imamReg').innerText = data.imam_reg ?? '-';
                        document.getElementById('mosqueName').innerText = data.mosque_name ?? '-';
                        document.getElementById('qadhiArea').innerText = data.qadhi_area ?? '-';
                        document.getElementById('applicationStatus').innerText = data.status;
                        document.getElementById('createdAt').innerText =
                            new Date(data.created_at).toLocaleDateString();

                        new bootstrap.Modal('#viewApplicationModal').show();
                    });

            });
        });

    });
</script>

{{-- edit modal Information --}}
{{-- ================= EDIT MODAL (ONLY ONCE) ================= --}}
<div class="modal fade" id="editApplicationModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content border-0 shadow-lg" style="border-radius:18px;">

            <form id="editApplicationForm">
                @csrf
                <input type="hidden" id="editApplicationId">

                <div class="modal-header text-white"
                    style="background: #00580f; border-radius: 18px 18px 0 0;">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Edit Divorce Application</h5>
                        <small id="editModalAppId" class="opacity-75"></small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Groom Information</div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">First Name</label>
                                            <input name="groom_given_name" class="form-control"
                                                placeholder="First Name">
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">Surname</label>
                                            <input name="groom_surname" class="form-control" placeholder="Surname">
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">NIN</label>
                                            <input name="groom_nin" class="form-control" placeholder="NIN">
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">Phone</label>
                                            <input name="groom_phone" class="form-control" placeholder="Phone">
                                        </div>
                                        <div class="col-12">
                                            <label class="small fw-bold mb-1">Email Address</label>
                                            <input name="groom_email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Bride Information</div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">First Name</label>
                                            <input name="bride_given_name" class="form-control"
                                                placeholder="First Name">
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">Surname</label>
                                            <input name="bride_surname" class="form-control" placeholder="Surname">
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">NIN</label>
                                            <input name="bride_nin" class="form-control" placeholder="NIN">
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold mb-1">Phone</label>
                                            <input name="bride_phone" class="form-control" placeholder="Phone">
                                        </div>
                                        <div class="col-12">
                                            <label class="small fw-bold mb-1">Email Address</label>
                                            <input name="bride_email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Mosque & Imam Details</div>
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="small fw-bold mb-1">Imam Name</label>
                                            <input name="imam_name" class="form-control" placeholder="Imam Name">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold mb-1">Imam Reg No.</label>
                                            <input name="imam_reg" class="form-control" placeholder="Imam Reg">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold mb-1">Mosque Name</label>
                                            <input name="mosque_name" class="form-control" placeholder="Mosque">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold mb-1">Qadhi Area</label>
                                            <input name="qadhi_area" class="form-control" placeholder="Qadhi Area">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- js for editting application Information--}}

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Open edit modal
        document.querySelectorAll('.edit-application').forEach(btn => {
            btn.addEventListener('click', function () {

                const id = this.dataset.id;

                fetch(`/divorce/${id}/edit-data`)
                    .then(res => res.json())
                    .then(data => {

                        document.getElementById('editApplicationId').value = data.id;
                        document.getElementById('editModalAppId').innerText = '#' + data.application_id;

                        Object.keys(data).forEach(key => {
                            const field = document.querySelector(`[name="${key}"]`);
                            if (field) field.value = data[key] ?? '';
                        });

                        new bootstrap.Modal('#editApplicationModal').show();
                    });
            });
        });

        // Submit update WITH SweetAlert confirmation
        const editForm = document.getElementById('editApplicationForm');
        if (editForm) {
            editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirm Update',
                text: 'Are you sure you want to save these changes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#6b7280'
            }).then((result) => {

                if (!result.isConfirmed) return;

                const id = document.getElementById('editApplicationId').value;
                const formData = new FormData(document.getElementById('editApplicationForm'));

                fetch(`/divorce/${id}/update`, {
                    method: 'POST',
                    body: formData
                })
                    .then(res => res.json())
                    .then(resp => {

                        if (resp.success) {

                            bootstrap.Modal.getInstance(
                                document.getElementById('editApplicationModal')
                            ).hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Updated',
                                text: 'Application updated successfully',
                                timer: 1500,
                                showConfirmButton: false
                            });

                            setTimeout(() => location.reload(), 1500);
                        }
                    });
            });
        }); // closes editForm.addEventListener
        } // end if(editForm)

    });
</script>

{{-- Js to delete --}}

<script>
    document.addEventListener('click', function (e) {

        const btn = e.target.closest('.delete-application');
        if (!btn) return;

        // STOP everything else
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        const id = btn.dataset.id;

        Swal.fire({
            title: 'Delete Application?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280'
        }).then((result) => {

            if (!result.isConfirmed) return;

            fetch(`/divorce/${id}/delete`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(resp => {

                    if (resp.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted Successfully',
                            text: 'The divorce application has been deleted.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#16a34a'
                        }).then(() => {
                            window.location.href = '/divorce-dashboard';
                        });
                    }
                });
        });

    });
</script>