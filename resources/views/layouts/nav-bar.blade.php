<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="layout-menu-toggle navbar-nav d-xl-none align-items-xl-center me-3 me-xl-0">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto" style="gap: 8px;"> <!-- Reduced gap -->

                <!-- Language Selector -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        <img id="active-language-flag" src="{{ asset('asset/flags/us.png') }}" alt="Language"
                            class="rounded-circle"
                            style="width: 36px; height: 36px; object-fit: cover; border: 1px solid #e5e7eb;">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 140px;">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 language-option"
                                href="javascript:void(0);" data-lang="en">
                                <img src="{{ asset('asset/flags/us.png') }}" class="rounded-circle"
                                    style="width: 24px; height: 24px;">
                                <span>English</span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 language-option"
                                href="javascript:void(0);" data-lang="ar">
                                <img src="{{ asset('asset/flags/ar.png') }}" class="rounded-circle"
                                    style="width: 24px; height: 24px;">
                                <span>العربية</span>
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 language-option"
                                href="javascript:void(0);" data-lang="sw">
                                <img src="{{ asset('asset/flags/tz.png') }}" class="rounded-circle"
                                    style="width: 24px; height: 24px;">
                                <span>Kiswahili</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- /Language Selector -->


                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                        data-bs-toggle="dropdown">
                        <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center avatar-online"
                            style="width: 36px; height: 36px; font-weight: 600; background-color: #008F4C;">
                            {{ strtoupper(substr(Helper::logged_username(), 0, 1)) }}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar text-white rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 40px; height: 40px; font-weight: 600;background-color: #008F4C;">
                                            {{ strtoupper(substr(Helper::logged_username(), 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="lh-1 d-block fw-semibold">{{ Helper::logged_username() }}</span>
                                        <small>Admin</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('user.profile') }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">{{ __('ui.my_profile') }}</span>
                            </a>
                        </li>

                        <li>
                            <div class="dropdown-divider"></div>
                        </li>


                        <li>
                            <a class="dropdown-item" href="javascript:void(0);" id="logout-btn">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">{{ __('ui.log_out') }}</span>
                            </a>
                        </li>

                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>

        <script>
            const translations = {
                en: {
                    directorate_of_sharia: "DIRECTORATE OF SHARIA",
                },
                ar: {
                    directorate_of_sharia: "مديرية الشريعة",
                },
                sw: {
                    directorate_of_sharia: "IDARA YA SHARIA",
                }
            };
        </script>

        <!-- THEN your language logic script -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {

                const DEFAULT_LANG = 'en';
                const STORAGE_KEY = 'app_language';

                const flagMap = {
                    en: "{{ asset('asset/flags/us.png') }}",
                    ar: "{{ asset('asset/flags/ar.png') }}",
                    sw: "{{ asset('asset/flags/tz.png') }}"
                };

                const currentFlagImg = document.getElementById('active-language-flag');

                function applyLanguage(lang) {
                    if (!translations || !translations[lang]) return;

                    document.querySelectorAll('[data-i18n]').forEach(el => {
                        const key = el.dataset.i18n;
                        if (translations[lang][key]) {
                            el.textContent = translations[lang][key];
                        }
                    });

                    if (currentFlagImg && flagMap[lang]) {
                        currentFlagImg.src = flagMap[lang];
                    }

                    localStorage.setItem(STORAGE_KEY, lang);
                    document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';
                }

                const savedLang = localStorage.getItem(STORAGE_KEY) || DEFAULT_LANG;
                applyLanguage(savedLang);

                document.querySelectorAll('.language-option').forEach(item => {
                    item.addEventListener('click', function () {
                        applyLanguage(this.dataset.lang);
                    });
                });

            });
        </script>


        <script>
            $(document).on('click', '#logout-btn', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You will be logged out of your session.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, log me out!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('user.logout') }}";
                    }
                });
            });
        </script>

        <!-- Search Small Screens -->
        <div class="navbar-search-wrapper search-input-wrapper d-none">
            <input type="text" class="form-control search-input container-fluid border-0" placeholder="Search..."
                aria-label="Search..." />
            <i class="bx bx-x bx-sm search-toggler cursor-pointer"></i>
        </div>
    </div>
</nav>