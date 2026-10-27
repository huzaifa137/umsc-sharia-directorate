@php
    $__credUser = \App\Services\AccessControl::user();
@endphp

@if ($__credUser && $__credUser->must_change_password)
    <div class="modal fade" id="credentialsWarningModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 480px;">
            <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,.25);">

                <div class="modal-body p-4 text-center">
                    <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                         style="width: 64px; height: 64px; background: #fff7e6;">
                        <i class="bx bx-error" style="font-size: 30px; color: #b58900;"></i>
                    </div>

                    <h5 class="fw-bold mb-2">Action Required: Update Your Login Details</h5>
                    <p class="text-muted mb-4">
                        Your account is still using the temporary username and password issued when it was
                        created. For your security, please choose your own username and password now.
                    </p>

                    <button type="button" class="btn fw-bold w-100 py-2" id="openUpdateCredentialsBtn"
                        style="background: #00580f; color: white; border-radius: 12px;">
                        <i class="bx bx-key me-1"></i> Update My Credentials
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="updateCredentialsFormModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 460px;">
            <div class="modal-content" style="border-radius: 18px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,.25);">

                <div class="modal-header" style="background: #00580f; border-radius: 18px 18px 0 0;">
                    <h5 class="modal-title text-white fw-bold mb-0">
                        <i class="bx bx-key me-2"></i>Update Login Credentials
                    </h5>
                </div>

                <form id="updateCredentialsForm">
                    @csrf
                    <div class="modal-body p-4">

                        <div class="mb-3">
                            <label class="form-label fw-bold">New Username</label>
                            <input type="text" class="form-control" id="credUsername" name="username"
                                value="{{ $__credUser->username }}" placeholder="Choose a username">
                            <span class="text-danger d-block small mt-1" id="credUsername-error"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="credNewPassword" name="newPassword"
                                    placeholder="At least 8 characters, with an uppercase letter & symbol">
                                <span class="input-group-text" style="cursor:pointer;" onclick="umscToggleCredField('credNewPassword', this)">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <span class="text-danger d-block small mt-1" id="credNewPassword-error"></span>
                        </div>

                        <div class="mb-1">
                            <label class="form-label fw-bold">Confirm New Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="credConfirmPassword" name="confirmPassword"
                                    placeholder="Re-enter the new password">
                                <span class="input-group-text" style="cursor:pointer;" onclick="umscToggleCredField('credConfirmPassword', this)">
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <span class="text-danger d-block small mt-1" id="credConfirmPassword-error"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn fw-bold w-100 py-2" id="credSubmitBtn"
                            style="background: #00580f; color: white; border-radius: 12px;">
                            <i class="bx bx-check-shield me-1"></i> Save & Continue
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function umscToggleCredField(id, el) {
            const input = document.getElementById(id);
            const icon = el.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const warningModalEl = document.getElementById('credentialsWarningModal');
            const formModalEl = document.getElementById('updateCredentialsFormModal');

            if (!warningModalEl || !formModalEl) return;

            const warningModal = new bootstrap.Modal(warningModalEl);
            const formModal = bootstrap.Modal.getOrCreateInstance(formModalEl);

            warningModal.show();

            document.getElementById('openUpdateCredentialsBtn').addEventListener('click', function () {
                warningModal.hide();
                formModal.show();
            });

            document.getElementById('updateCredentialsForm').addEventListener('submit', function (e) {
                e.preventDefault();

                document.querySelectorAll('#updateCredentialsForm .text-danger').forEach(el => el.textContent = '');

                const btn = document.getElementById('credSubmitBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Saving...';

                fetch('{{ route("update.credentials") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: new FormData(this),
                })
                    .then(async res => {
                        const text = await res.text();
                        try { return JSON.parse(text); }
                        catch { return { status: false, message: 'Unexpected server response.' }; }
                    })
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Credentials Updated',
                                text: data.message,
                                confirmButtonColor: '#00580f',
                            }).then(() => location.reload());
                        } else if (data.errors) {
                            Object.keys(data.errors).forEach(key => {
                                const el = document.getElementById(key + '-error');
                                if (el) el.textContent = data.errors[key][0];
                            });
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bx bx-check-shield me-1"></i> Save & Continue';
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong.', 'error');
                            btn.disabled = false;
                            btn.innerHTML = '<i class="bx bx-check-shield me-1"></i> Save & Continue';
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Could not connect to the server.', 'error');
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bx bx-check-shield me-1"></i> Save & Continue';
                    });
            });
        });
    </script>
@endif