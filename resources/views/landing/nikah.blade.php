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

        @media (max-width: 640px) {
            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .form-row .form-group {
                width: 100%;
            }

            .date-inputs {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .date-inputs input,
            .date-inputs select {
                width: 100%;
                box-sizing: border-box;
            }

            .select2-container--default .select2-selection--single {
                padding: 12px 14px;
                font-size: 14px;
            }
        }

        /* Improved responsive navigation */
        @media (max-width: 640px) {
            .form-navigation {
                flex-direction: column;
                gap: 10px;
            }

            /* Container for all navigation buttons */
            .form-navigation>* {
                width: 100%;
            }

            /* Style for the dashboard button when it's part of the left-buttons container */
            .left-buttons .btn-outline.backToDashboard {
                order: 3;
                /* Positions it after Previous and Next buttons */
                margin-top: 5px;
            }

            /* If the dashboard button is a direct child of form-navigation */
            .form-navigation .btn-outline.backToDashboard {
                width: 100%;
                text-align: center;
                margin-top: 10px;
            }

            /* Ensure buttons have proper spacing */
            .btn {
                width: 100%;
                justify-content: center;
                padding: 12px 16px;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add this in the <head> section of your HTML to use Font Awesome icons -->
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
                    <button class="lang-btn active" data-lang="en" title="English">
                        <span class="flag-icon"></span>
                        <span class="lang-text">ENGLISH</span>
                    </button>
                    <button class="lang-btn" data-lang="ar" title="Arabic">
                        <span class="flag-icon"></span>
                        <span class="lang-text">ARABIC</span>
                    </button>
                    <button class="lang-btn" data-lang="sw" title="Swahili">
                        <span class="flag-icon"></span>
                        <span class="lang-text">SWAHILI</span>
                    </button>
                </div>
            </div>
            <div class="app-id-bar">
                <div class="app-id-left">
                    <span data-i18n="header.appId">Application ID:</span>
                    <span id="applicationId">
                        {{ Helper::generateApplicationId() }}
                    </span>
                </div>

                <a href="{{ url('users/dashboard') }}" class="btn btn-dashboard backToDashboard"
                    style="text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
        </header>

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar">
                <div class="progress-fill" id="progressFill"></div>
            </div>
            <div class="progress-steps">
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label" data-i18n="steps.groom">Groom Details</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label" data-i18n="steps.bride">Bride Details</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label" data-i18n="steps.parents">Parents Details</div>
                </div>
                <div class="step" data-step="4">
                    <div class="step-number">4</div>
                    <div class="step-label" data-i18n="steps.witnesses">Witnesses</div>
                </div>
                <div class="step" data-step="5">
                    <div class="step-number">5</div>
                    <div class="step-label" data-i18n="steps.photos">Photos</div>
                </div>
                <div class="step" data-step="6">
                    <div class="step-number">6</div>
                    <div class="step-label" data-i18n="steps.review">Review</div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <!-- Navigation Sidebar -->
            <aside class="sidebar">
                <nav class="nav-menu">
                    <a href="#" class="nav-item active" data-section="1">
                        <span class="nav-text" data-i18n="nav.groom">GROOM DETAILS</span>
                    </a>
                    <a href="#" class="nav-item" data-section="2">
                        <span class="nav-text" data-i18n="nav.bride">BRIDE DETAILS</span>
                    </a>
                    <a href="#" class="nav-item" data-section="3">
                        <span class="nav-text" data-i18n="nav.parents">PARENTS DETAILS</span>
                    </a>
                    <a href="#" class="nav-item" data-section="4">
                        <span class="nav-text" data-i18n="nav.witnesses">WITNESSES</span>
                    </a>
                    <a href="#" class="nav-item" data-section="5">
                        <span class="nav-text" data-i18n="nav.photos">PHOTOS</span>
                    </a>
                    <a href="#" class="nav-item" data-section="6">
                        <span class="nav-text" data-i18n="nav.review">REVIEW & SUBMIT</span>
                    </a>
                </nav>
            </aside>

            <!-- Updated form content with modern input styling matching reference image -->
            <main class="form-content">
                <form id="nikkahForm" method="POST" action="{{ route('nikkah.save') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" id="application_id" name="application_id" value="">
                    <!-- Step 1: Groom Details -->
                    <section class="form-section active" id="section1">
                        <h3 class="section-title" data-i18n="groom.title">GROOM'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomSurname" data-i18n="labels.surname">Surname<span
                                        class="required">*</span></label>
                                <input type="text" id="groomSurname" name="groom_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="groomGivenName" data-i18n="labels.givenName">Given Name<span
                                        class="required">*</span></label>
                                <input type="text" id="groomGivenName" name="groom_given_name" required>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label data-i18n="labels.dob">Date of Birth (DD/MM/YYYY)<span
                                        class="required">*</span></label>
                                <div class="date-inputs">
                                    <input type="number" placeholder="Day" min="1" max="31"
                                        name="groom_day_date_of_birth" required>
                                    <select class="select2" name="groom_month_date_of_birth" required>
                                        <option value="">Select Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <input type="number" name="groom_year_date_of_birth" placeholder="Year" min="1900"
                                        max="2010" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Groom Country <span class="required">*</span></label>
                                <select class="form-control select2" name="groom_country" id="groomCountry" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->iso_3166_2 }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Groom NIN -->
                            <div class="form-group">
                                <label for="groomNIN" id="ninLabel">
                                    National Identity Number (NIN)<span class="required"></span>
                                </label>
                                <input type="text" name="groomNIN" id="groomNIN" class="form-control">
                            </div>


                            <!-- Groom Telephone -->
                            <div class="form-group">
                                <label for="groomTelephone">Telephone Number<span class="required">*</span></label>

                                <div class="input-group phone-input-group">
                                    <select id="groomCountryCode" class="form-control country-code select2">
                                        <option value="">Code</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->calling_code }}">{{ $country->name }}
                                                (+{{ $country->calling_code }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="tel" id="groomTelephone" name="bride_telephone"
                                        class="form-control phone-number" placeholder="Phone number" required
                                        maxlength="15">
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomEmail" data-i18n="labels.email">Email Address</label>
                                <input type="email" id="groomEmail" name="groom_email">
                            </div>
                            <div class="form-group">
                                <label for="groomTribe" data-i18n="labels.tribe">Tribe<span
                                        class="required">*</span></label>
                                <select class="select2" id="groomTribe" name="groom_tribe">
                                    <option value="">--please select--</option>
                                    <option value="Acholi">Acholi</option>
                                    <option value="Aliba">Aliba</option>
                                    <option value="Alur">Alur</option>
                                    <option value="Aringa">Aringa</option>
                                    <option value="Baamba">Baamba</option>
                                    <option value="Babukusu">Babukusu</option>
                                    <option value="Babwisi">Babwisi</option>
                                    <option value="Bafumbira">Bafumbira</option>
                                    <option value="Baganda">Baganda</option>
                                    <option value="Bagisu">Bagisu</option>
                                    <option value="Bagungu">Bagungu</option>
                                    <option value="Bagwe (Samia-Bugwe)">Bagwe (Samia-Bugwe)</option>
                                    <option value="Bagwere">Bagwere</option>
                                    <option value="Bahehe">Bahehe</option>
                                    <option value="Bahororo">Bahororo</option>
                                    <option value="Bakenyi">Bakenyi</option>
                                    <option value="Bakiga">Bakiga</option>
                                    <option value="Bakonzo">Bakonzo</option>
                                    <option value="Banyabindi">Banyabindi</option>
                                    <option value="Banyabutumbi">Banyabutumbi</option>
                                    <option value="Banyankore">Banyankore</option>
                                    <option value="Banyara">Banyara</option>
                                    <option value="Banyaruguru">Banyaruguru</option>
                                    <option value="Banyole">Banyole</option>
                                    <option value="Banyoro">Banyoro</option>
                                    <option value="Baruli">Baruli</option>
                                    <option value="Barundi">Barundi</option>
                                    <option value="Basamia">Basamia</option>
                                    <option value="Basimba">Basimba</option>
                                    <option value="Basoga">Basoga</option>
                                    <option value="Basongora">Basongora</option>
                                    <option value="Batagwenda">Batagwenda</option>
                                    <option value="Batoro">Batoro</option>
                                    <option value="Batuku">Batuku</option>
                                    <option value="Batwa">Batwa</option>
                                    <option value="Chope">Chope</option>
                                    <option value="Dodoth">Dodoth</option>
                                    <option value="Ethur (Acholi-Labwor)">Ethur (Acholi-Labwor)</option>
                                    <option value="Gimara">Gimara</option>
                                    <option value="Ik (Teuso)">Ik (Teuso)</option>
                                    <option value="Iteso">Iteso</option>
                                    <option value="Jie">Jie</option>
                                    <option value="Jonam">Jonam</option>
                                    <option value="Jopadhola">Jopadhola</option>
                                    <option value="Kakwa">Kakwa</option>
                                    <option value="Karimojong">Karimojong</option>
                                    <option value="Kebu (Okebu)">Kebu (Okebu)</option>
                                    <option value="Kuku">Kuku</option>
                                    <option value="Kumam">Kumam</option>
                                    <option value="Langi">Langi</option>
                                    <option value="Lendu">Lendu</option>
                                    <option value="Lugbara">Lugbara</option>
                                    <option value="Madi">Madi</option>
                                    <option value="Mening">Mening</option>
                                    <option value="Mvuba">Mvuba</option>
                                    <option value="Napore">Napore</option>
                                    <option value="Ngikutio">Ngikutio</option>
                                    <option value="Nubi">Nubi</option>
                                    <option value="Nyangia">Nyangia</option>
                                    <option value="Pokot">Pokot</option>
                                    <option value="Reli">Reli</option>
                                    <option value="Sabiny">Sabiny</option>
                                    <option value="Shana">Shana</option>
                                    <option value="So (Tepeth)">So (Tepeth)</option>
                                    <option value="Vonoma">Vonoma</option>
                                    <option value="add_new">+ Add New Tribe</option>
                                </select>

                                <div id="newTribeWrapper" style="display:none; margin-top:10px;">
                                    <label for="newTribe">Or add a new tribe</label><br>
                                    <input type="text" id="newTribe" placeholder="Type your tribe here"
                                        style="width:100%;">
                                </div>
                            </div>

                            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                            <script>
                                $(document).ready(function () {

                                    $('#groomTribe').attr('required', true);

                                    $('#groomTribe').on('change', function () {
                                        if (this.value === 'add_new') {
                                            $('#newTribeWrapper').show();
                                            $('#newTribe').focus();

                                            $('#newTribe').attr('required', true);
                                            $(this).removeAttr('required');

                                            $(this).val('');
                                        } else {
                                            $('#newTribeWrapper').hide();
                                            $('#newTribe').val('');

                                            $(this).attr('required', true);
                                            $('#newTribe').removeAttr('required');
                                        }
                                    });

                                    $('form').on('submit', function () {
                                        let newTribeVal = $('#newTribe').val().trim();
                                        if (newTribeVal) {
                                            $('#groomTribe option.custom').remove();
                                            $('#groomTribe').append(new Option(newTribeVal, newTribeVal, true, true)).addClass('custom');
                                        }
                                    });

                                });
                            </script>
                        </div>


                        <h4 class="subsection-title" data-i18n="labels.residentialAddress">RESIDENTIAL ADDRESS</h4>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomDistrict" data-i18n="labels.district">District<span
                                        class="required">*</span></label>
                                <select id="groomDistrict" name="groom_district" class="district-select" required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomCounty" data-i18n="labels.county">County/Municipality<span
                                        class="required">*</span></label>
                                <select id="groomCounty" name="groom_county" class="county-select" required disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomSubCounty" data-i18n="labels.subCounty">Sub County<span
                                        class="required">*</span></label>
                                <select id="groomSubCounty" name="groom_sub_county" class="subcounty-select" required
                                    disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomParish" data-i18n="labels.parish">Parish/Ward<span
                                        class="required">*</span></label>
                                <select id="groomParish" name="groom_parish" class="parish-select" required disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomVillage" data-i18n="labels.village">Village (LC1/Zone)<span
                                        class="required">*</span></label>
                                <select id="groomVillage" name="groom_village" class="village-select" required disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomPlot" data-i18n="labels.plot">Plot Number</label>
                                <input type="text" id="groomPlot" name="groom_plot">
                            </div>
                        </div>
                    </section>

                    <!-- Step 2: Bride Details -->
                    <section class="form-section" id="section2">
                        <h3 class="section-title" data-i18n="bride.title">BRIDE'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideSurname">Surname<span class="required">*</span></label>
                                <input type="text" id="brideSurname" name="bride_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="brideGivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="brideGivenName" name="bride_given_name" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label data-i18n="labels.dob">Date of Birth (DD/MM/YYYY)<span
                                        class="required">*</span></label>
                                <div class="date-inputs">
                                    <input type="number" placeholder="Day" min="1" max="31"
                                        name="bride_day_date_of_birth" required>
                                    <select class="select2" name="bride_month_date_of_birth" required>
                                        <option value="">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <input type="number" name="bride_year_date_of_birth" placeholder="Year" min="1900"
                                        max="2010" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Bride Country <span class="required">*</span></label>
                                <select class="form-control select2" name="bride_country" id="brideCountry" required>
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->iso_3166_2 }}">
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="form-row">
                            <!-- Bride NIN -->
                            <div class="form-group">
                                <label for="brideNIN" id="brideNiNLabel">
                                    National Identity Number (NIN)<span class="required"></span>
                                </label>
                                <input type="text" id="brideNIN" name="brideNIN">
                            </div>

                            <!-- Bride Telephone -->
                            <div class="form-group">
                                <label for="brideTelephone">Telephone Number<span class="required">*</span></label>

                                <div class="input-group phone-input-group">
                                    <select id="brideCountryCode" class="form-control country-code select2">
                                        <option value="">Code</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->calling_code }}">{{ $country->name }}
                                                (+{{ $country->calling_code }})
                                            </option>
                                        @endforeach
                                    </select>

                                    <input type="tel" id="brideTelephone" name="bride_telephone"
                                        class="form-control phone-number" placeholder="Phone number" required
                                        maxlength="15">
                                </div>
                            </div>
                        </div>

                        <style>
                            .phone-input-group {
                                display: grid;
                                grid-template-columns: 120px 1fr;
                                gap: 8px;
                            }

                            .country-code {
                                width: 100%;
                            }

                            .phone-number {
                                width: 100%;
                            }

                            .input-group {
                                display: flex;
                                align-items: stretch;
                            }
                        </style>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideEmail">Email Address</label>
                                <input type="email" id="brideEmail" name="bride_email">
                            </div>

                            <div class="form-group">
                                <label for="brideTribe">Tribe<span class="required">*</span></label>
                                <select id="brideTribe" class="select2" name="bride_tribe">
                                    <option value="">--please select--</option>
                                    <option value="Acholi">Acholi</option>
                                    <option value="Aliba">Aliba</option>
                                    <option value="Alur">Alur</option>
                                    <option value="Aringa">Aringa</option>
                                    <option value="Baamba">Baamba</option>
                                    <option value="Babukusu">Babukusu</option>
                                    <option value="Babwisi">Babwisi</option>
                                    <option value="Bafumbira">Bafumbira</option>
                                    <option value="Baganda">Baganda</option>
                                    <option value="Bagisu">Bagisu</option>
                                    <option value="Bagungu">Bagungu</option>
                                    <option value="Bagwe (Samia-Bugwe)">Bagwe (Samia-Bugwe)</option>
                                    <option value="Bagwere">Bagwere</option>
                                    <option value="Bahehe">Bahehe</option>
                                    <option value="Bahororo">Bahororo</option>
                                    <option value="Bakenyi">Bakenyi</option>
                                    <option value="Bakiga">Bakiga</option>
                                    <option value="Bakonzo">Bakonzo</option>
                                    <option value="Banyabindi">Banyabindi</option>
                                    <option value="Banyabutumbi">Banyabutumbi</option>
                                    <option value="Banyankore">Banyankore</option>
                                    <option value="Banyara">Banyara</option>
                                    <option value="Banyaruguru">Banyaruguru</option>
                                    <option value="Banyole">Banyole</option>
                                    <option value="Banyoro">Banyoro</option>
                                    <option value="Baruli">Baruli</option>
                                    <option value="Barundi">Barundi</option>
                                    <option value="Basamia">Basamia</option>
                                    <option value="Basimba">Basimba</option>
                                    <option value="Basoga">Basoga</option>
                                    <option value="Basongora">Basongora</option>
                                    <option value="Batagwenda">Batagwenda</option>
                                    <option value="Batoro">Batoro</option>
                                    <option value="Batuku">Batuku</option>
                                    <option value="Batwa">Batwa</option>
                                    <option value="Chope">Chope</option>
                                    <option value="Dodoth">Dodoth</option>
                                    <option value="Ethur (Acholi-Labwor)">Ethur (Acholi-Labwor)</option>
                                    <option value="Gimara">Gimara</option>
                                    <option value="Ik (Teuso)">Ik (Teuso)</option>
                                    <option value="Iteso">Iteso</option>
                                    <option value="Jie">Jie</option>
                                    <option value="Jonam">Jonam</option>
                                    <option value="Jopadhola">Jopadhola</option>
                                    <option value="Kakwa">Kakwa</option>
                                    <option value="Karimojong">Karimojong</option>
                                    <option value="Kebu (Okebu)">Kebu (Okebu)</option>
                                    <option value="Kuku">Kuku</option>
                                    <option value="Kumam">Kumam</option>
                                    <option value="Langi">Langi</option>
                                    <option value="Lendu">Lendu</option>
                                    <option value="Lugbara">Lugbara</option>
                                    <option value="Madi">Madi</option>
                                    <option value="Mening">Mening</option>
                                    <option value="Mvuba">Mvuba</option>
                                    <option value="Napore">Napore</option>
                                    <option value="Ngikutio">Ngikutio</option>
                                    <option value="Nubi">Nubi</option>
                                    <option value="Nyangia">Nyangia</option>
                                    <option value="Pokot">Pokot</option>
                                    <option value="Reli">Reli</option>
                                    <option value="Sabiny">Sabiny</option>
                                    <option value="Shana">Shana</option>
                                    <option value="So (Tepeth)">So (Tepeth)</option>
                                    <option value="Vonoma">Vonoma</option>
                                    <option value="add_new">+ Add New Tribe</option>
                                </select>

                                <!-- Hidden label + input for new tribe -->
                                <div id="newBrideTribeWrapper" style="display:none; margin-top:10px;">
                                    <label for="newBrideTribe">Or add a new tribe</label><br>
                                    <input type="text" id="newBrideTribe" placeholder="Type your tribe here"
                                        style="width:100%;">
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                // Make dropdown required by default
                                $('#brideTribe').attr('required', true);

                                $('#brideTribe').on('change', function () {
                                    if (this.value === 'add_new') {
                                        // Show input for custom tribe
                                        $('#newBrideTribeWrapper').show();
                                        $('#newBrideTribe').focus();

                                        // Make input required, remove required from dropdown
                                        $('#newBrideTribe').attr('required', true);
                                        $(this).removeAttr('required');

                                        // Clear dropdown temporarily
                                        $(this).val('');
                                    } else {
                                        // Hide custom input
                                        $('#newBrideTribeWrapper').hide();
                                        $('#newBrideTribe').val('');

                                        // Make dropdown required again, remove required from input
                                        $(this).attr('required', true);
                                        $('#newBrideTribe').removeAttr('required');
                                    }
                                });

                                // On form submit, copy new tribe value into select
                                $('form').on('submit', function () {
                                    let newTribeVal = $('#newBrideTribe').val().trim();
                                    if (newTribeVal) {
                                        $('#brideTribe option.custom').remove();
                                        $('#brideTribe').append(new Option(newTribeVal, newTribeVal, true, true)).addClass('custom');
                                    }
                                });
                            });
                        </script>


                        <h4 class="subsection-title">RESIDENTIAL ADDRESS</h4>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideDistrict">District<span class="required">*</span></label>
                                <select id="brideDistrict" name="bride_district" class="district-select" required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideCounty">County/Municipality<span class="required">*</span></label>
                                <select id="brideCounty" name="bride_county" class="county-select" required disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideSubCounty">Sub County<span class="required">*</span></label>
                                <select id="brideSubCounty" name="bride_sub_county" class="subcounty-select" required
                                    disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideParish">Parish/Ward<span class="required">*</span></label>
                                <select id="brideParish" name="bride_parish" class="parish-select" required disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideVillage">Village (LC1/Zone)<span class="required">*</span></label>
                                <select id="brideVillage" name="bride_village" class="village-select" required disabled>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bridePlot">Plot Number</label>
                                <input type="text" id="bridePlot" name="bride_plot">
                            </div>
                        </div>
                    </section>

                    <!-- Step 3: Parents Details -->
                    <section class="form-section" id="section3">
                        <h3 class="section-title">GROOM'S FATHER'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomFatherStatus">Status<span class="required">*</span></label>
                                <select id="groomFatherStatus" name="groomFatherStatus" required>
                                    <option value="">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomFatherSurname">Surname<span class="required">*</span></label>
                                <input type="text" id="groomFatherSurname" name="groom_father_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomFatherGivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="groomFatherGivenName" name="groom_father_given_name" required>
                            </div>
                            <div class="form-group">
                                <label for="groomFatherNIN">National Identity Number (NIN)</label>
                                <input type="text" id="groomFatherNIN" name="groom_father_nin">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomFatherDistrict">District of Residence<span
                                        class="required">*</span></label>
                                <select id="groomFatherDistrict" name="groomFatherDistrict"
                                    class="district-select select2" required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomFatherTribe">Tribe<span class="required">*</span></label>
                                <select id="groomFatherTribe" name="groomFatherTribe" class="select2" required>
                                    <option value="">--please select--</option>
                                    <option value="Acholi">Acholi</option>
                                    <option value="Aliba">Aliba</option>
                                    <option value="Alur">Alur</option>
                                    <option value="Aringa">Aringa</option>
                                    <option value="Baamba">Baamba</option>
                                    <option value="Babukusu">Babukusu</option>
                                    <option value="Babwisi">Babwisi</option>
                                    <option value="Bafumbira">Bafumbira</option>
                                    <option value="Baganda">Baganda</option>
                                    <option value="Bagisu">Bagisu</option>
                                    <option value="Bagungu">Bagungu</option>
                                    <option value="Bagwe (Samia-Bugwe)">Bagwe (Samia-Bugwe)</option>
                                    <option value="Bagwere">Bagwere</option>
                                    <option value="Bahehe">Bahehe</option>
                                    <option value="Bahororo">Bahororo</option>
                                    <option value="Bakenyi">Bakenyi</option>
                                    <option value="Bakiga">Bakiga</option>
                                    <option value="Bakonzo">Bakonzo</option>
                                    <option value="Banyabindi">Banyabindi</option>
                                    <option value="Banyabutumbi">Banyabutumbi</option>
                                    <option value="Banyankore">Banyankore</option>
                                    <option value="Banyara">Banyara</option>
                                    <option value="Banyaruguru">Banyaruguru</option>
                                    <option value="Banyole">Banyole</option>
                                    <option value="Banyoro">Banyoro</option>
                                    <option value="Baruli">Baruli</option>
                                    <option value="Barundi">Barundi</option>
                                    <option value="Basamia">Basamia</option>
                                    <option value="Basimba">Basimba</option>
                                    <option value="Basoga">Basoga</option>
                                    <option value="Basongora">Basongora</option>
                                    <option value="Batagwenda">Batagwenda</option>
                                    <option value="Batoro">Batoro</option>
                                    <option value="Batuku">Batuku</option>
                                    <option value="Batwa">Batwa</option>
                                    <option value="Chope">Chope</option>
                                    <option value="Dodoth">Dodoth</option>
                                    <option value="Ethur (Acholi-Labwor)">Ethur (Acholi-Labwor)</option>
                                    <option value="Gimara">Gimara</option>
                                    <option value="Ik (Teuso)">Ik (Teuso)</option>
                                    <option value="Iteso">Iteso</option>
                                    <option value="Jie">Jie</option>
                                    <option value="Jonam">Jonam</option>
                                    <option value="Jopadhola">Jopadhola</option>
                                    <option value="Kakwa">Kakwa</option>
                                    <option value="Karimojong">Karimojong</option>
                                    <option value="Kebu (Okebu)">Kebu (Okebu)</option>
                                    <option value="Kuku">Kuku</option>
                                    <option value="Kumam">Kumam</option>
                                    <option value="Langi">Langi</option>
                                    <option value="Lendu">Lendu</option>
                                    <option value="Lugbara">Lugbara</option>
                                    <option value="Madi">Madi</option>
                                    <option value="Mening">Mening</option>
                                    <option value="Mvuba">Mvuba</option>
                                    <option value="Napore">Napore</option>
                                    <option value="Ngikutio">Ngikutio</option>
                                    <option value="Nubi">Nubi</option>
                                    <option value="Nyangia">Nyangia</option>
                                    <option value="Pokot">Pokot</option>
                                    <option value="Reli">Reli</option>
                                    <option value="Sabiny">Sabiny</option>
                                    <option value="Shana">Shana</option>
                                    <option value="So (Tepeth)">So (Tepeth)</option>
                                    <option value="Vonoma">Vonoma</option>
                                    <option value="add_new">+ Add New Tribe</option>
                                </select>

                                <div id="newGroomFatherTribeWrapper" style="display:none; margin-top:10px;">
                                    <label for="newGroomFatherTribe">Or add a new tribe</label><br>
                                    <input type="text" id="newGroomFatherTribe" placeholder="Type your tribe here"
                                        style="width:100%;">
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        // Make dropdown required by default
                                        $('#groomFatherTribe').attr('required', true);

                                        $('#groomFatherTribe').on('change', function () {
                                            if (this.value === 'add_new') {
                                                // Show input for custom tribe
                                                $('#newGroomFatherTribeWrapper').show();
                                                $('#newGroomFatherTribe').focus();

                                                // Make input required, remove required from dropdown
                                                $('#newGroomFatherTribe').attr('required', true);
                                                $(this).removeAttr('required');

                                                // Clear dropdown temporarily
                                                $(this).val('');
                                            } else {
                                                // Hide custom input
                                                $('#newGroomFatherTribeWrapper').hide();
                                                $('#newGroomFatherTribe').val('');

                                                // Make dropdown required again, remove required from input
                                                $(this).attr('required', true);
                                                $('#newGroomFatherTribe').removeAttr('required');
                                            }
                                        });

                                        // On form submit, copy new tribe value into select
                                        $('form').on('submit', function () {
                                            let newTribeVal = $('#newGroomFatherTribe').val().trim();
                                            if (newTribeVal) {
                                                $('#groomFatherTribe option.custom').remove();
                                                $('#groomFatherTribe').append(new Option(newTribeVal, newTribeVal, true, true)).addClass('custom');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>

                        <h3 class="section-title" style="margin-top: 30px;">GROOM'S MOTHER'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomMotherStatus">Status<span class="required">*</span></label>
                                <select id="groomMotherStatus" name="groomMotherStatus" required>
                                    <option value="">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomMotherSurname">Surname<span class="required">*</span></label>
                                <input type="text" id="groomMotherSurname" name="groom_mother_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomMotherGivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="groomMotherGivenName" name="groom_mother_given_name" required>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="groomMotherMaidenName">Maiden Name<span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" id="groomMotherMaidenName" name="groomMotherMaidenName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomMotherNIN">National Identity Number (NIN)</label>
                                <input type="text" id="groomMotherNIN" name="groomMotherNIN">
                            </div>
                            <div class="form-group">
                                <label for="groomMotherDistrict">District of Residence<span
                                        class="required">*</span></label>
                                <select id="groomMotherDistrict" name="groomMotherDistrict"
                                    class="district-select select2" required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="section-title" style="margin-top: 30px;">BRIDE'S FATHER'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideFatherStatus">Status<span class="required">*</span></label>
                                <select id="brideFatherStatus" name="brideFatherStatus" required>
                                    <option value="">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideFatherSurname">Surname<span class="required">*</span></label>
                                <input type="text" id="brideFatherSurname" name="bride_father_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideFatherGivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="brideFatherGivenName" name="bride_father_given_name" required>
                            </div>
                            <div class="form-group">
                                <label for="brideFatherNIN">National Identity Number (NIN)<span></span></label>
                                <input type="text" id="brideFatherNIN" name="brideFatherNIN">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideFatherDistrict">District of Residence<span
                                        class="required">*</span></label>
                                <select id="brideFatherDistrict" name="brideFatherDistrict"
                                    class="district-select select2" required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideFatherTribe">Tribe<span class="required">*</span></label>
                                <select id="brideFatherTribe" class="select2" name="brideFatherTribe" required>
                                    <option value="">--please select--</option>
                                    <option value="Acholi">Acholi</option>
                                    <option value="Aliba">Aliba</option>
                                    <option value="Alur">Alur</option>
                                    <option value="Aringa">Aringa</option>
                                    <option value="Baamba">Baamba</option>
                                    <option value="Babukusu">Babukusu</option>
                                    <option value="Babwisi">Babwisi</option>
                                    <option value="Bafumbira">Bafumbira</option>
                                    <option value="Baganda">Baganda</option>
                                    <option value="Bagisu">Bagisu</option>
                                    <option value="Bagungu">Bagungu</option>
                                    <option value="Bagwe (Samia-Bugwe)">Bagwe (Samia-Bugwe)</option>
                                    <option value="Bagwere">Bagwere</option>
                                    <option value="Bahehe">Bahehe</option>
                                    <option value="Bahororo">Bahororo</option>
                                    <option value="Bakenyi">Bakenyi</option>
                                    <option value="Bakiga">Bakiga</option>
                                    <option value="Bakonzo">Bakonzo</option>
                                    <option value="Banyabindi">Banyabindi</option>
                                    <option value="Banyabutumbi">Banyabutumbi</option>
                                    <option value="Banyankore">Banyankore</option>
                                    <option value="Banyara">Banyara</option>
                                    <option value="Banyaruguru">Banyaruguru</option>
                                    <option value="Banyole">Banyole</option>
                                    <option value="Banyoro">Banyoro</option>
                                    <option value="Baruli">Baruli</option>
                                    <option value="Barundi">Barundi</option>
                                    <option value="Basamia">Basamia</option>
                                    <option value="Basimba">Basimba</option>
                                    <option value="Basoga">Basoga</option>
                                    <option value="Basongora">Basongora</option>
                                    <option value="Batagwenda">Batagwenda</option>
                                    <option value="Batoro">Batoro</option>
                                    <option value="Batuku">Batuku</option>
                                    <option value="Batwa">Batwa</option>
                                    <option value="Chope">Chope</option>
                                    <option value="Dodoth">Dodoth</option>
                                    <option value="Ethur (Acholi-Labwor)">Ethur (Acholi-Labwor)</option>
                                    <option value="Gimara">Gimara</option>
                                    <option value="Ik (Teuso)">Ik (Teuso)</option>
                                    <option value="Iteso">Iteso</option>
                                    <option value="Jie">Jie</option>
                                    <option value="Jonam">Jonam</option>
                                    <option value="Jopadhola">Jopadhola</option>
                                    <option value="Kakwa">Kakwa</option>
                                    <option value="Karimojong">Karimojong</option>
                                    <option value="Kebu (Okebu)">Kebu (Okebu)</option>
                                    <option value="Kuku">Kuku</option>
                                    <option value="Kumam">Kumam</option>
                                    <option value="Langi">Langi</option>
                                    <option value="Lendu">Lendu</option>
                                    <option value="Lugbara">Lugbara</option>
                                    <option value="Madi">Madi</option>
                                    <option value="Mening">Mening</option>
                                    <option value="Mvuba">Mvuba</option>
                                    <option value="Napore">Napore</option>
                                    <option value="Ngikutio">Ngikutio</option>
                                    <option value="Nubi">Nubi</option>
                                    <option value="Nyangia">Nyangia</option>
                                    <option value="Pokot">Pokot</option>
                                    <option value="Reli">Reli</option>
                                    <option value="Sabiny">Sabiny</option>
                                    <option value="Shana">Shana</option>
                                    <option value="So (Tepeth)">So (Tepeth)</option>
                                    <option value="Vonoma">Vonoma</option>
                                    <option value="add_new">+ Add New Tribe</option>
                                </select>


                                <!-- Hidden input for adding a new tribe -->
                                <div id="newBrideFatherTribeWrapper" style="display:none; margin-top:10px;">
                                    <label for="newBrideFatherTribe">Or add a new tribe</label><br>
                                    <input type="text" id="newBrideFatherTribe" placeholder="Type your tribe here"
                                        style="width:100%;">
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        // Make dropdown required by default
                                        $('#brideFatherTribe').attr('required', true);

                                        $('#brideFatherTribe').on('change', function () {
                                            if (this.value === 'add_new') {
                                                // Show input for custom tribe
                                                $('#newBrideFatherTribeWrapper').show();
                                                $('#newBrideFatherTribe').focus();

                                                // Make input required, remove required from dropdown
                                                $('#newBrideFatherTribe').attr('required', true);
                                                $(this).removeAttr('required');

                                                // Clear dropdown temporarily
                                                $(this).val('');
                                            } else {
                                                // Hide custom input
                                                $('#newBrideFatherTribeWrapper').hide();
                                                $('#newBrideFatherTribe').val('');

                                                // Make dropdown required again, remove required from input
                                                $(this).attr('required', true);
                                                $('#newBrideFatherTribe').removeAttr('required');
                                            }
                                        });

                                        // On form submit, copy new tribe value into select
                                        $('form').on('submit', function () {
                                            let newTribeVal = $('#newBrideFatherTribe').val().trim();
                                            if (newTribeVal) {
                                                $('#brideFatherTribe option.custom').remove();
                                                $('#brideFatherTribe').append(new Option(newTribeVal, newTribeVal, true, true)).addClass('custom');
                                            }
                                        });
                                    });
                                </script>
                            </div>
                        </div>

                        <h3 class="section-title" style="margin-top: 30px;">BRIDE'S MOTHER'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideMotherStatus">Status<span class="required">*</span></label>
                                <select id="brideMotherStatus" name="brideMotherStatus" required>
                                    <option value="">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideMotherSurname">Surname<span class="required">*</span></label>
                                <input type="text" id="brideMotherSurname" name="bride_mother_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideMotherGivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="brideMotherGivenName" name="bride_mother_given_name" required>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="brideMotherMaidenName">Maiden Name<span
                                        class="text-muted">(Optional)</span></label>
                                <input type="text" id="brideMotherMaidenName" name="brideMotherMaidenName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideMotherNIN">National Identity Number (NIN)<span></span></label>
                                <input type="text" id="brideMotherNIN" name="brideMotherNIN">
                            </div>
                            <div class="form-group">
                                <label for="brideMotherDistrict">District of Residence<span
                                        class="required">*</span></label>
                                <select id="brideMotherDistrict" name="brideMotherDistrict"
                                    class="district-select select2" required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="section-title" style="margin-top: 30px;">DOWERY DETAILS</h3>

                        <!-- Dowery Fields -->
                        <div class="form-row mt-4">
                            <!-- Dowery Type -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="doweryType" class="d-block">Dowery Type<span
                                            class="required">*</span></label>
                                    <select id="doweryType" name="dowery_type" class="form-control" required>
                                        <option value="">-- Select Dowery Type --</option>
                                        <option value="cash">Cash</option>
                                        <option value="asset">Asset</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Specify -->
                            <div class="col-12">
                                <div class="form-group" id="dowerySpecifyWrapper" style="display:none;">
                                    <label for="dowerySpecify" class="d-block">Specify</label>
                                    <input type="text" id="dowerySpecify" name="dowery_specify" class="form-control"
                                        placeholder="" required>
                                </div>
                            </div>
                        </div>

                        <script>
                            $(document).ready(function () {
                                $('#doweryType').on('change', function () {
                                    let type = $(this).val();

                                    if (type === 'cash') {
                                        $('#dowerySpecifyWrapper').slideDown();
                                        $('#dowerySpecify').attr('placeholder', 'Enter cash amount').attr('required', true);
                                    } else if (type === 'asset') {
                                        $('#dowerySpecifyWrapper').slideDown();
                                        $('#dowerySpecify').attr('placeholder', 'Specify asset details').attr('required', true);
                                    } else {
                                        $('#dowerySpecifyWrapper').slideUp();
                                        $('#dowerySpecify').val('').removeAttr('required');
                                    }
                                });
                            });
                        </script>

                    </section>

                    <!-- Step 4: Witnesses -->
                    <section class="form-section" id="section4">
                        <h3 class="section-title">WITNESSES / REFEREES DETAILS NOTE : ALL WITNESS SHOULD BE MALE</h3>
                        <p class="info-text">Please provide details of 2 witnesses who are present at the Nikkah
                            ceremony</p>

                        <!-- Witness 1 -->
                        <h4 class="subsection-title">MALE WITNESS 1 (GROOM'S SIDE)</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness1Surname">Surname<span class="required">*</span></label>
                                <input type="text" id="witness1Surname" name="witness1_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="witness1GivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="witness1GivenName" name="witness1_given_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness1NIN">National Identity Number (NIN)<span
                                        class="required"></span></label>
                                <input type="text" id="witness1NIN" name="witness1_nin">
                            </div>
                            <!-- Witness 1 Telephone -->
                            <div class="form-group">
                                <label for="witness1Phone">Phone Number<span class="required">*</span></label>

                                <div class="input-group phone-input-group">
                                    <!-- Country code dropdown -->
                                    <select id="witness1CountryCode" class="form-control country-code select2">
                                        <option value="">Code</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->calling_code }}">{{ $country->name }}
                                                        (+{{ $country->calling_code }})</option>
                                        @endforeach
                                    </select>

                                    <!-- Phone number input -->
                                    <input type="tel" id="witness1Phone" name="witness1_telephone"
                                        class="form-control phone-number" placeholder="Phone number" required
                                        maxlength="15">
                                </div>
                            </div>

                            <!-- Optional: Initialize Select2 for the country code -->
                            <script>
                                $(document).ready(function () {
                                    $('.country-code').select2({
                                        placeholder: "Code",
                                        width: '100%'
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness1Address">Physical Address<span class="required">*</span></label>
                                <input type="text" id="witness1Address" name="witness1_address" required>
                            </div>
                            <div class="form-group">
                                <label for="witness1District">District<span class="required">*</span></label>
                                <select id="witness1District" name="witness1District" class="district-select select2"
                                    required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <!-- Witness 2 -->
                        <h4 class="subsection-title">MALE WITNESS 2 (BRIDES'S SIDE)</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness2Surname">Surname<span class="required">*</span></label>
                                <input type="text" id="witness2Surname" name="witness2_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="witness2GivenName">Given Name<span class="required">*</span></label>
                                <input type="text" id="witness2GivenName" name="witness2_given_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness2NIN">National Identity Number (NIN)<span
                                        class="required"></span></label>
                                <input type="text" id="witness2NIN" name="witness2_nin">
                            </div>

                            <div class="form-group">
                                <label for="witness1Phone">Phone Number<span class="required">*</span></label>

                                <div class="input-group phone-input-group">
                                    <!-- Country code dropdown -->
                                    <select id="witness2CountryCode" class="form-control country-code select2">
                                        <option value="">Code</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->calling_code }}">{{ $country->name }}
                                                        (+{{ $country->calling_code }})</option>
                                        @endforeach
                                    </select>

                                    <!-- Phone number input -->
                                    <input type="tel" id="witness2Phone" name="witness2_telephone"
                                        class="form-control phone-number" placeholder="Phone number" required
                                        maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness2Address">Physical Address<span class="required">*</span></label>
                                <input type="text" id="witness2Address" name="witness2_address" required>
                            </div>
                            <div class="form-group">
                                <label for="witness2District">District<span class="required">*</span></label>
                                <select id="witness2District" name="witness2District" class="district-select select2"
                                    required>
                                    <option value="">--please select--</option>
                                </select>
                            </div>
                        </div>
                    </section>

                    <!-- Step 5: Photos -->
                    <section class="form-section" id="section5">
                        <h3 class="section-title">PASSPORT PHOTOGRAPHS</h3>
                        <p class="info-text">Please upload passport-size photographs for both bride and groom</p>

                        <div class="photo-upload-container">
                            <div class="photo-upload-box">
                                <h4>Groom's Photograph*</h4>
                                <div class="upload-area" id="groomPhotoArea">
                                    <img id="groomPhotoPreview" class="photo-preview" style="display: none;">
                                    <div class="upload-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        <p>Click to upload or drag and drop</p>
                                        <span>Passport size photo (JPG, PNG)</span>
                                    </div>
                                    <input type="file" id="groomPhoto" name="groomPhoto" accept="image/*" required>
                                </div>
                            </div>

                            <div class="photo-upload-box">
                                <h4>Bride's Photograph*</h4>
                                <div class="upload-area" id="bridePhotoArea">
                                    <img id="bridePhotoPreview" class="photo-preview" style="display: none;">
                                    <div class="upload-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                            <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                            <polyline points="21 15 16 10 5 21"></polyline>
                                        </svg>
                                        <p>Click to upload or drag and drop</p>
                                        <span>Passport size photo (JPG, PNG)</span>
                                    </div>
                                    <input type="file" id="bridePhoto" name="bridePhoto" accept="image/*" required>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Step 6: Review -->
                    <section class="form-section" id="section6">
                        <h3 class="section-title">{{ __('ui.review_title') }}</h3>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.groom') }}</h4>
                                <button type="button"  class="edit-btn"
                                    data-section="1">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewGroom"></div>
                        </div>

                        <!-- Imam Name -->
                        <div class="form-row mt-4" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="imamName" class="d-block">Imam in Charge (Name)</label>
                                    <input type="text" id="imamName" name="imam_name" class="form-control"
                                        placeholder="Imam's Full Name" value="{{ Helper::fullname() }}" disabled
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.bride') }}</h4>
                                <button type="button"  class="edit-btn"
                                    data-section="2">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewBride"></div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.parents') }}</h4>
                                <button type="button"  class="edit-btn"
                                    data-section="3">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewParents"></div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.witnesses') }}</h4>
                                <button type="button"  class="edit-btn"
                                    data-section="4">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewWitnesses"></div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.photos') }}</h4>
                                <button type="button"  class="edit-btn"
                                    data-section="5">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewPhotos"></div>
                        </div>
                    </section>

                    <script>
document.addEventListener("DOMContentLoaded", () => {

    function generateReview() {

        /* ===========================
           Groom Review Section
        ============================ */
        const groomSurname = document.getElementById("groomSurname").value;
        const groomGivenName = document.getElementById("groomGivenName").value;

        document.getElementById("reviewGroom").innerHTML = `
            <p><strong>Surname:</strong> ${groomSurname || "-"}</p>
            <p><strong>Given Name:</strong> ${groomGivenName || "-"}</p>
        `;


        /* ===========================
           Bride Section Example
        ============================ */
        const brideSurname = document.getElementById("brideSurname")?.value;
        const brideGivenName = document.getElementById("brideGivenName")?.value;

        document.getElementById("reviewBride").innerHTML = `
            <p><strong>Surname:</strong> ${brideSurname || "-"}</p>
            <p><strong>Given Name:</strong> ${brideGivenName || "-"}</p>
        `;


        /* ===========================
           Parents Section Example
        ============================ */
        const fatherName = document.getElementById("fatherName")?.value;
        const motherName = document.getElementById("motherName")?.value;

        document.getElementById("reviewParents").innerHTML = `
            <p><strong>Father:</strong> ${fatherName || "-"}</p>
            <p><strong>Mother:</strong> ${motherName || "-"}</p>
        `;


        /* ===========================
           Witnesses Section Example
        ============================ */
        const witness1 = document.getElementById("witness1")?.value;
        const witness2 = document.getElementById("witness2")?.value;

        document.getElementById("reviewWitnesses").innerHTML = `
            <p><strong>Witness 1:</strong> ${witness1 || "-"}</p>
            <p><strong>Witness 2:</strong> ${witness2 || "-"}</p>
        `;
    }


    /* ===========================
       Run Review When Step 6 Opens
    ============================ */
    document.querySelectorAll(".next-btn").forEach(btn => {
        btn.addEventListener("click", () => {

            // If user is going to Step 6
            const activeSection = document.querySelector(".form-section.active");
            if (activeSection && activeSection.id === "section5") {

                // Build Review
                generateReview();
            }
        });
    });


    /* ===========================
       Also Update Review Live
    ============================ */
    document.querySelectorAll("input, select, textarea").forEach(field => {
        field.addEventListener("input", generateReview);
    });

});
</script>


                    <div class="form-navigation"
                        style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="left-buttons">
                            <div style="display: none;">
                                <button type="button" class="btn btn-outline" id="saveExitBtn"
                                    data-i18n="buttons.saveExit" style="display: none;">
                                    Save & Exit
                                </button>
                            </div>

                            <button type="button" class="btn btn-secondary" id="prevBtn" data-i18n="buttons.previous">
                                <i class="fas fa-arrow-left"></i> Previous
                            </button>
                            <button type="button" class="btn btn-primary" id="nextBtn" data-i18n="buttons.next">
                                <i class="fas fa-arrow-right"></i> Next
                            </button>
                            <button type="button" class="btn btn-primary" id="submitBtn" style="display: none;"
                                data-i18n="buttons.submit">
                                <i class="fas fa-paper-plane"></i> Submit Application
                            </button>
                        </div>

                        <a href="{{ url('users/dashboard') }}" class="btn btn-outline backToDashboard"
                            style="text-decoration: none;">
                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                        </a>

                    </div>
                </form>
            </main>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            $('.select2').select2({
                // placeholder: "Select Country",
                allowClear: true,
                width: '100%'
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function bindCountryToLabel(countrySelectId, labelId) {
                const countrySelect = document.getElementById(countrySelectId);
                const labelEl = document.getElementById(labelId);

                if (!countrySelect || !labelEl) return;

                function updateLabel() {
                    const selectedCountry = countrySelect.value;

                    if (selectedCountry === 'UG') {
                        labelEl.innerHTML =
                            'National Identity Number (NIN)<span class="required"></span>';
                    } else if (selectedCountry) {
                        labelEl.innerHTML =
                            'Passport Number<span class="required">*</span>';
                    } else {
                        labelEl.innerHTML =
                            'National Identity Number (NIN)<span class="required"></span>';
                    }
                }

                countrySelect.addEventListener('change', updateLabel);
                $(countrySelect).on('select2:select select2:clear', updateLabel);
                updateLabel();
            }

            bindCountryToLabel('groomCountry', 'ninLabel');
            bindCountryToLabel('brideCountry', 'brideNiNLabel');
        });

        function limitDay(input) {
            input.value = input.value.replace(/\D/g, '');

            if (input.value.length > 2) {
                input.value = input.value.slice(0, 2);
            }

            const value = parseInt(input.value, 10);

            if (value < 1) input.value = '';
            if (value > 31) input.value = '31';
        }
    </script>


    <script>
        document.querySelectorAll('.backToDashboard').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const url = this.href;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Any unsaved changes may be lost.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, continue',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

    <script src="{{ asset('asset/js/script.js') }}"></script>
</body>

</html>