@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Directorate of Sharia | Uganda Muslim Supreme Council')</title>
    <meta name="description"
        content="@yield('description', 'Official records and rulings of the UMSC Directorate of Sharia: Nikah, divorce, inheritance, guardianship, converts and Fatwa across Uganda.')">
    <meta name="author" content="Uganda Muslim Supreme Council (UMSC)">
    <meta name="theme-color" content="#0a3320">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/umsc-public.css') }}">
    @stack('head')
</head>

<body class="umsc-public">
    <a href="#main" class="u-skip">Skip to content</a>

    <div class="u-strip">
        <div class="u-wrap">
            <span>Uganda Muslim Supreme Council</span>
            <div class="u-lang" aria-label="Language">
                <a href="{{ route('lang.switch', 'en') }}" class="{{ $locale === 'en' ? 'is-active' : '' }}">English</a>
                <a href="{{ route('lang.switch', 'sw') }}" class="{{ $locale === 'sw' ? 'is-active' : '' }}">Kiswahili</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="{{ $locale === 'ar' ? 'is-active' : '' }}">العربية</a>
            </div>
        </div>
    </div>

    <header class="u-header">
        <div class="u-wrap">
            <a href="{{ url('/') }}" class="u-brand" aria-label="Directorate of Sharia, home">
                <img src="{{ asset('asset/images/logo.png') }}" alt="">
                <div>
                    <div class="u-brand-name">Directorate of Sharia <span class="u-brand-ar">مديرية الشريعة</span></div>
                    <span class="u-brand-sub">Uganda Muslim Supreme Council</span>
                </div>
            </a>

            <button class="u-burger" id="uBurger" type="button" aria-label="Menu" aria-expanded="false"
                aria-controls="uNav"><i class="fa-solid fa-bars"></i></button>

            <ul class="u-nav" id="uNav">
                <li><a href="{{ url('/') }}#services">Services</a></li>
                <li><a href="{{ url('/') }}#process">How it works</a></li>
                <li><a href="{{ url('/') }}#structure">Structure</a></li>
                <li><a href="{{ route('fatwa.public.index') }}">Fatwa</a></li>
                <li><a href="{{ url('/') }}#contact">Contact</a></li>
                <li class="u-nav-cta"><a href="{{ url('users/login') }}">{{ __('ui.nav.login') }}</a></li>
            </ul>
        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="u-footer">
        <div class="u-wrap">
            <div class="u-footer-top">
                <div class="u-footer-brand">
                    <div class="u-footer-badge"><img src="{{ asset('asset/images/logo.png') }}" alt=""></div>
                    <div>
                        <strong>Directorate of Sharia</strong>
                        <p>Uganda Muslim Supreme Council. Records, certificates and rulings for the Muslim community.</p>
                    </div>
                </div>
                <div>
                    <h4>Services</h4>
                    <ul>
                        <li><a href="{{ url('/') }}#services">Nikah</a></li>
                        <li><a href="{{ url('/') }}#services">Divorce</a></li>
                        <li><a href="{{ url('/') }}#services">Inheritance</a></li>
                        <li><a href="{{ url('/') }}#services">Guardianship</a></li>
                        <li><a href="{{ url('/') }}#services">New Muslims</a></li>
                    </ul>
                </div>
                <div>
                    <h4>The site</h4>
                    <ul>
                        <li><a href="{{ route('fatwa.public.index') }}">Fatwa</a></li>
                        <li><a href="{{ url('/') }}#process">How it works</a></li>
                        <li><a href="{{ url('/') }}#structure">Structure</a></li>
                        <li><a href="{{ url('users/login') }}">Staff sign in</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contact</h4>
                    <ul>
                        <li>UMSC Headquarters, Old Kampala</li>
                        <li>+256 000 000 000</li>
                        <li>sharia@umsc.example</li>
                    </ul>
                </div>
            </div>
            <div class="u-footer-bottom">
                <span>&copy; {{ date('Y') }} Uganda Muslim Supreme Council</span>
                <span class="u-motto">وَاعْتَصِمُوا بِحَبْلِ اللَّهِ جَمِيعًا</span>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/umsc-public.js') }}"></script>
    @stack('scripts')
</body>

</html>
