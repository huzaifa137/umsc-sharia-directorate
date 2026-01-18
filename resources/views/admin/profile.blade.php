@extends('layouts.app')

@section('content')
    <!-- Content -->

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="breadcrumb-wrapper py-3 mb-4">
            <span class="text-muted fw-light">Admin / Profile
        </h4>
        <div class="row gy-4">
            <!-- User Sidebar -->
            <div class="col-md-12 col-lg-12 col-xl-12 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex flex-column align-items-center">
                                <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center avatar-online fs-1"
                                    style="width: 100px; height: 100px; font-weight: 600;background-color: #008F4C;">
                                    {{ strtoupper(substr(Helper::logged_username(), 0, 1)) }}
                                </div>

                                <div class="user-info text-center mt-1">
                                    <h5 class="mb-2">{{ $admin->username }}</h5>
                                    <span class="badge bg-label-secondary">Admin</span>
                                </div>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-4">Information</h5>
                        <div class="info-container">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Full Name:</strong>
                                            <span class="ms-2">{{ $admin->firstname }}
                                                {{ $admin->lastname }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Username:</strong>
                                            <span class="ms-2">{{ $admin->username }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Email:</strong>
                                            <span class="ms-2">{{ $admin->email }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Phone:</strong>
                                            <span class="ms-2">{{ $admin->phonenumber }}</span>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Country:</strong>
                                            <span class="ms-2">{{ $admin->country }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Gender:</strong>
                                            <span
                                                class="ms-2 text-capitalize">{{ $admin->gender ?? 'Not specified' }}</span>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Role:</strong>
                                            <span class="ms-2">Admin</span>
                                        </li>
                                        <li class="list-group-item">
                                            @php
                                                $statusMap = [
                                                    0 => ['label' => 'Banned', 'class' => 'bg-label-danger'],
                                                    8 => ['label' => 'Locked', 'class' => 'bg-label-dark'],
                                                    9 => ['label' => 'Suspended', 'class' => 'bg-label-warning'],
                                                    10 => ['label' => 'Active', 'class' => 'bg-label-success'],
                                                ];
                                                $status = $statusMap[$admin->account_status] ?? [
                                                    'label' => 'Unknown',
                                                    'class' => 'bg-label-secondary',
                                                ];
                                            @endphp
                                            <strong>Status:</strong>
                                            <span class="badge {{ $status['class'] }} ms-2">{{ $status['label'] }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Change Password Button -->
                            <div class="d-flex justify-content-center mt-4">
                                <a href="javascript:;" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">
                                    <i class="bx bx-key me-1"></i>Change Password
                                </a>
                            </div>


                            <!-- Change Password Modal -->
                            <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">

                                        <!-- Modal Header with Icon and Close Button -->
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bx bx-key me-2"></i>Change Password
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        <!-- Modal Body -->
                                        <div class="modal-body">
                                            <form id="formChangePassword" method="POST">
                                                @csrf
                                                <div class="alert alert-warning" role="alert">
                                                    <h6 class="alert-heading mb-1">Password Requirements
                                                    </h6>
                                                    <span>Minimum 8 characters, at least one uppercase,
                                                        one symbol.</span>
                                                </div>
                                                <div class="row">
                                                    <div class="form-password-toggle col-12 mb-3">
                                                        <label class="form-label" for="newPassword">New
                                                            Password</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" class="form-control" id="newPassword"
                                                                name="newPassword" placeholder="********" />
                                                            <span class="input-group-text cursor-pointer"><i
                                                                    class="bx bx-hide"></i></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-password-toggle col-12 mb-3">
                                                        <label class="form-label" for="confirmPassword">Confirm
                                                            Password</label>
                                                        <div class="input-group input-group-merge">
                                                            <input type="password" class="form-control" id="confirmPassword"
                                                                name="confirmPassword" placeholder="********" />
                                                            <span class="input-group-text cursor-pointer"><i
                                                                    class="bx bx-hide"></i></span>
                                                        </div>
                                                    </div>

                                                    <!-- Action Buttons -->
                                                    <div class="col-12 text-end">
                                                        <button type="submit" class="btn btn-primary me-2">
                                                            <i class="bx bx-key me-1"></i>Change
                                                            Password
                                                        </button>

                                                        <button type="button" class="btn btn-outline-danger"
                                                            data-bs-dismiss="modal"><i
                                                                class="bx bx-x me-1"></i>{{ __('ui.buttons.cancel') }}</button>
                                                    </div>
                                                </div>
                                            </form>

                                            <div id="password-change-alert" class="mt-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>

            </div>
            <!--/ User Sidebar -->

        </div>


        <script>
            $('#formChangePassword').on('submit', function(e) {
                e.preventDefault();

                let formData = {
                    newPassword: $('#newPassword').val(),
                    confirmPassword: $('#confirmPassword').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.ajax({
                    type: 'POST',
                    url: '{{ route('admin.change.password') }}', // You will define this route
                    data: formData,
                    success: function(response) {
                        $('#password-change-alert').html(`
          <div class="alert alert-success">${response.message}</div>
        `);
                        $('#formChangePassword')[0].reset();
                    },
                    error: function(xhr) {
                        let errorMsg = xhr.responseJSON?.message || 'An error occurred.';
                        let errors = xhr.responseJSON?.errors;
                        let details = '';
                        if (errors) {
                            Object.values(errors).forEach(errArray => {
                                errArray.forEach(err => {
                                    details += `<li>${err}</li>`;
                                });
                            });
                        }
                        $('#password-change-alert').html(`
          <div class="alert alert-danger">
            <strong>${errorMsg}</strong>
            <ul class="mt-2">${details}</ul>
          </div>
        `);
                    }
                });
            });

            $('.form-password-toggle .input-group-text').on('click', function() {
                const $icon = $(this).find('i');
                const $input = $(this).closest('.input-group').find('input');

                const currentType = $input.attr('type');
                $input.attr('type', currentType === 'password' ? 'text' : 'password');

                $icon.toggleClass('bx-hide bx-show');
            });
        </script>


    </div>
    </div>
    <!-- / Content -->
@endsection
