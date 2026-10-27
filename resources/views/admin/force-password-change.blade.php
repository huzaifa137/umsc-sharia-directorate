<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Set a New Password - {{ Helper::app_name() }} </title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body style="background: #28a745;">

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="py-4">
                <div class="card">
                    <div class="card-body">
                        <div style="text-align: center; margin-bottom: 10px;">
                            <img src="{{ asset('assets/img/branding/logo-png.png') }}" alt="Logo"
                                style="width: 120px; height: auto; border-radius: 8px;">
                        </div>

                        <div class="mx-auto mb-3 d-flex align-items-center justify-content-center rounded-circle"
                             style="width: 64px; height: 64px; background: #eafaf0;">
                            <i class="bx bx-key" style="font-size: 30px; color: #00580f;"></i>
                        </div>

                        <h4 class="mb-1 text-center fw-bold" style="color:#21532B;">Set a New Password</h4>
                        <p class="mb-4 text-center text-muted">
                            Welcome, {{ $user->firstname }}. For your security, please choose a new
                            password before continuing — this replaces the one issued to you.
                        </p>

                        <form id="forceChangeForm">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword" name="newPassword"
                                        placeholder="At least 8 characters, with an uppercase letter & symbol">
                                    <span class="input-group-text" style="cursor:pointer;" onclick="toggleField('newPassword', this)">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <span class="text-danger d-block small" id="newPassword-error"></span>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                        placeholder="Re-enter the new password">
                                    <span class="input-group-text" style="cursor:pointer;" onclick="toggleField('confirmPassword', this)">
                                        <i class="fa fa-eye"></i>
                                    </span>
                                </div>
                                <span class="text-danger d-block small" id="confirmPassword-error"></span>
                            </div>

                            <button type="submit" class="btn btn-success btn-block w-100 mt-2" id="submitBtn">
                                <i class="bx bx-check-shield me-1"></i> Save & Continue
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleField(id, el) {
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

        $('#forceChangeForm').on('submit', function(e) {
            e.preventDefault();

            $('#newPassword-error, #confirmPassword-error').text('');
            const btn = $('#submitBtn');
            btn.prop('disabled', true).html('<i class="bx bx-loader-alt bx-spin me-1"></i> Saving...');

            $.ajax({
                url: "{{ route('admin.change.password') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    newPassword: $('#newPassword').val(),
                    confirmPassword: $('#confirmPassword').val(),
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated',
                        text: res.message,
                        confirmButtonColor: '#00580f',
                    }).then(() => {
                        window.location.href = res.redirect_url || '/users/dashboard';
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors || {};
                        Object.keys(errors).forEach(key => {
                            $('#' + key + '-error').text(errors[key][0]);
                        });
                    } else {
                        Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                    }
                    btn.prop('disabled', false).html('<i class="bx bx-check-shield me-1"></i> Save & Continue');
                }
            });
        });
    </script>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
