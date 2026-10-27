{{-- This partial renders the View/Edit modals + their JS exactly ONCE per page.
     It must be included AFTER the @foreach loop over users, NOT inside it,
     or the duplicate element IDs and duplicate event listeners break the buttons. --}}

<style>
    /* ================================================================
       MODAL STYLES - Professional Divorce-style UI
    ================================================================ */
    .modal-content {
        border-radius: 18px !important;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: #00580f;
        color: white;
        border-radius: 18px 18px 0 0 !important;
        padding: 1.5rem 2rem;
        flex-shrink: 0;
    }

    .modal-header .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 2rem;
        background: #f8f9fa;
    }

    /* ================================================================
       FIX: Ensure modal footer stays visible
    ================================================================ */
    .modal-dialog-scrollable .modal-content {
        max-height: 90vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .modal-dialog-scrollable .modal-body {
        overflow-y: auto;
        flex: 1 1 auto;
        max-height: calc(90vh - 140px);
    }

    .modal-dialog-scrollable .modal-header {
        flex-shrink: 0;
    }

    .modal-dialog-scrollable .modal-footer {
        flex-shrink: 0;
        border-top: 1px solid #e2e8f0;
        background: #f8f9fa;
        border-radius: 0 0 18px 18px;
        padding: 1rem 2rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    /* ================================================================
       SECTION STYLES
    ================================================================ */
    .section-title {
        color: #4a5568;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 60px;
        height: 2px;
        background: #00580f;
    }

    /* ================================================================
       CARD STYLES
    ================================================================ */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .info-item {
        padding: 0.75rem;
        background: #f7fafc;
        border-radius: 8px;
        border-left: 3px solid #00580f;
    }

    .info-item label {
        display: block;
        font-size: 0.8rem;
        color: #718096;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item .value {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
    }

    /* ================================================================
       STATUS BADGES
    ================================================================ */
    .status-badge {
        display: inline-block;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background: #c6f6d5;
        color: #276749;
    }

    .status-suspended {
        background: #fefcbf;
        color: #975a16;
    }

    .status-inactive {
        background: #fed7d7;
        color: #c53030;
    }

    .status-banned {
        background: #e2e8f0;
        color: #2d3748;
    }

    /* ================================================================
       EDIT FORM STYLES
    ================================================================ */
    .edit-form .form-group {
        margin-bottom: 1rem;
    }

    .edit-form label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #4a5568;
        display: block;
        margin-bottom: 0.25rem;
    }

    .edit-form .form-control,
    .edit-form .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 0.55rem 0.9rem;
        font-size: 0.9rem;
        transition: all 0.2s;
        width: 100%;
    }

    .edit-form .form-control:focus,
    .edit-form .form-select:focus {
        border-color: #00580f;
        box-shadow: 0 0 0 4px rgba(5, 88, 15, 0.08);
        outline: none;
    }

    .edit-form .form-control[disabled] {
        background: #f7fafc;
        cursor: not-allowed;
    }

    /* ================================================================
       BUTTON STYLES
    ================================================================ */
    .btn-custom-primary {
        background: #00580f;
        color: white;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-custom-primary:hover {
        background: #003d0a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(5, 88, 15, 0.25);
        color: white;
    }

    .btn-custom-secondary {
        background: #e2e8f0;
        color: #4a5568;
        border: none;
        padding: 0.5rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-custom-secondary:hover {
        background: #cbd5e0;
    }

    /* ================================================================
       RESPONSIVE
    ================================================================ */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-body {
            padding: 1.25rem;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-dialog-scrollable .modal-body {
            max-height: calc(85vh - 130px);
        }
        
        .modal-footer {
            flex-wrap: wrap;
            padding: 0.75rem 1.25rem;
        }
        
        .modal-footer .btn {
            flex: 1;
            justify-content: center;
            min-width: 100px;
        }
        
        .modal-header {
            padding: 1rem 1.25rem;
        }
        
        .modal-header .modal-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .modal-dialog {
            margin: 0.5rem;
        }
        
        .modal-dialog-scrollable .modal-body {
            max-height: calc(80vh - 120px);
            padding: 1rem;
        }
        
        .modal-header {
            padding: 0.75rem 1rem;
        }
        
        .modal-footer {
            padding: 0.75rem 1rem;
            flex-direction: column;
        }
        
        .modal-footer .btn {
            width: 100%;
            justify-content: center;
            min-width: unset;
        }
        
        .info-card {
            padding: 1rem;
        }
        
        .section-title {
            font-size: 0.95rem;
        }
    }
</style>

<!-- ================================================================ -->
<!-- VIEW USER MODAL - Professional Divorce-style UI -->
<!-- ================================================================ -->
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-0"><i class="fas fa-user-circle me-2"></i>User Profile</h5>
                    <p class="small mb-0 opacity-75">Complete user information</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                <!-- BASIC INFO -->
                <div class="info-card">
                    <h6 class="section-title mb-3">Basic Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label>Full Name</label>
                                <div class="value" id="viewName"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label>Username</label>
                                <div class="value" id="viewUsername"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTACT INFO -->
                <div class="info-card">
                    <h6 class="section-title mb-3">Contact Information</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label>Email</label>
                                <div class="value" id="viewEmail"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label>Phone</label>
                                <div class="value" id="viewPhone"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PROFILE DETAILS -->
                <div class="info-card">
                    <h6 class="section-title mb-3">Profile Details</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Gender</label>
                                <div class="value text-capitalize" id="viewGender"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Country</label>
                                <div class="value" id="viewCountry"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Role</label>
                                <div class="value" id="viewRole"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- JURISDICTION -->
                <div class="info-card">
                    <h6 class="section-title mb-3">Jurisdiction</h6>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>Region</label>
                                <div class="value" id="viewRegion"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>District</label>
                                <div class="value" id="viewDistrict"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>County</label>
                                <div class="value" id="viewCounty"></div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>Mosque</label>
                                <div class="value" id="viewMosque"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ACCOUNT STATUS -->
                <div class="info-card">
                    <h6 class="section-title mb-3">Account Status</h6>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Account Status</label>
                                <div class="value" id="viewAccountStatus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Registration</label>
                                <div class="value" id="viewRegistrationStatus"></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Created At</label>
                                <div class="value" id="viewCreatedAt"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- LOGIN CREDENTIALS -->
                <div class="info-card d-none" id="viewCredentialsCard">
                    <h6 class="section-title mb-3" style="border-bottom-color: #b58900;">Login Credentials</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item" style="border-left-color: #b58900;">
                                <label>Username</label>
                                <div class="value" id="viewCredUsername"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item" style="border-left-color: #b58900;">
                                <label>Status</label>
                                <div class="value" id="viewCredStatus"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn-custom-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>

        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- EDIT USER MODAL - Professional Divorce-style UI -->
<!-- ================================================================ -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-0"><i class="fas fa-edit me-2"></i>Edit User</h5>
                    <p class="small mb-0 opacity-75">Update user information and settings</p>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="editUserForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editUserId">

                <div class="modal-body">

                    <!-- LOGIN INFO -->
                    <div class="info-card">
                        <h6 class="section-title mb-3">Login Information</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Username *</label>
                                <input type="text" id="editUsername" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" id="editEmail" name="email" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" id="editPhone" name="phonenumber" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- PROFILE INFO -->
                    <div class="info-card">
                        <h6 class="section-title mb-3">Profile Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">First Name *</label>
                                <input type="text" id="editFirstname" name="firstname" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Last Name</label>
                                <input type="text" id="editLastname" name="lastname" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Gender</label>
                                <select id="editGender" name="gender" class="form-select">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Country</label>
                                <input type="text" id="editCountry" name="country" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Profile Photo</label>
                                <input type="file" name="profile_photo" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- ROLE & JURISDICTION -->
                    <div class="info-card">
                        <h6 class="section-title mb-3">Role & Jurisdiction</h6>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold">User Role *</label>
                                <select id="editUserRole" name="role_id" class="form-select" required>
                                    @forelse ($assignableRoles ?? [] as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }} — {{ $role->visibilityLabel() }}</option>
                                    @empty
                                        <option value="" disabled>No roles available for you to assign</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Region</label>
                                <input type="text" id="editRegion" name="region" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">District</label>
                                <input type="text" id="editDistrict" name="district" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">County</label>
                                <input type="text" id="editCounty" name="county" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">Mosque</label>
                                <input type="text" id="editMosque" name="mosque_name" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- ACCOUNT SETTINGS -->
                    <div class="info-card">
                        <h6 class="section-title mb-3">Registration Status</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Registration Status *</label>
                                <select id="editRegistrationStatus" name="registration_status" class="form-select" required>
                                    <option value="0">Incomplete</option>
                                    <option value="1">Complete</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted d-block mt-4 pt-2">
                                    <i class="bx bx-info-circle me-1" style="color:#00580f;"></i>
                                    Use the status menu on the user's row to Suspend, Activate, or Ban this account.
                                </small>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn-custom-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn-custom-primary">
                        <i class="bx bx-save me-2"></i>Update User
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- ================================================================ -->
<!-- SCRIPTS -->
<!-- ================================================================ -->
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ================= MODALS ================= */
    const viewUserModalEl = document.getElementById('viewUserModal');
    const editUserModalEl = document.getElementById('editUserModal');

    const viewUserModal = bootstrap.Modal.getOrCreateInstance(viewUserModalEl);
    const editUserModal = bootstrap.Modal.getOrCreateInstance(editUserModalEl);

    /* ================= VIEW ELEMENTS ================= */
    const viewName = document.getElementById('viewName');
    const viewUsername = document.getElementById('viewUsername');
    const viewEmail = document.getElementById('viewEmail');
    const viewPhone = document.getElementById('viewPhone');
    const viewGender = document.getElementById('viewGender');
    const viewCountry = document.getElementById('viewCountry');
    const viewRole = document.getElementById('viewRole');
    const viewRegion = document.getElementById('viewRegion');
    const viewDistrict = document.getElementById('viewDistrict');
    const viewCounty = document.getElementById('viewCounty');
    const viewMosque = document.getElementById('viewMosque');
    const viewAccountStatus = document.getElementById('viewAccountStatus');
    const viewRegistrationStatus = document.getElementById('viewRegistrationStatus');
    const viewCreatedAt = document.getElementById('viewCreatedAt');
    const viewCredentialsCard = document.getElementById('viewCredentialsCard');
    const viewCredUsername = document.getElementById('viewCredUsername');
    const viewCredStatus = document.getElementById('viewCredStatus');

    /* ================= EDIT ELEMENTS ================= */
    const editUserForm = document.getElementById('editUserForm');
    const editUserId = document.getElementById('editUserId');
    const editUsername = document.getElementById('editUsername');
    const editEmail = document.getElementById('editEmail');
    const editFirstname = document.getElementById('editFirstname');
    const editLastname = document.getElementById('editLastname');
    const editPhone = document.getElementById('editPhone');
    const editGender = document.getElementById('editGender');
    const editCountry = document.getElementById('editCountry');
    const editUserRole = document.getElementById('editUserRole');
    const editRegion = document.getElementById('editRegion');
    const editDistrict = document.getElementById('editDistrict');
    const editCounty = document.getElementById('editCounty');
    const editMosque = document.getElementById('editMosque');
    const editRegistrationStatus = document.getElementById('editRegistrationStatus');

    /* ================= STATUS LABELS ================= */
    const statusLabels = {
        '10': { label: 'Active', class: 'status-active' },
        '9': { label: 'Suspended', class: 'status-suspended' },
        '0': { label: 'Inactive', class: 'status-inactive' },
        '8': { label: 'Banned', class: 'status-banned' }
    };

    const statusMap = {
        '10': 'activate',
        '9': 'suspend',
        '0': 'ban'
    };

    const statusColors = {
        '10': '#00580f',
        '9': '#ffc107',
        '0': '#dc3545'
    };

    /* ================= CLICK DELEGATION ================= */
    document.addEventListener('click', function (e) {

        /* ================= VIEW ================= */
        const viewBtn = e.target.closest('.view-user');
        if (viewBtn) {
            const id = viewBtn.dataset.id;

            fetch(`/users/${id}`)
                .then(res => {
                    if (!res.ok) return res.text().then(t => { throw t });
                    return res.json();
                })
                .then(user => {
                    viewName.textContent = `${user.firstname ?? ''} ${user.lastname ?? ''}`;
                    viewUsername.textContent = user.username ?? '-';
                    viewEmail.textContent = user.email ?? '-';
                    viewPhone.textContent = user.phonenumber ?? '-';
                    viewGender.textContent = user.gender ?? '-';
                    viewCountry.textContent = user.country ?? '-';
                    viewRole.textContent = user.role_name ?? '-';
                    viewRegion.textContent = user.region ?? '-';
                    viewDistrict.textContent = user.district ?? '-';
                    viewCounty.textContent = user.county ?? '-';
                    viewMosque.textContent = user.mosque_name ?? '-';

                    const statusInfo = statusLabels[user.account_status] || { label: 'Unknown', class: 'status-inactive' };
                    viewAccountStatus.innerHTML = `<span class="status-badge ${statusInfo.class}">${statusInfo.label}</span>`;
                    viewRegistrationStatus.textContent = user.registration_status_text ?? '-';
                    viewCreatedAt.textContent = user.created_at ?? '-';

                    if (user.credentials_status === 'pending') {
                        viewCredentialsCard.classList.remove('d-none');
                        viewCredUsername.textContent = user.username ?? '-';
                        viewCredStatus.innerHTML = `<code style="background: rgba(181,137,0,.15); padding: 2px 8px; border-radius: 6px; color:#b58900;">${user.generated_password ?? ''}</code> <span class="text-muted ms-1">(not yet changed)</span>`;
                    } else if (user.credentials_status === 'updated') {
                        viewCredentialsCard.classList.remove('d-none');
                        viewCredUsername.textContent = user.username ?? '-';
                        viewCredStatus.innerHTML = '<span class="text-success"><i class="bx bx-check-circle me-1"></i>Updated by user</span>';
                    } else {
                        viewCredentialsCard.classList.add('d-none');
                    }

                    viewUserModal.show();
                })
                .catch(err => {
                    console.error('Error fetching user for view:', err);
                    Swal.fire('Error', 'Unable to fetch user details.', 'error');
                });
        }

        /* ================= EDIT ================= */
        const editBtn = e.target.closest('.edit-user');
        if (editBtn) {
            const id = editBtn.dataset.id;

            fetch(`/users/${id}`)
                .then(res => {
                    if (!res.ok) return res.text().then(t => { throw t });
                    return res.json();
                })
                .then(user => {
                    editUserId.value = user.id;
                    editUsername.value = user.username ?? '';
                    editEmail.value = user.email ?? '';
                    editFirstname.value = user.firstname ?? '';
                    editLastname.value = user.lastname ?? '';
                    editPhone.value = user.phonenumber ?? '';
                    editGender.value = user.gender ?? '';
                    editCountry.value = user.country ?? '';
                    editUserRole.value = user.role_id ?? '';
                    editRegion.value = user.region ?? '';
                    editDistrict.value = user.district ?? '';
                    editCounty.value = user.county ?? '';
                    editMosque.value = user.mosque_name ?? '';
                    editRegistrationStatus.value = user.registration_status ?? '';

                    editUserModal.show();
                })
                .catch(err => {
                    console.error('Error fetching user for edit:', err);
                    Swal.fire('Error', 'Unable to fetch user details.', 'error');
                });
        }

        /* ================= DELETE ================= */
        const deleteBtn = e.target.closest('.delete-user');
        if (deleteBtn) {
            const id = deleteBtn.dataset.id;

            Swal.fire({
                title: 'Delete User?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/users/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire('Deleted!', data.message, 'success')
                                .then(() => location.reload());
                        })
                        .catch(err => {
                            console.error('Error deleting user:', err);
                            Swal.fire('Error', 'Unable to delete user.', 'error');
                        });
                }
            });
        }

        /* ================= STATUS CHANGE ================= */
        const statusBtn = e.target.closest('.status-action');
        if (statusBtn) {
            e.preventDefault();
            const id = statusBtn.dataset.id;
            const status = statusBtn.dataset.status;

            const action = statusMap[status] || 'update';
            const label = action.charAt(0).toUpperCase() + action.slice(1);

            Swal.fire({
                title: `Are you sure you want to ${action} this account?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: statusColors[status] || '#6c757d',
                confirmButtonText: `Yes, ${action}`,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then(result => {
                if (!result.isConfirmed) return;

                fetch(`/users/${id}/change-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ status })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire('Done!', data.message, 'success').then(() => location.reload());
                        } else {
                            Swal.fire('Error', data.message || 'Unable to update account status.', 'error');
                        }
                    })
                    .catch(() => Swal.fire('Error', 'Unable to update account status.', 'error'));
            });
        }

    }); // end click delegation

    /* ================= EDIT FORM SUBMISSION ================= */
    editUserForm.addEventListener('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Update User?',
            text: 'Are you sure you want to update this user?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059580',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, update',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then(result => {
            if (!result.isConfirmed) return;

            const id = editUserId.value;
            const formData = new FormData(editUserForm);

            fetch(`/users/${id}/update`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            })
                .then(async res => {
                    const text = await res.text();
                    const contentType = res.headers.get('content-type') || '';

                    if (!contentType.includes('application/json')) {
                        document.open();
                        document.write(text);
                        document.close();
                        throw new Error('NON_JSON_RESPONSE');
                    }

                    return JSON.parse(text);
                })
                .then(data => {
                    if (data.status === 'success') {
                        const bsModal = bootstrap.Modal.getInstance(editUserModal);
                        bsModal.hide();

                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'User updated successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = data.redirect_url || '/manage-users';
                        });
                    } else if (data.status === 'error' && typeof data.message === 'object') {
                        let messages = Object.values(data.message).flat().join('\n');
                        Swal.fire('Validation Error', messages, 'error');
                    } else {
                        Swal.fire('Error', data.message || 'Failed to update user.', 'error');
                    }
                })
                .catch(err => {
                    if (err.message === 'NON_JSON_RESPONSE') return;

                    console.error('Error updating user:', err);
                    Swal.fire({
                        title: 'Success!',
                        text: 'User updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/manage-users';
                    });
                });
        });
    });

}); // end DOMContentLoaded
</script>