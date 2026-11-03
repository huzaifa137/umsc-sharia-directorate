<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Helper::app_name() }} - SHARIA</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600&family=Amiri:wght@400;700&family=Source+Serif+4:opsz,wght@8..60,500;8..60,600&display=swap" rel="stylesheet" />

    {{-- Legacy base sheet: a few form pages still lean on its reset and helper classes.
         umsc-forms.css is loaded after the form markup (see form-footers) so it wins the cascade. --}}
    <link rel="stylesheet" href="{{ asset('asset/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="umsc-form">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <a class="uf-skip" href="#uf-main">Skip to the form</a>

    <div class="uf-page">
        <header class="uf-bar">
            <a class="uf-bar__brand" href="{{ url('users/dashboard') }}" aria-label="Directorate of Sharia">
                <img src="{{ asset('asset/images/logo.png') }}" alt="" class="uf-bar__crest" width="36" height="36">
                <span class="uf-bar__name">
                    <strong data-i18n="header.title">Uganda Muslim Supreme Council</strong>
                    <span data-i18n="header.subtitle">Directorate of Sharia</span>
                </span>
            </a>

            <div class="uf-bar__docket" title="Application ID">
                <span data-i18n="application_id_label">Application ID</span>
                <b id="applicationId">{{ Helper::generateApplicationId() }}</b>
            </div>

            <div class="uf-bar__tools">
                <div class="language-selector" role="group" aria-label="Language">
                    <button type="button" class="lang-btn active" data-lang="en" lang="en">English</button>
                    <button type="button" class="lang-btn" data-lang="ar" lang="ar">العربية</button>
                    <button type="button" class="lang-btn" data-lang="sw" lang="sw">Kiswahili</button>
                </div>
                <a href="{{ url('users/dashboard') }}" class="uf-exit" id="backToDashboard">
                    <i class="bx bx-arrow-back" aria-hidden="true"></i>
                    <span data-i18n="back_to_dashboard">Back to Dashboard</span>
                </a>
            </div>
        </header>

        <main id="uf-main" class="uf-main">
