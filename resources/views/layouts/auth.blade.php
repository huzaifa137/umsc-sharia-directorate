@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <meta name="theme-color" content="#0a3320">
    <title>@yield('title', 'Sign in') | Directorate of Sharia</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600&family=Source+Serif+4:opsz,wght@8..60,400;8..60,600;8..60,700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/umsc-public.css') }}">
    <link rel="stylesheet" href="{{ asset('css/umsc-auth.css') }}">
</head>

<body class="umsc-public umsc-auth">
    <div class="a-shell">

        <aside class="a-aside">
            <a href="{{ url('/') }}" class="a-brand" aria-label="Directorate of Sharia, home">
                <span class="a-brand-badge"><img src="{{ asset('asset/images/logo.png') }}" alt=""></span>
                <span>
                    <strong>Directorate of Sharia</strong>
                    <span>Uganda Muslim Supreme Council</span>
                </span>
            </a>

            <div class="a-aside-body">
                <h2>@yield('aside_title', 'Staff portal')</h2>
                <p>@yield('aside_text', 'Register records, review applications and print certificates for your mosque, county, district or region.')</p>
            </div>

            <div class="a-aside-foot">
                <span class="a-motto">وَاعْتَصِمُوا بِحَبْلِ اللَّهِ جَمِيعًا</span>
                Access is limited to authorised UMSC officers. Activity on this system is logged.
            </div>
        </aside>

        <div class="a-main">
            <div class="a-top">
                <a href="{{ url('/') }}">&larr; Back to the website</a>
                <div class="a-lang" aria-label="Language">
                    <a href="{{ route('lang.switch', 'en') }}" class="{{ $locale === 'en' ? 'is-active' : '' }}">EN</a>
                    <a href="{{ route('lang.switch', 'sw') }}" class="{{ $locale === 'sw' ? 'is-active' : '' }}">SW</a>
                    <a href="{{ route('lang.switch', 'ar') }}" class="{{ $locale === 'ar' ? 'is-active' : '' }}">العربية</a>
                </div>
            </div>
            <main class="a-center">
                <div class="a-form">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="{{ asset('js/umsc-auth.js') }}"></script>
    @stack('scripts')
</body>

</html>
