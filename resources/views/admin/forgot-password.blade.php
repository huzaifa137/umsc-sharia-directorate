<!DOCTYPE html>

@php
    $htmlLocale = app()->getLocale();
    $htmlDir = $htmlLocale == 'ar' ? 'rtl' : 'ltr';
@endphp
<html lang="{{ $htmlLocale }}" class="light-style customizer-hide" dir="{{ $htmlDir }}" data-theme="theme-default"
    data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login - {{ Helper::app_name() }} </title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />

    <!-- Icon CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('assets/js/config.js') }}"></script>

</head>

<body style="background: linear-gradient(to bottom, #28a745, #ffffff);">
    <!-- Content -->

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <!-- Register -->
            <div class="card">
                <div class="card-body">

                    <!-- Logo -->
                    <div style="text-align: center; margin-bottom: 20px;">
                        <img src="{{ asset('assets/img/branding/logo-png.png') }}" alt="Logo"
                            style="width: 120px; height: auto; border-radius: 8px;">
                    </div>
                    <!-- /Logo -->

                    <h4 class="">Forgot Password 🔑</h4>
                    <p class="mb-4">
                        Please enter your registered email. We will send you a link to reset your password.
                    </p>

                    <form action="{{ url('user-generate-forgot-password-link') }}" method="POST">
                        @csrf

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

                        <div class="input-group mb-1"> <!-- reduce mb-4 to mb-1 or mb-2 -->
                            <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <input type="email" name="email" id="email-input"
                                class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                placeholder="Enter Email">
                        </div>

                        @error('email')
                            <span class="text-danger d-block mt-1 mb-0">{{ $message }}</span>
                            <!-- reduce margins -->
                        @enderror

                        <span id="email-error-client" class="text-danger d-block mt-1 mb-0"
                            style="display:none;"></span>



                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-block btn-md"
                                    onclick="confirmSubmission(this)">
                                    <i class="fas fa-paper-plane"></i> Send
                                </button>
                                <br>
                                <div class="d-flex justify-content-end">
                                    <a href="{{ url('/users/login') }}" class="btn btn-link box-shadow-0 px-0">
                                        Return to Login
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
            <!-- /Register -->
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Submit on Enter key
        document.addEventListener("keydown", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                const button = document.querySelector("button[type='button']");
                confirmSubmission(button);
            }
        });

        function confirmSubmission(button) {
            const emailInput = document.getElementById('email-input');
            const emailErrorClient = document.getElementById('email-error-client');
            const email = emailInput.value.trim();

            // Clear previous client-side errors
            emailErrorClient.style.display = 'none';
            emailErrorClient.textContent = '';
            emailInput.classList.remove('is-invalid');

            if (!email) {
                // Show inline client-side error
                emailErrorClient.textContent = 'Please enter your email address.';
                emailErrorClient.style.display = 'block';
                emailInput.classList.add('is-invalid');
                return;
            }

            // If email is not empty, show confirmation popup
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to proceed with the submission?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, proceed',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.disabled = true;
                    button.innerHTML = 'Sending...<i class="fas fa-spinner fa-spin"></i> ';
                    button.closest('form').submit();
                }
            });
        }
    </script>



    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>

    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
</body>

</html>
