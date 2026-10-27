{{-- This partial renders the View/Edit modals + their JS exactly ONCE per page.
     It must be included AFTER the loop over applications, NOT inside it, or
     duplicate element IDs and duplicate event listeners break the buttons. --}}


{{-- modal code to view inheritance application --}}

{{-- View Inheritance Application Modal --}}
<div class="modal fade" id="viewInheritanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">

            <!-- Header -->
            <div class="modal-header text-white"
                style="background: #00580f; border-radius: 18px 18px 0 0;">
                <div>
                    <h5 class="modal-title fw-bold mb-0"><i class="fas fa-file-contract me-2"></i>Inheritance Application Details</h5>
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
                                <div class="value" id="inheritanceViewApplicationId"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application Date</label>
                                <div class="value" id="inheritanceViewDate"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application Status</label>
                                <div class="value" id="inheritanceViewStatus"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h6 class="section-title mt-4">Case Information</h6>
                <div class="row g-4">

                    <!-- Deceased Info -->
                    <div class="col-md-6">
                        <div class="info-card person-card h-100">
                            <h6 class="section-title mb-0" style="border:none; padding:0;">Deceased</h6>
                            <div class="mt-3">
                                <p><strong>Name:</strong> <span id="viewDeceasedName"></span></p>
                                <p><strong>NIN:</strong> <span id="viewDeceasedNIN"></span></p>
                                <p><strong>Gender:</strong> <span id="viewDeceasedGender"></span></p>
                                <p><strong>Date of Death:</strong> <span id="viewDateOfDeath"></span></p>
                                <p><strong>Place of Death:</strong> <span id="viewPlaceOfDeath"></span></p>
                                <p><strong>Cause of Death:</strong> <span id="viewCauseOfDeath"></span></p>
                                <p><strong>Marital Status:</strong> <span id="viewMaritalStatus"></span></p>
                                <p><strong>Occupation:</strong> <span id="viewOccupation"></span></p>
                                <p><strong>Last Residence:</strong> <span id="viewLastResidence"></span></p>

                                <p><strong>Death Certificate:</strong></p>
                                <a id="viewDeathCertificate" href="#" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-download me-1"></i> View / Download
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Applicant Info -->
                    <div class="col-md-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Applicant Information</div>
                            <div class="card-body">
                                <p><strong>Name:</strong> <span id="viewApplicantName"></span></p>
                                <p><strong>Relationship:</strong> <span id="viewRelationship"></span></p>
                                <p><strong>NIN:</strong> <span id="viewApplicantNIN"></span></p>
                                <p><strong>Phone:</strong> <span id="viewApplicantPhone"></span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Properties -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Properties</div>
                            <div class="card-body" id="viewPropertiesContainer">
                                <!-- Dynamically filled -->
                            </div>
                        </div>
                    </div>

                    <!-- Heirs -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Heirs</div>
                            <div class="card-body">
                                <div id="viewHeirsContainer"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Verification -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Verification</div>
                            <div class="card-body">
                                <p><strong>Imam:</strong> <span id="viewImamName"></span></p>
                                <p><strong>Reg No:</strong> <span id="viewImamReg"></span></p>
                                <p><strong>Mosque:</strong> <span id="viewMosqueName"></span></p>
                                <p><strong>Date Verified:</strong> <span id="viewVerificationDate"></span></p>
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

