<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - {{ Helper::app_name() }} </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
    <!-- Vendor -->
    <link rel="stylesheet" href="../../assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

    <!-- Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    {{--
  <script src="../../assets/vendor/js/template-customizer.js"></script> --}}
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../../assets/js/config.js"></script>
</head>

{{--

<body style="background-image: url('{{ asset('assets/img/branding/loginBackground.png') }}');"> --}}

<body style="background: linear-gradient(to bottom, #28a745, #ffffff);">

    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class=" py-4">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div style="text-align: center; margin-bottom: 10px;">
                            <img src="{{ asset('assets/img/branding/logo-png.png') }}" alt="Logo"
                                style="width: 120px; height: auto; border-radius: 8px;">
                        </div>
                        <!-- /Logo -->

                        <h3 class="mb-3"
                            style="
        text-align: center;
        font-weight: 700;
        letter-spacing: 1px;
        background: #21532B;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-family: 'Algerian', sans-serif;
    ">
                            DIRECTORATE OF SHARIA
                        </h3>


                        <p class="mb-2">Log in to proceed</p>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('fail'))
                            <div class="alert alert-danger">
                                {{ session('fail') }}
                            </div>
                        @endif


                        <form action="{{ route('auth-user-check') }}" method="POST">
                            @csrf

                            <!-- Email or Username -->
                            <div class="input-group mb-3">
                                <div class="input-wrapper w-100">
                                    <input type="text" id="email" name="email" class="form-control"
                                        placeholder="Enter your email or username" value="{{ old('email') }}">
                                    <span class="text-danger d-block" id="email-error"></span>
                                </div>
                            </div>

                            <div class="input-group">
                                <input type="password" class="form-control" placeholder="Password" id="password"
                                    name="password">

                                <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                                    <i class="fa fa-eye" id="eyeIcon"></i>
                                </span>
                            </div>
                            <span class="text-danger d-block" id="password-error"></span>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <a href="{{ route('forgot-password') }}" class="btn btn-link box-shadow-0 px-0">
                                        Forgot password?
                                    </a>
                                    <a href="{{ url('/') }}" class="btn btn-link box-shadow-0 px-0 ml-auto">
                                        Return to Homepage
                                    </a>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block" id="login_button">
                                        <i class="fe fe-arrow-right"></i> Login
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#login_button').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                button.prop('disabled', true).html('<i class="fe fe-arrow-right"></i> Logging in...');

                let email = $('#email').val().trim();
                let password = $('#password').val().trim();

                // Clear previous validation
                $('#email').removeClass('is-invalid is-valid');
                $('#password').removeClass('is-invalid is-valid');
                $('#email-error').text('');
                $('#password-error').text('');

                let hasErrors = false;
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                // Email or Username logic
                if (!email) {
                    $('#email').addClass('is-invalid');
                    $('#email-error').text('Email or username is required.');
                    hasErrors = true;
                } else if (email.includes('@') && !emailRegex.test(email)) {
                    $('#email').addClass('is-invalid');
                    $('#email-error').text('Please enter a valid email address.');
                    hasErrors = true;
                } else {
                    $('#email').addClass('is-valid');
                }

                // Password validation
                if (!password) {
                    $('#password').addClass('is-invalid');
                    $('#password-error').text('Password is required.');
                    hasErrors = true;
                } else {
                    $('#password').addClass('is-valid');
                }

                if (hasErrors) {
                    button.prop('disabled', false).html('<i class="fe fe-arrow-right"></i> Login');
                    return;
                }

                // AJAX Login
                $.ajax({
                    url: "{{ route('auth-user-check') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response.status) {
                            window.location.href = response.redirect_url;
                        } else {
                            $('#password').addClass('is-invalid');
                            $('#password-error').text(response.message ??
                                'Invalid credentials.');

                            button.prop('disabled', false).html(
                                '<i class="fe fe-arrow-right"></i> Login');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $('#email').addClass('is-invalid');
                                $('#email-error').text(errors.email[0]);
                            }
                            if (errors.password) {
                                $('#password').addClass('is-invalid');
                                $('#password-error').text(errors.password[0]);
                            }
                        } else {
                            $('body').html(xhr.responseText); // fallback
                        }

                        button.prop('disabled', false).html(
                            '<i class="fe fe-arrow-right"></i> Login');
                    }
                });
            });
        });


        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>


    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../../assets/vendor/libs/popper/popper.js"></script>
    <script src="../../assets/vendor/js/bootstrap.js"></script>
    <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
    {{--
    <script src="../../assets/vendor/libs/i18n/i18n.js"></script> --}}
    <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>

    <script src="../../assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="../../assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
    <script src="../../assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>

    <!-- Main JS -->
    <script src="../../assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="../../assets/js/pages-auth.js"></script>
</body>

</html>
