<!-- Actions -->
<div class="col-md-2">
    <div class="d-flex justify-content-center gap-2">
        <button class="btn btn-sm px-3 edit-user" data-id="{{ $user->id }}"
            style="background: rgba(5, 88, 15, 0.1); color: #00580f;">
            <i class="bx bx-edit"></i>
        </button>
        <button class="btn btn-sm px-3 delete-user" data-id="{{ $user->id }}"
            style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
            <i class="bx bx-trash"></i>
        </button>
        <button class="btn btn-sm px-3 view-user" data-id="{{ $user->id }}"
            style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
            <i class="bx bx-show"></i>
        </button>
    </div>
</div>

<style>
    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
</style>

<div class="modal fade" id="viewUserModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color:#00580f;">
                    <i class="bx bx-show me-2"></i>User Profile
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- BASIC INFO -->
                <div class="mb-4 p-4 rounded-4"
                    style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                    <h6 class="fw-bold mb-3" style="color:#00580f;">Basic Information</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Full Name</small>
                            <div class="fw-bold" id="viewName"></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Username</small>
                            <div class="fw-bold" id="viewUsername"></div>
                        </div>
                    </div>
                </div>

                <!-- CONTACT INFO -->
                <div class="mb-4 p-4 rounded-4"
                    style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                    <h6 class="fw-bold mb-3" style="color:#00580f;">Contact Information</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Email</small>
                            <div class="fw-bold" id="viewEmail"></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Phone</small>
                            <div class="fw-bold" id="viewPhone"></div>
                        </div>
                    </div>
                </div>

                <!-- PROFILE DETAILS -->
                <div class="mb-4 p-4 rounded-4"
                    style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                    <h6 class="fw-bold mb-3" style="color:#00580f;">Profile Details</h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-muted">Gender</small>
                            <div class="fw-bold text-capitalize" id="viewGender"></div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Country</small>
                            <div class="fw-bold" id="viewCountry"></div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Role</small>
                            <div class="fw-bold" id="viewRole"></div>
                        </div>
                    </div>
                </div>

                <!-- ACCOUNT STATUS -->
                <div class="p-4 rounded-4" style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                    <h6 class="fw-bold mb-3" style="color:#00580f;">Account Status</h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <small class="text-muted">Account Status</small>
                            <div class="fw-bold" id="viewAccountStatus"></div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Registration</small>
                            <div class="fw-bold" id="viewRegistrationStatus"></div>
                        </div>

                        <div class="col-md-4">
                            <small class="text-muted">Created At</small>
                            <div class="fw-bold" id="viewCreatedAt"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color:#00580f;">
                    <i class="bx bx-edit me-2"></i>Edit User
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editUserForm" enctype="multipart/form-data">
                @csrf

                <input type="hidden" id="editUserId">

                <div class="modal-body">

                    <!-- LOGIN INFO -->
                    <div class="mb-4 p-4 rounded-4"
                        style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                        <h6 class="fw-bold mb-3" style="color:#00580f;">Login Information</h6>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Username *</label>
                                <input type="text" id="editUsername" name="username" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Email *</label>
                                <input type="email" id="editEmail" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Phone</label>
                                <input type="text" id="editPhone" name="phonenumber" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- PROFILE INFO -->
                    <div class="mb-4 p-4 rounded-4"
                        style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                        <h6 class="fw-bold mb-3" style="color:#00580f;">Profile Information</h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">First Name</label>
                                <input type="text" id="editFirstname" name="firstname" class="form-control">
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

                    <!-- ACCOUNT SETTINGS -->
                    <div class="p-4 rounded-4"
                        style="background: rgba(5,88,15,.06); border:1px solid rgba(5,88,15,.1);">

                        <h6 class="fw-bold mb-3" style="color:#00580f;">Account Settings</h6>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">User Role *</label>
                                <select id="editUserRole" name="user_role" class="form-select" required>
                                    <option value="1">Imaam</option>
                                    <option value="2">District Qadh</option>
                                    <option value="3">Directorate Sharia</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Account Status *</label>
                                <select id="editAccountStatus" name="account_status" class="form-select" required>
                                    <option value="10">Active</option>
                                    <option value="5">Pending</option>
                                    <option value="0">Banned</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Registration Status *</label>
                                <select id="editRegistrationStatus" name="registration_status" class="form-select"
                                    required>
                                    <option value="0">Incomplete</option>
                                    <option value="1">Complete</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn fw-bold text-white"
                        style="background: linear-gradient(135deg,#00580f,#059580);">
                        <i class="bx bx-save me-2"></i>Update User
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

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
        const viewAccountStatus = document.getElementById('viewAccountStatus');
        const viewRegistrationStatus = document.getElementById('viewRegistrationStatus');
        const viewCreatedAt = document.getElementById('viewCreatedAt');

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
        const editAccountStatus = document.getElementById('editAccountStatus');
        const editRegistrationStatus = document.getElementById('editRegistrationStatus');

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
                        viewAccountStatus.textContent = user.account_status_text ?? '-';
                        viewRegistrationStatus.textContent = user.registration_status_text ?? '-';
                        viewCreatedAt.textContent = user.created_at ?? '-';

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
                        editUserRole.value = user.user_role ?? '';
                        editAccountStatus.value = user.account_status ?? '';
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

        }); // end click delegation

        /* ================= EDIT FORM SUBMISSION ================= */
        editUserForm.addEventListener('submit', function (e) {
            e.preventDefault(); // prevent normal form submission

            Swal.fire({
                title: 'Update User?',
                text: 'Are you sure you want to update this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059580',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update'
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

                        // If response is not JSON (like an HTML error page), show it
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
                            // validation errors
                            let messages = Object.values(data.message).flat().join('\n');
                            Swal.fire('Validation Error', messages, 'error');
                        } else {
                            Swal.fire('Error', data.message || 'Failed to update user.', 'error');
                        }
                    })
                    .catch(err => {
                        if (err.message === 'NON_JSON_RESPONSE') return;

                        console.error('Error updating user:', err);

                        // Show SweetAlert and redirect anyway
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