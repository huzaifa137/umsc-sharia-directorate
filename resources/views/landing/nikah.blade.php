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
                                <label for="groomSurname"><span data-i18n="labels.surname">Surname<span
                                        class="required">*</span></span></label>
                                <input type="text" id="groomSurname" name="groom_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="groomGivenName"><span data-i18n="labels.givenName">Given Name<span
                                        class="required">*</span></span></label>
                                <input type="text" id="groomGivenName" name="groom_given_name" required>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label><span data-i18n="labels.dob">Date of Birth (DD/MM/YYYY)</span><span class="required">*</span></label>
                                <div class="date-inputs">
                                    <input type="number" placeholder="Day" data-i18n-placeholder="day_placeholder" min="1" max="31"
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
                                    <input type="number" name="groom_year_date_of_birth" placeholder="Year" data-i18n-placeholder="year_placeholder" min="1900"
                                        max="2010" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><span data-i18n="groom_country_label">Groom Country</span> <span class="required">*</span></label>
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
                                <label for="groomNIN" id="ninLabel" data-i18n-wrap="1"><span data-i18n="groom_nin_label">NIN/Passport No./Refugee ID</span><span class="required"></span></label>
                                <input type="text" name="groomNIN" id="groomNIN" class="form-control">
                            </div>


                            <!-- Groom Telephone -->
                            <div class="form-group">
                                <label for="groomTelephone" data-i18n-wrap="1"><span data-i18n="groom_telephone_label">Telephone Number</span><span class="required">*</span></label>

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
                                        class="form-control phone-number" placeholder="Phone number" data-i18n-placeholder="phone_number_placeholder" required
                                        maxlength="15">
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomEmail"><span data-i18n="labels.email">Email Address</span></label>
                                <input type="email" id="groomEmail" name="groom_email">
                            </div>
                            <div class="form-group">
                                <label for="groomTribe"><span data-i18n="labels.tribe">Tribe<span
                                        class="required">*</span></span></label>
                                <select class="select2" id="groomTribe" name="groom_tribe">
                                    <option value="" data-i18n="please_select_option">--please select--</option>
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
                                    <label for="newTribe" data-i18n-wrap="1"><span data-i18n="new_tribe_label">Or add a new tribe</span></label><br>
                                    <input type="text" id="newTribe" placeholder="Type your tribe here" data-i18n-placeholder="type_tribe_placeholder"
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
                                <label for="groomDistrict"><span data-i18n="labels.district">District<span
                                        class="required">*</span></span></label>
                                <select id="groomDistrict" name="groom_district" class="district-select" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomCounty"><span data-i18n="labels.county">County/Municipality<span
                                        class="required">*</span></span></label>
                                <select id="groomCounty" name="groom_county" class="county-select" required disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomSubCounty"><span data-i18n="labels.subCounty">Sub County<span
                                        class="required">*</span></span></label>
                                <select id="groomSubCounty" name="groom_sub_county" class="subcounty-select" required
                                    disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomParish"><span data-i18n="labels.parish">Parish/Ward<span
                                        class="required">*</span></span></label>
                                <select id="groomParish" name="groom_parish" class="parish-select" required disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomVillage"><span data-i18n="labels.village">Village (LC1/Zone)<span
                                        class="required">*</span></span></label>
                                <select id="groomVillage" name="groom_village" class="village-select" required disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomPlot"><span data-i18n="labels.plot">Plot Number</span></label>
                                <input type="text" id="groomPlot" name="groom_plot">
                            </div>
                        </div>
                    </section>

                    <!-- Step 2: Bride Details -->
                    <section class="form-section" id="section2">
                        <h3 class="section-title" data-i18n="bride.title">BRIDE'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideSurname" data-i18n-wrap="1"><span data-i18n="bride_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="brideSurname" name="bride_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="brideGivenName" data-i18n-wrap="1"><span data-i18n="bride_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="brideGivenName" name="bride_given_name" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><span data-i18n="labels.dob">Date of Birth (DD/MM/YYYY)</span><span class="required">*</span></label>
                                <div class="date-inputs">
                                    <input type="number" placeholder="Day" data-i18n-placeholder="day_placeholder" min="1" max="31"
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
                                    <input type="number" name="bride_year_date_of_birth" placeholder="Year" data-i18n-placeholder="year_placeholder" min="1900"
                                        max="2010" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><span data-i18n="bride_country_label">Bride Country</span> <span class="required">*</span></label>
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
                                <label for="brideNIN" id="brideNiNLabel" data-i18n-wrap="1"><span data-i18n="bride_nin_label">NIN/Passport No./Refugee ID</span><span class="required"></span></label>
                                <input type="text" id="brideNIN" name="brideNIN">
                            </div>

                            <!-- Bride Telephone -->
                            <div class="form-group">
                                <label for="brideTelephone" data-i18n-wrap="1"><span data-i18n="bride_telephone_label">Telephone Number</span><span class="required">*</span></label>

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
                                        class="form-control phone-number" placeholder="Phone number" data-i18n-placeholder="phone_number_placeholder" required
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
                                <label for="brideEmail" data-i18n-wrap="1"><span data-i18n="bride_email_label">Email Address</span></label>
                                <input type="email" id="brideEmail" name="bride_email">
                            </div>

                            <div class="form-group">
                                <label for="brideTribe" data-i18n-wrap="1"><span data-i18n="bride_tribe_label">Tribe</span><span class="required">*</span></label>
                                <select id="brideTribe" class="select2" name="bride_tribe">
                                    <option value="" data-i18n="please_select_option">--please select--</option>
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
                                    <label for="newBrideTribe" data-i18n-wrap="1"><span data-i18n="new_bride_tribe_label">Or add a new tribe</span></label><br>
                                    <input type="text" id="newBrideTribe" placeholder="Type your tribe here" data-i18n-placeholder="type_tribe_placeholder"
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
                                <label for="brideDistrict" data-i18n-wrap="1"><span data-i18n="bride_district_label">District</span><span class="required">*</span></label>
                                <select id="brideDistrict" name="bride_district" class="district-select" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideCounty" data-i18n-wrap="1"><span data-i18n="bride_county_label">County/Municipality</span><span class="required">*</span></label>
                                <select id="brideCounty" name="bride_county" class="county-select" required disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideSubCounty" data-i18n-wrap="1"><span data-i18n="bride_sub_county_label">Sub County</span><span class="required">*</span></label>
                                <select id="brideSubCounty" name="bride_sub_county" class="subcounty-select" required
                                    disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideParish" data-i18n-wrap="1"><span data-i18n="bride_parish_label">Parish/Ward</span><span class="required">*</span></label>
                                <select id="brideParish" name="bride_parish" class="parish-select" required disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideVillage" data-i18n-wrap="1"><span data-i18n="bride_village_label">Village (LC1/Zone)</span><span class="required">*</span></label>
                                <select id="brideVillage" name="bride_village" class="village-select" required disabled>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bridePlot" data-i18n-wrap="1"><span data-i18n="bride_plot_label">Plot Number</span></label>
                                <input type="text" id="bridePlot" name="bride_plot">
                            </div>
                        </div>
                    </section>

                    <!-- Step 3: Parents Details -->
                    <section class="form-section" id="section3">
                        <h3 class="section-title">GROOM'S FATHER'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomFatherStatus" data-i18n-wrap="1"><span data-i18n="groom_father_status_label">Status</span><span class="required">*</span></label>
                                <select id="groomFatherStatus" name="groomFatherStatus" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomFatherSurname" data-i18n-wrap="1"><span data-i18n="groom_father_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="groomFatherSurname" name="groom_father_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomFatherGivenName" data-i18n-wrap="1"><span data-i18n="groom_father_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="groomFatherGivenName" name="groom_father_given_name" required>
                            </div>
                            <div class="form-group">
                                <label for="groomFatherNIN" data-i18n-wrap="1"><span data-i18n="groom_father_nin_label">NIN/Passport No./Refugee ID</span><span class="required">*</span></label>
                                <input type="text" id="groomFatherNIN" name="groom_father_nin" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomFatherDistrict" data-i18n-wrap="1"><span data-i18n="groom_father_district_label">District of Residence</span><span class="required">*</span></label>
                                <select id="groomFatherDistrict" name="groomFatherDistrict"
                                    class="district-select select2" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomFatherTribe" data-i18n-wrap="1"><span data-i18n="groom_father_tribe_label">Tribe</span><span class="required">*</span></label>
                                <select id="groomFatherTribe" name="groomFatherTribe" class="select2" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
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
                                    <label for="newGroomFatherTribe" data-i18n-wrap="1"><span data-i18n="new_groom_father_tribe_label">Or add a new tribe</span></label><br>
                                    <input type="text" id="newGroomFatherTribe" placeholder="Type your tribe here" data-i18n-placeholder="type_tribe_placeholder"
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
                                <label for="groomMotherStatus" data-i18n-wrap="1"><span data-i18n="groom_mother_status_label">Status</span><span class="required">*</span></label>
                                <select id="groomMotherStatus" name="groomMotherStatus" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="groomMotherSurname" data-i18n-wrap="1"><span data-i18n="groom_mother_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="groomMotherSurname" name="groom_mother_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomMotherGivenName" data-i18n-wrap="1"><span data-i18n="groom_mother_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="groomMotherGivenName" name="groom_mother_given_name" required>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="groomMotherMaidenName" data-i18n-wrap="1"><span data-i18n="groom_mother_maiden_name_label">Maiden Name</span><span class="text-muted">(Optional)</span></label>
                                <input type="text" id="groomMotherMaidenName" name="groomMotherMaidenName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="groomMotherNIN" data-i18n-wrap="1"><span data-i18n="groom_mother_nin_label">NIN/Passport No./Refugee ID</span><span class="required">*</span></label>
                                <input type="text" id="groomMotherNIN" name="groomMotherNIN" required>
                            </div>
                            <div class="form-group">
                                <label for="groomMotherDistrict" data-i18n-wrap="1"><span data-i18n="groom_mother_district_label">District of Residence</span><span class="required">*</span></label>
                                <select id="groomMotherDistrict" name="groomMotherDistrict"
                                    class="district-select select2" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="section-title" style="margin-top: 30px;">BRIDE'S FATHER'S DETAILS</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideFatherStatus" data-i18n-wrap="1"><span data-i18n="bride_father_status_label">Status</span><span class="required">*</span></label>
                                <select id="brideFatherStatus" name="brideFatherStatus" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideFatherSurname" data-i18n-wrap="1"><span data-i18n="bride_father_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="brideFatherSurname" name="bride_father_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideFatherGivenName" data-i18n-wrap="1"><span data-i18n="bride_father_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="brideFatherGivenName" name="bride_father_given_name" required>
                            </div>
                            <div class="form-group">
                                <label for="brideFatherNIN" data-i18n-wrap="1"><span data-i18n="bride_father_nin_label">NIN/Passport No./Refugee ID</span><span class="required">*</span></label>
                                <input type="text" id="brideFatherNIN" name="brideFatherNIN" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideFatherDistrict" data-i18n-wrap="1"><span data-i18n="bride_father_district_label">District of Residence</span><span class="required">*</span></label>
                                <select id="brideFatherDistrict" name="brideFatherDistrict"
                                    class="district-select select2" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideFatherTribe" data-i18n-wrap="1"><span data-i18n="bride_father_tribe_label">Tribe</span><span class="required">*</span></label>
                                <select id="brideFatherTribe" class="select2" name="brideFatherTribe" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
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
                                    <label for="newBrideFatherTribe" data-i18n-wrap="1"><span data-i18n="new_bride_father_tribe_label">Or add a new tribe</span></label><br>
                                    <input type="text" id="newBrideFatherTribe" placeholder="Type your tribe here" data-i18n-placeholder="type_tribe_placeholder"
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
                                <label for="brideMotherStatus" data-i18n-wrap="1"><span data-i18n="bride_mother_status_label">Status</span><span class="required">*</span></label>
                                <select id="brideMotherStatus" name="brideMotherStatus" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                    <option value="Alive">Alive</option>
                                    <option value="Deceased">Deceased</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="brideMotherSurname" data-i18n-wrap="1"><span data-i18n="bride_mother_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="brideMotherSurname" name="bride_mother_surname" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideMotherGivenName" data-i18n-wrap="1"><span data-i18n="bride_mother_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="brideMotherGivenName" name="bride_mother_given_name" required>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="brideMotherMaidenName" data-i18n-wrap="1"><span data-i18n="bride_mother_maiden_name_label">Maiden Name</span><span class="text-muted">(Optional)</span></label>
                                <input type="text" id="brideMotherMaidenName" name="brideMotherMaidenName">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brideMotherNIN" data-i18n-wrap="1"><span data-i18n="bride_mother_nin_label">NIN/Passport No./Refugee ID</span><span class="required">*</span></label>
                                <input type="text" id="brideMotherNIN" name="brideMotherNIN" required>
                            </div>
                            <div class="form-group">
                                <label for="brideMotherDistrict" data-i18n-wrap="1"><span data-i18n="bride_mother_district_label">District of Residence</span><span class="required">*</span></label>
                                <select id="brideMotherDistrict" name="brideMotherDistrict"
                                    class="district-select select2" required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <h3 class="section-title" style="margin-top: 30px;">DOWERY DETAILS</h3>

                        <!-- Dowery Type & Specify -->
                        <div class="form-row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="doweryType" class="d-block" data-i18n-wrap="1"><span data-i18n="dowery_type_label">Dowery Type</span><span class="required">*</span></label>
                                    <select id="doweryType" name="dowery_type" class="form-control" required>
                                        <option value="">-- Select Dowery Type --</option>
                                        <option value="cash">Cash</option>
                                        <option value="asset">Asset</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dowery_specify" id="dowery_specify_label" class="d-block" data-i18n-wrap="1"><span data-i18n="dowery_specify_label">Specify</span></label>
                                    <input type="text" name="dowery_specify" id="dowery_specify" class="form-control"
                                        placeholder="Select a Dowery Type first" data-i18n-placeholder="select_dowery_type_first_placeholder">
                                </div>
                            </div>
                        </div>

                        <!-- Imam Name & Masjid Name -->
                        <div class="form-row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imam_name" class="d-block" data-i18n-wrap="1"><span data-i18n="imam_name_label">Imam Name</span></label>
                                    <input type="text" name="imam_name" id="imam_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="masjid_name" class="d-block" data-i18n-wrap="1"><span data-i18n="masjid_name_label">Masjid Name</span></label>
                                    <input type="text" name="masjid_name" id="masjid_name" class="form-control">
                                </div>
                            </div>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const doweryType = document.getElementById('doweryType');
                            const specifyInput = document.getElementById('dowery_specify');
                            const specifyLabel = document.getElementById('dowery_specify_label');

                            doweryType.addEventListener('change', function () {
                                if (this.value === 'cash') {
                                    specifyLabel.textContent = 'Specify';
                                    specifyInput.placeholder = 'Enter cash amount';
                                    specifyInput.type = 'number';
                                } else if (this.value === 'asset') {
                                    specifyLabel.textContent = 'Specify';
                                    specifyInput.placeholder = 'Specify asset details';
                                    specifyInput.type = 'text';
                                } else {
                                    specifyInput.placeholder = 'Select a Dowery Type first';
                                    specifyInput.type = 'text';
                                }
                                specifyInput.value = '';
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
                                <label for="witness1Surname" data-i18n-wrap="1"><span data-i18n="witness1_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="witness1Surname" name="witness1_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="witness1GivenName" data-i18n-wrap="1"><span data-i18n="witness1_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="witness1GivenName" name="witness1_given_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness1NIN" data-i18n-wrap="1"><span data-i18n="witness1_nin_label">NIN/Passport No./Refugee ID</span><span class="required">*</span></label>
                                <input type="text" id="witness1NIN" name="witness1_nin" required>
                            </div>
                            <!-- Witness 1 Telephone -->
                            <div class="form-group">
                                <label for="witness1Phone" data-i18n-wrap="1"><span data-i18n="witness1_phone_label">Phone Number</span><span class="required">*</span></label>

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
                                        class="form-control phone-number" placeholder="Phone number" data-i18n-placeholder="phone_number_placeholder" required
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
                                <label for="witness1Address" data-i18n-wrap="1"><span data-i18n="witness1_address_label">Physical Address</span><span class="required">*</span></label>
                                <input type="text" id="witness1Address" name="witness1_address" required>
                            </div>
                            <div class="form-group">
                                <label for="witness1District" data-i18n-wrap="1"><span data-i18n="witness1_district_label">District</span><span class="required">*</span></label>
                                <select id="witness1District" name="witness1District" class="district-select select2"
                                    required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
                                </select>
                            </div>
                        </div>

                        <!-- Witness 2 -->
                        <h4 class="subsection-title">MALE WITNESS 2 (BRIDES'S SIDE)</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness2Surname" data-i18n-wrap="1"><span data-i18n="witness2_surname_label">Surname</span><span class="required">*</span></label>
                                <input type="text" id="witness2Surname" name="witness2_surname" required>
                            </div>
                            <div class="form-group">
                                <label for="witness2GivenName" data-i18n-wrap="1"><span data-i18n="witness2_given_name_label">Given Name</span><span class="required">*</span></label>
                                <input type="text" id="witness2GivenName" name="witness2_given_name" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness2NIN" data-i18n-wrap="1"><span data-i18n="witness2_nin_label">NIN/Passport No./Refugee ID</span><span class="required">*</span></label>
                                <input type="text" id="witness2NIN" name="witness2_nin" required>
                            </div>

                            <div class="form-group">
                                <label for="witness2Phone" data-i18n-wrap="1"><span data-i18n="witness2_phone_label">Phone Number</span><span class="required">*</span></label>

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
                                        class="form-control phone-number" placeholder="Phone number" data-i18n-placeholder="phone_number_placeholder" required
                                        maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="witness2Address" data-i18n-wrap="1"><span data-i18n="witness2_address_label">Physical Address</span><span class="required">*</span></label>
                                <input type="text" id="witness2Address" name="witness2_address" required>
                            </div>
                            <div class="form-group">
                                <label for="witness2District" data-i18n-wrap="1"><span data-i18n="witness2_district_label">District</span><span class="required">*</span></label>
                                <select id="witness2District" name="witness2District" class="district-select select2"
                                    required>
                                    <option value="" data-i18n="please_select_option">--please select--</option>
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
                                <button type="button" class="edit-btn"
                                    data-section="1">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewGroom"></div>
                        </div>

                        <!-- Imam Name -->
                        <div class="form-row mt-4" style="display: none;">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="imamName" class="d-block" data-i18n-wrap="1"><span data-i18n="imam_name_label">Imam in Charge (Name)</span></label>
                                    <input type="text" id="imamName" name="imam_name" class="form-control"
                                        placeholder="Imam's Full Name" data-i18n-placeholder="imam_full_name_placeholder" value="{{ Helper::fullname() }}" disabled
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.bride') }}</h4>
                                <button type="button" class="edit-btn"
                                    data-section="2">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewBride"></div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.parents') }}</h4>
                                <button type="button" class="edit-btn"
                                    data-section="3">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewParents"></div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.witnesses') }}</h4>
                                <button type="button" class="edit-btn"
                                    data-section="4">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewWitnesses"></div>
                        </div>

                        <div class="review-section">
                            <div class="review-header">
                                <h4>{{ __('ui.review_section.photos') }}</h4>
                                <button type="button" class="edit-btn"
                                    data-section="5">{{ __('ui.buttons.edit') }}</button>
                            </div>
                            <div class="review-content" id="reviewPhotos"></div>
                        </div>
                    </section>

                <script>
document.addEventListener("DOMContentLoaded", () => {

    function getSelectText(id) {
        const el = document.getElementById(id);
        return el && el.value
            ? el.options[el.selectedIndex].text
            : "-";
    }

    function getInputValue(id) {
        const el = document.getElementById(id);
        return el && el.value.trim() !== "" ? el.value : "-";
    }

    function getFileName(id) {
        const el = document.getElementById(id);
        return el && el.files.length > 0
            ? el.files[0].name
            : "No file uploaded";
    }

    function generateReview() {

          /* ===========================
           ✅ Groom Review Section
        ============================ */
        const groomSurname = getInputValue("groomSurname");
        const groomGivenName = getInputValue("groomGivenName");

        const dobDay   = document.querySelector("[name='groom_day_date_of_birth']")?.value || "";
        const dobMonth = document.querySelector("[name='groom_month_date_of_birth']")?.value || "";
        const dobYear  = document.querySelector("[name='groom_year_date_of_birth']")?.value || "";

        const groomDOB = (dobDay && dobMonth && dobYear)
            ? `${dobDay}/${dobMonth}/${dobYear}`
            : "-";

        const groomCountry = getSelectText("groomCountry");
        const groomNIN = getInputValue("groomNIN");

        const groomCode = getSelectText("groomCountryCode");
        const groomPhone = getInputValue("groomTelephone");

        const groomTelephone = (groomPhone !== "-")
            ? `${groomCode} ${groomPhone}`
            : "-";

        const groomEmail = getInputValue("groomEmail");

        let groomTribe = getSelectText("groomTribe");
        const newTribe = document.getElementById("newTribe")?.value.trim();
        if (newTribe) groomTribe = newTribe;

        const groomDistrict  = getSelectText("groomDistrict");
        const groomCounty    = getSelectText("groomCounty");
        const groomSubCounty = getSelectText("groomSubCounty");
        const groomParish    = getSelectText("groomParish");
        const groomVillage   = getSelectText("groomVillage");
        const groomPlot      = getInputValue("groomPlot");

        document.getElementById("reviewGroom").innerHTML = `
            <div class="review-grid">
                <p><strong>Surname:</strong> ${groomSurname}</p>
                <p><strong>Given Name:</strong> ${groomGivenName}</p>

                <p><strong>Date of Birth:</strong> ${groomDOB}</p>
                <p><strong>Country:</strong> ${groomCountry}</p>

                <p><strong>NIN:</strong> ${groomNIN}</p>
                <p><strong>Telephone:</strong> ${groomTelephone}</p>

                <p><strong>Email:</strong> ${groomEmail}</p>
                <p><strong>Tribe:</strong> ${groomTribe}</p>

                <hr style="grid-column: 1/-1; margin:10px 0;">

                <p><strong>District:</strong> ${groomDistrict}</p>
                <p><strong>County:</strong> ${groomCounty}</p>

                <p><strong>Sub County:</strong> ${groomSubCounty}</p>
                <p><strong>Parish:</strong> ${groomParish}</p>

                <p><strong>Village:</strong> ${groomVillage}</p>
                <p><strong>Plot Number:</strong> ${groomPlot}</p>
            </div>
        `;


        /* ===========================
           ✅ Bride Review Section
        ============================ */
        const brideSurname = getInputValue("brideSurname");
        const brideGivenName = getInputValue("brideGivenName");

        const brideDobDay   = document.querySelector("[name='bride_day_date_of_birth']")?.value || "";
        const brideDobMonth = document.querySelector("[name='bride_month_date_of_birth']")?.value || "";
        const brideDobYear  = document.querySelector("[name='bride_year_date_of_birth']")?.value || "";

        const brideDOB = (brideDobDay && brideDobMonth && brideDobYear)
            ? `${brideDobDay}/${brideDobMonth}/${brideDobYear}`
            : "-";

        const brideCountry = getSelectText("brideCountry");
        const brideNIN = getInputValue("brideNIN");

        const brideCode = getSelectText("brideCountryCode");
        const bridePhone = getInputValue("brideTelephone");

        const brideTelephone = (bridePhone !== "-")
            ? `${brideCode} ${bridePhone}`
            : "-";

        const brideEmail = getInputValue("brideEmail");

        let brideTribe = getSelectText("brideTribe");
        const newBrideTribe = document.getElementById("newBrideTribe")?.value.trim();
        if (newBrideTribe) brideTribe = newBrideTribe;

        const brideDistrict  = getSelectText("brideDistrict");
        const brideCounty    = getSelectText("brideCounty");
        const brideSubCounty = getSelectText("brideSubCounty");
        const brideParish    = getSelectText("brideParish");
        const brideVillage   = getSelectText("brideVillage");
        const bridePlot      = getInputValue("bridePlot");

        document.getElementById("reviewBride").innerHTML = `
            <div class="review-grid">
                <p><strong>Surname:</strong> ${brideSurname}</p>
                <p><strong>Given Name:</strong> ${brideGivenName}</p>

                <p><strong>Date of Birth:</strong> ${brideDOB}</p>
                <p><strong>Country:</strong> ${brideCountry}</p>

                <p><strong>NIN:</strong> ${brideNIN}</p>
                <p><strong>Telephone:</strong> ${brideTelephone}</p>

                <p><strong>Email:</strong> ${brideEmail}</p>
                <p><strong>Tribe:</strong> ${brideTribe}</p>

                <hr style="grid-column: 1/-1; margin:10px 0;">

                <p><strong>District:</strong> ${brideDistrict}</p>
                <p><strong>County:</strong> ${brideCounty}</p>

                <p><strong>Sub County:</strong> ${brideSubCounty}</p>
                <p><strong>Parish:</strong> ${brideParish}</p>

                <p><strong>Village:</strong> ${brideVillage}</p>
                <p><strong>Plot Number:</strong> ${bridePlot}</p>
            </div>
        `;
        /* ===========================
           ✅ STEP 3: Parents Review
        ============================ */

        // Groom Father
        const groomFatherStatus   = getSelectText("groomFatherStatus");
        const groomFatherSurname  = getInputValue("groomFatherSurname");
        const groomFatherGiven    = getInputValue("groomFatherGivenName");
        const groomFatherNIN      = getInputValue("groomFatherNIN");
        const groomFatherDistrict = getSelectText("groomFatherDistrict");

        let groomFatherTribe = getSelectText("groomFatherTribe");
        const newGroomFatherTribe =
            document.getElementById("newGroomFatherTribe")?.value.trim();
        if (newGroomFatherTribe) groomFatherTribe = newGroomFatherTribe;

        // Groom Mother
        const groomMotherStatus   = getSelectText("groomMotherStatus");
        const groomMotherSurname  = getInputValue("groomMotherSurname");
        const groomMotherGiven    = getInputValue("groomMotherGivenName");
        const groomMotherNIN      = getInputValue("groomMotherNIN");
        const groomMotherDistrict = getSelectText("groomMotherDistrict");

        // Bride Father
        const brideFatherStatus   = getSelectText("brideFatherStatus");
        const brideFatherSurname  = getInputValue("brideFatherSurname");
        const brideFatherGiven    = getInputValue("brideFatherGivenName");
        const brideFatherNIN      = getInputValue("brideFatherNIN");
        const brideFatherDistrict = getSelectText("brideFatherDistrict");

        let brideFatherTribe = getSelectText("brideFatherTribe");
        const newBrideFatherTribe =
            document.getElementById("newBrideFatherTribe")?.value.trim();
        if (newBrideFatherTribe) brideFatherTribe = newBrideFatherTribe;

        // Bride Mother
        const brideMotherStatus   = getSelectText("brideMotherStatus");
        const brideMotherSurname  = getInputValue("brideMotherSurname");
        const brideMotherGiven    = getInputValue("brideMotherGivenName");
        const brideMotherNIN      = getInputValue("brideMotherNIN");
        const brideMotherDistrict = getSelectText("brideMotherDistrict");

        document.getElementById("reviewParents").innerHTML = `
            <div class="review-grid">

                <h4 style="grid-column:1/-1;">👨 Groom's Father</h4>
                <p><strong>Status:</strong> ${groomFatherStatus}</p>
                <p><strong>Surname:</strong> ${groomFatherSurname}</p>
                <p><strong>Given Name:</strong> ${groomFatherGiven}</p>
                <p><strong>NIN:</strong> ${groomFatherNIN}</p>
                <p><strong>District:</strong> ${groomFatherDistrict}</p>
                <p><strong>Tribe:</strong> ${groomFatherTribe}</p>

                <hr style="grid-column:1/-1;">

                <h4 style="grid-column:1/-1;">👩 Groom's Mother</h4>
                <p><strong>Status:</strong> ${groomMotherStatus}</p>
                <p><strong>Surname:</strong> ${groomMotherSurname}</p>
                <p><strong>Given Name:</strong> ${groomMotherGiven}</p>
                <p><strong>NIN:</strong> ${groomMotherNIN}</p>
                <p><strong>District:</strong> ${groomMotherDistrict}</p>

                <hr style="grid-column:1/-1;">

                <h4 style="grid-column:1/-1;">👨 Bride's Father</h4>
                <p><strong>Status:</strong> ${brideFatherStatus}</p>
                <p><strong>Surname:</strong> ${brideFatherSurname}</p>
                <p><strong>Given Name:</strong> ${brideFatherGiven}</p>
                <p><strong>NIN:</strong> ${brideFatherNIN}</p>
                <p><strong>District:</strong> ${brideFatherDistrict}</p>
                <p><strong>Tribe:</strong> ${brideFatherTribe}</p>

                <hr style="grid-column:1/-1;">

                <h4 style="grid-column:1/-1;">👩 Bride's Mother</h4>
                <p><strong>Status:</strong> ${brideMotherStatus}</p>
                <p><strong>Surname:</strong> ${brideMotherSurname}</p>
                <p><strong>Given Name:</strong> ${brideMotherGiven}</p>
                <p><strong>NIN:</strong> ${brideMotherNIN}</p>
                <p><strong>District:</strong> ${brideMotherDistrict}</p>

            </div>
        `;


        /* ===========================
           ✅ STEP 4: Witnesses Review
        ============================ */

        // Witness 1
        const w1Surname  = getInputValue("witness1Surname");
        const w1Given    = getInputValue("witness1GivenName");
        const w1NIN      = getInputValue("witness1NIN");

        const w1Code     = getSelectText("witness1CountryCode");
        const w1Phone    = getInputValue("witness1Phone");
        const w1Tel      = (w1Phone !== "-") ? `${w1Code} ${w1Phone}` : "-";

        const w1Address  = getInputValue("witness1Address");
        const w1District = getSelectText("witness1District");


        // Witness 2
        const w2Surname  = getInputValue("witness2Surname");
        const w2Given    = getInputValue("witness2GivenName");
        const w2NIN      = getInputValue("witness2NIN");

        const w2Code     = getSelectText("witness2CountryCode");
        const w2Phone    = getInputValue("witness2Phone");
        const w2Tel      = (w2Phone !== "-") ? `${w2Code} ${w2Phone}` : "-";

        const w2Address  = getInputValue("witness2Address");
        const w2District = getSelectText("witness2District");


        document.getElementById("reviewWitnesses").innerHTML = `
            <div class="review-grid">

                <h4 style="grid-column:1/-1;">👤 Witness 1 (Groom Side)</h4>
                <p><strong>Surname:</strong> ${w1Surname}</p>
                <p><strong>Given Name:</strong> ${w1Given}</p>
                <p><strong>NIN:</strong> ${w1NIN}</p>
                <p><strong>Telephone:</strong> ${w1Tel}</p>
                <p><strong>Address:</strong> ${w1Address}</p>
                <p><strong>District:</strong> ${w1District}</p>

                <hr style="grid-column:1/-1;">

                <h4 style="grid-column:1/-1;">👤 Witness 2 (Bride Side)</h4>
                <p><strong>Surname:</strong> ${w2Surname}</p>
                <p><strong>Given Name:</strong> ${w2Given}</p>
                <p><strong>NIN:</strong> ${w2NIN}</p>
                <p><strong>Telephone:</strong> ${w2Tel}</p>
                <p><strong>Address:</strong> ${w2Address}</p>
                <p><strong>District:</strong> ${w2District}</p>

            </div>
        `;


        /* ===========================
           ✅ STEP 5: Photos Review
        ============================ */

        const groomPhoto = getFileName("groomPhoto");
        const bridePhoto = getFileName("bridePhoto");

        document.getElementById("reviewPhotos").innerHTML = `
            <div class="review-grid">
                <p><strong>Groom Photo:</strong> ${groomPhoto}</p>
                <p><strong>Bride Photo:</strong> ${bridePhoto}</p>
            </div>
        `;
    }


    /* ===========================
       Run Review When Step 6 Opens
    ============================ */
    document.querySelectorAll(".next-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const activeSection =
                document.querySelector(".form-section.active");

            if (activeSection && activeSection.id === "section5") {
                generateReview();
            }
        });
    });


    /* ===========================
       Live Update While Typing
    ============================ */
    document.querySelectorAll("input, select, textarea").forEach(field => {
        field.addEventListener("input", generateReview);
        field.addEventListener("change", generateReview);
    });

});
</script>

                    <style>
                        .review-grid {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                            gap: 10px;
                        }

                        .review-grid p {
                            background: #f9f9f9;
                            padding: 8px 12px;
                            border-radius: 8px;
                            font-size: 14px;
                        }
                    </style>



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