{{-- js to load view application information --}}

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Select all view buttons
        document.querySelectorAll('.view-application').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;

                // Fetch inheritance application details
                fetch(`/inheritance/${id}/details`)
                    .then(res => res.json())
                    .then(data => {
                        // === Header ===
                        document.getElementById('inheritanceViewApplicationId').textContent = data.application_id;
                        document.getElementById('inheritanceViewStatus').innerHTML =
                            `<span class="status-badge status-${data.status}">${(data.status ?? '').charAt(0).toUpperCase() + (data.status ?? '').slice(1)}</span>`;
                        document.getElementById('inheritanceViewDate').textContent = data.created_at
                            ? new Date(data.created_at).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
                            : '-';

                        // === Deceased ===
                        document.getElementById('viewDeceasedName').innerText = data.deceased_name;
                        document.getElementById('viewDeceasedNIN').innerText = data.deceased_nin;
                        document.getElementById('viewDeceasedGender').innerText = data.gender;
                        document.getElementById('viewDateOfDeath').innerText = new Date(data.date_of_death).toLocaleDateString();
                        document.getElementById('viewPlaceOfDeath').innerText = data.place_of_death;
                        document.getElementById('viewCauseOfDeath').innerText = data.cause_of_death ?? '-';
                        document.getElementById('viewMaritalStatus').innerText = data.marital_status;
                        document.getElementById('viewOccupation').innerText = data.occupation ?? '-';
                        document.getElementById('viewLastResidence').innerText = data.last_residence;

                        const certLink = document.getElementById('viewDeathCertificate');
                        certLink.href = `/storage/${data.death_certificate_path}`;

                        // === Applicant ===
                        document.getElementById('viewApplicantName').innerText = data.applicant_name;
                        document.getElementById('viewRelationship').innerText = data.relationship;
                        document.getElementById('viewApplicantNIN').innerText = data.applicant_nin;
                        document.getElementById('viewApplicantPhone').innerText = data.applicant_phone;

                        // === Properties ===
                        const propContainer = document.getElementById('viewPropertiesContainer');
                        propContainer.innerHTML = '';
                        data.properties.forEach((p, i) => {
                            propContainer.innerHTML += `
                            <div class="mb-2 p-2 border rounded bg-light">
                                <strong>${i + 1}. ${p.type}</strong><br>
                                <small>${p.description}</small><br>
                                <span>Value: ${p.value}</span><br>
                                <span>Location: ${p.location ?? '-'}</span>
                            </div>
                        `;
                        });

                        // === Heirs ===
                        const heirsContainer = document.getElementById('viewHeirsContainer');
                        heirsContainer.innerHTML = `
                        <p><strong>Sons:</strong> ${data.sons_count}</p>
                        <p><strong>Daughters:</strong> ${data.daughters_count}</p>
                        <p><strong>Father Alive:</strong> ${data.father_alive ? 'Yes' : 'No'} ${data.father_name ?? ''}</p>
                        <p><strong>Mother Alive:</strong> ${data.mother_alive ? 'Yes' : 'No'} ${data.mother_name ?? ''}</p>
                        <p><strong>Full Brothers:</strong> ${data.full_brothers}</p>
                        <p><strong>Full Sisters:</strong> ${data.full_sisters}</p>
                        <p><strong>Uterine Brothers:</strong> ${data.uterine_brothers}</p>
                        <p><strong>Uterine Sisters:</strong> ${data.uterine_sisters}</p>
                        <p><strong>Pregnant Heir:</strong> ${data.pregnant_heir}</p>
                        <p><strong>Minor Heirs:</strong> ${data.minor_heirs}</p>
                    `;

                        // === Verification ===
                        document.getElementById('viewImamName').innerText = data.imam_name;
                        document.getElementById('viewImamReg').innerText = data.imam_reg_number ?? '-';
                        document.getElementById('viewMosqueName').innerText = data.mosque_name;
                        document.getElementById('viewVerificationDate').innerText = new Date(data.verification_date).toLocaleDateString();

                        // === Show modal safely ===
                        const modalEl = document.getElementById('viewInheritanceModal');
                        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();

                        // Optional: Reset modal content on close to avoid stale data
                        modalEl.addEventListener('hidden.bs.modal', () => {
                            propContainer.innerHTML = '';
                            heirsContainer.innerHTML = '';
                        }, { once: true });
                    })
                    .catch(err => {
                        console.error('Failed to load inheritance application:', err);
                        alert('Unable to load application details. Please try again.');
                    });
            });
        });

    });
</script>

{{-- modal code to view edit application --}}

{{-- Edit Inheritance Application Modal --}}
<div class="modal fade" id="editInheritanceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">

            <!-- Header -->
            <div class="modal-header text-white"
                style="background: #00580f; border-radius: 18px 18px 0 0;">
                <h5 class="modal-title fw-bold mb-2">Edit Inheritance Application</h5>
                <button type="button" class="btn-close btn-close-white mb-2" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <form id="editInheritanceForm">
                    <input type="hidden" name="application_id" id="editApplicationId">

                    <!-- Deceased Info -->
                    <h6 class="fw-bold">Deceased Information</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" name="deceased_name" id="editDeceasedName" required>
                        </div>
                        <div class="col-md-6">
                            <label>NIN</label>
                            <input type="text" class="form-control" name="deceased_nin" id="editDeceasedNIN" required>
                        </div>
                        <div class="col-md-4">
                            <label>Gender</label>
                            <select class="form-select" name="gender" id="editDeceasedGender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Date of Death</label>
                            <input type="date" class="form-control" name="date_of_death" id="editDateOfDeath" required>
                        </div>
                        <div class="col-md-4">
                            <label>Place of Death</label>
                            <input type="text" class="form-control" name="place_of_death" id="editPlaceOfDeath"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label>Cause of Death</label>
                            <input type="text" class="form-control" name="cause_of_death" id="editCauseOfDeath">
                        </div>
                        <div class="col-md-6">
                            <label>Marital Status</label>
                            <input type="text" class="form-control" name="marital_status" id="editMaritalStatus"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label>Occupation</label>
                            <input type="text" class="form-control" name="occupation" id="editOccupation">
                        </div>
                        <div class="col-md-6">
                            <label>Last Residence</label>
                            <input type="text" class="form-control" name="last_residence" id="editLastResidence"
                                required>
                        </div>

                        <div class="col-12">
                            <label>Death Certificate</label>
                            <input type="file" class="form-control" name="death_certificate" id="editDeathCertificate"
                                accept="image/*,application/pdf">
                            <small class="text-muted">Upload only if you want to replace the existing
                                certificate</small>
                        </div>
                    </div>

                    <!-- Applicant Info -->
                    <h6 class="fw-bold mt-3">Applicant Information</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" name="applicant_name" id="editApplicantName"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label>Relationship</label>
                            <input type="text" class="form-control" name="relationship" id="editRelationship" required>
                        </div>
                        <div class="col-md-6">
                            <label>NIN</label>
                            <input type="text" class="form-control" name="applicant_nin" id="editApplicantNIN" required>
                        </div>
                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="applicant_phone" id="editApplicantPhone"
                                required>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4">Update Application</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{{-- js to view edit form --}}

