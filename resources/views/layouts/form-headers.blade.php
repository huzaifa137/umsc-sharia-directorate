<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ Helper::app_name() }} - SHARIA</title>
    <link rel="stylesheet" href="{{ asset('asset/css/styles.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .select2-container--default .select2-selection--single {
            padding: 14px 16px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 16px;
            color: #2c3e50;
            background-color: #f8fafb;
            transition: all 0.3s ease;
            font-weight: 500;
            height: auto;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            line-height: normal;
            color: #2c3e50;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #4da3ff;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(77, 163, 255, 0.15);
        }

        .form-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
        }

        .left-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: nowrap;
        }

        .left-buttons .btn {
            white-space: nowrap;
            width: auto;
        }
    </style>
    </div>

</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <div class="container">
        <header class="header">
            <div class="header-top">
                <div class="header-branding">
                    <img src="{{ asset('asset/images/logo.png') }}" alt="UMSC Logo" class="logo">
                    <div class="header-text">
                        <h1 data-i18n="header.title">Uganda Muslim Supreme Council</h1>
                        <h2 data-i18n="header.subtitle">Directorate of Sharia </h2>
                    </div>
                </div>

                <div class="language-selector">
                    <button class="lang-btn active" data-lang="en" aria-label="English">
                        <span class="flag-icon"></span>
                        <span class="lang-text">ENGLISH</span>
                    </button>
                    <button class="lang-btn" data-lang="ar" aria-label="Arabic">
                        <span class="flag-icon"></span>
                        <span class="lang-text">ARABIC</span>
                    </button>
                    <button class="lang-btn" data-lang="sw" aria-label="Swahili">
                        <span class="flag-icon"></span>
                        <span class="lang-text">SWAHILI</span>
                    </button>
                </div>
            </div>

            <div class="app-id-bar">
                <div class="app-id-left">
                    <span data-i18n="application_id_label">Application ID:</span>
                    <span id="applicationId">
                        {{ Helper::generateApplicationId() }}
                    </span>
                </div>

                <a href="{{ url('users/dashboard') }}" class="btn btn-dashboard" id="backToDashboard"
                    style="text-decoration: none;" data-i18n="back_to_dashboard">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>


            <style>
                /* lang styles */
                .language-selector {
                    display: flex;
                    gap: 6px;
                }

                .lang-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 4px;
                    padding: 6px 10px;
                    white-space: nowrap;
                    flex-shrink: 1;
                    min-width: 0;
                    /* Allows text to shrink */
                }

                .lang-text {
                    font-size: 11px;
                    /* Smaller text to fit */
                }

                /* Responsive adjustments for very small screens */
                @media (max-width: 360px) {
                    .language-selector {
                        gap: 4px;
                    }

                    .lang-btn {
                        padding: 4px 6px;
                    }

                    .lang-text {
                        font-size: 10px;
                    }
                }

                @media (max-width: 320px) {
                    .language-selector {
                        gap: 2px;
                    }

                    .lang-btn {
                        padding: 3px 4px;
                    }

                    .lang-text {
                        font-size: 9px;
                    }
                }

                .app-id-bar {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .app-id-left {
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }

                .btn-dashboard {
                    border-radius: 6px;
                    background-color: #4A7C55;
                    color: #fff;
                    font-size: 14px;
                    font-weight: 500;
                    text-decoration: none;

                    white-space: nowrap;
                }

                .btn-dashboard:hover {
                    background-color: #1a252f;
                }

                @media (max-width: 640px) {
                    .app-id-bar {
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 10px;
                    }

                    .app-id-left {
                        flex-direction: column;
                        align-items: flex-start;
                        gap: 4px;
                    }

                    .btn-dashboard {
                        width: 100%;
                        text-align: center;
                        padding: 10px 0;
                    }
                }

                .language-selector {
                    display: flex;
                    gap: 6px;
                    /* Prevent reordering */
                    flex-direction: row !important;
                    direction: ltr !important;
                }

                /* Force specific order for each button */
                .lang-btn[data-lang="en"] {
                    order: 1 !important;
                }

                .lang-btn[data-lang="ar"] {
                    order: 2 !important;
                }

                .lang-btn[data-lang="sw"] {
                    order: 3 !important;
                }
            </style>
        </header>