<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Populate modal on Edit button click
        document.querySelectorAll('.edit-application').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.dataset.id;

                fetch(`/inheritance/${id}/information`)
                    .then(res => res.json())
                    .then(data => {
                        // Fill fields
                        document.getElementById('editApplicationId').value = data.id;
                        document.getElementById('editDeceasedName').value = data.deceased_name;
                        document.getElementById('editDeceasedNIN').value = data.deceased_nin;
                        document.getElementById('editDeceasedGender').value = data.gender;
                        document.getElementById('editDateOfDeath').value = data.date_of_death;
                        document.getElementById('editPlaceOfDeath').value = data.place_of_death;
                        document.getElementById('editCauseOfDeath').value = data.cause_of_death ?? '';
                        document.getElementById('editMaritalStatus').value = data.marital_status;
                        document.getElementById('editOccupation').value = data.occupation ?? '';
                        document.getElementById('editLastResidence').value = data.last_residence;

                        document.getElementById('editApplicantName').value = data.applicant_name;
                        document.getElementById('editRelationship').value = data.relationship;
                        document.getElementById('editApplicantNIN').value = data.applicant_nin;
                        document.getElementById('editApplicantPhone').value = data.applicant_phone;

                        // Show modal
                        const modalEl = document.getElementById('editInheritanceModal');
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    });
            });
        });

        // Handle form submission
        const editForm = document.getElementById('editInheritanceForm');
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this inheritance application?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, update it!'
            }).then((result) => {
                if (!result.isConfirmed) return;

                const formData = new FormData(editForm);
                const appId = formData.get('application_id');

                fetch(`/inheritance/${appId}/update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    body: formData
                })
                    .then(async (res) => {

                        // 🚨 EXACT jQuery error.responseText behavior
                        if (!res.ok) {
                            const html = await res.text();
                            document.open();
                            document.write(html);
                            document.close();
                            return; // STOP everything
                        }

                        // ✅ Only parse JSON if request succeeded
                        const contentType = res.headers.get('content-type') || '';
                        if (!contentType.includes('application/json')) {
                            const html = await res.text();
                            document.open();
                            document.write(html);
                            document.close();
                            return;
                        }

                        return res.json();
                    })
                    .then((data) => {
                        if (!data) return;

                        if (data.success) {
                            Swal.fire({
                                title: 'Updated!',
                                text: 'Inheritance application updated successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = '/inheritance-dashboard';
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                data.message || 'Failed to update.',
                                'error'
                            );
                        }
                    })
                    .catch((err) => {
                        console.error(err);
                    });
            });
        });

    });
</script>

{{-- js delete application --}}

<script>
    document.addEventListener('DOMContentLoaded', () => {

        document.querySelectorAll('.delete-application').forEach(btn => {
            btn.addEventListener('click', function () {

                const id = this.dataset.id;

                Swal.fire({
                    title: 'Delete Application?',
                    text: 'This action cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {

                    if (!result.isConfirmed) return;

                    fetch(`/inheritance/${id}/delete`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                        .then(async (res) => {

                            // 🔥 EXACT jQuery error.responseText behavior
                            if (!res.ok) {
                                const html = await res.text();
                                document.open();
                                document.write(html);
                                document.close();
                                return;
                            }

                            const contentType = res.headers.get('content-type') || '';
                            if (!contentType.includes('application/json')) {
                                const html = await res.text();
                                document.open();
                                document.write(html);
                                document.close();
                                return;
                            }

                            return res.json();
                        })
                        .then(data => {
                            if (!data) return;

                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: 'Inheritance application deleted successfully.',
                                    confirmButtonColor: '#16a34a',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '/inheritance-dashboard';
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    data.message || 'Failed to delete application.',
                                    'error'
                                );
                            }
                        })
                        .catch(err => {
                            console.error(err);
                        });
                });
            });
        });

    });
</script>