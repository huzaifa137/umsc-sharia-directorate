<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Assalamu Alaikum. In our beautiful Ugandan Muslim community, marriage is a sacred covenant. Our digital Nikah system bridges tradition with technology, providing a seamless, Sharia-compliant process for couples ready to embark on their marital journey. From initial registration to official documentation, we guide you every step of the way.">
    <meta name="author" content="Uganda Moslem Supreme Council (UMSC)">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>UMSC</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('asset/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/templatemo-edu-meeting.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/lightbox.css') }}">

    <style>
        /* Fix for mobile navbar spacing issue */
        .header-area {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            z-index: 999 !important;
            transition: all 0.3s ease !important;
        }

        /* Default logo size (Desktop) */
        #logo {
            width: 100px;
            height: auto;
            transition: width 0.3s ease;
        }

        /* Mobile: Always show smaller logo */
        @media screen and (max-width: 767px) {
            #logo {
                width: 50px !important;
                height: auto;
            }

            /* Remove any top spacing on mobile */
            .header-area {
                background-color: #fff !important;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                padding: 10px 0 !important;
            }

            /* Adjust main banner for fixed header on mobile */
            .section.main-banner {
                padding-top: 70px !important;
            }

            /* Hide sub-header on mobile */
            .sub-header {
                display: none;
            }
        }

        /* Desktop: Change logo size when scrolled */
        @media screen and (min-width: 768px) {
            .header-area.scrolled #logo {
                width: 70px !important;
            }

            .header-area:not(.scrolled) #logo {
                width: 100px !important;
            }
        }

        /* Make header sticky on desktop but fixed on mobile */
        @media screen and (min-width: 768px) {
            .header-area {
                position: sticky !important;
                top: 0 !important;
            }
        }

        /* Ensure sub-header doesn't push content down on mobile */
        @media screen and (max-width: 767px) {
            body {
                padding-top: 0 !important;
            }
        }

        /* Scroll to top button styling */
        #scrollBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background-color: #dc3545 !important;
            border: none;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white !important;
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        #scrollBtn:hover {
            background-color: #c82333 !important;
            transform: translateY(-3px);
        }
    </style>
</head>

<body>
    <!-- Sub Header -->
    <div class="sub-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-sm-8">
                    <div class="left-content">
                        <p>UMSC ISLAMIC MARRIAGE. <em>Purify your Marriage</em> Officialize your Marriage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ***** Header Area Start ***** -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <!-- ***** Logo Start ***** -->
                        <a href="{{ url('/') }}" class="logo">
                            <img id="logo" src="{{ asset('asset/images/logo.png') }}" alt="Noorain Islamic Academy"
                                style="width: 100px; height: auto;">
                        </a>

                        <script>
                            // Get the header and logo elements
                            const header = document.querySelector('.header-area');
                            const logo = document.getElementById('logo');

                            // Listen for scroll events
                            window.addEventListener('scroll', function() {
                                // Only apply scrolled class on desktop ( > 767px)
                                if (window.innerWidth > 767) {
                                    if (window.scrollY > 50) {
                                        header.classList.add('scrolled');
                                    } else {
                                        header.classList.remove('scrolled');
                                    }
                                }
                                // On mobile, always keep header with white background
                            });

                            // Also handle resize events
                            window.addEventListener('resize', function() {
                                if (window.innerWidth <= 767) {
                                    // On mobile, remove scrolled class
                                    header.classList.remove('scrolled');
                                } else if (window.scrollY > 50) {
                                    // On desktop, if scrolled, add scrolled class
                                    header.classList.add('scrolled');
                                } else {
                                    header.classList.remove('scrolled');
                                }
                            });

                            // Initialize on page load
                            if (window.innerWidth <= 767) {
                                header.classList.remove('scrolled');
                            } else if (window.scrollY > 50) {
                                header.classList.add('scrolled');
                            }
                        </script>

                        <!-- ***** Logo End ***** -->
                        <!-- ***** Menu Start ***** -->
                        <ul class="nav">
                            <li class="scroll-to-section">
                                <a href="#top" class="active">
                                    <span style="color: black;">Home</span>
                                </a>
                            </li>

                            <li class="scroll-to-section">
                                <a href="#contact">
                                    <span style="color: black;">Contact Us</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ url('users/login') }}" class="login-btn"
                                    style="border: 2px solid #4CAF50; color: #4CAF50 !important; padding: 6px 18px; border-radius: 5px; font-weight: 600; text-decoration: none; margin-left: 15px; display: inline-flex; align-items: center; justify-content: center; height: 40px;">
                                    {{ __('ui.nav.login') }}
                                </a>
                            </li>
                        </ul>

                        <a class='menu-trigger'>
                            <span>Menu</span>
                        </a>
                        <!-- ***** Menu End ***** -->
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <section class="section main-banner" id="top" data-section="section1">
        <video autoplay muted loop id="bg-video">
            <source src="{{ asset('asset/images/course-video.mp4') }}" type="video/mp4" />
        </video>

        <div class="video-overlay header-text">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="caption">
                            <h6>🕌 Islamic Marriage Certificate</h6>
                            <h2>DIRECTORATE OF SHARIAH</h2>
                            <div class="main-button-red">
                                <div class="scroll-to-section"><a
                                        href="#apply">{{ __('ui.landing.register_now') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Main Banner Area End ***** -->

    <section class="services">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-service-item owl-carousel">
                        <!-- Item 1 -->
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets/images/service-icon-01.png') }}" alt="">
                            </div>
                            <div class="down-content">
                                <h4>Honoring Ugandan Traditions</h4>
                                <p>We respect Uganda's Muslim traditions, from Kampala to Arua, ensuring all marriages
                                    meet Islamic requirements.</p>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets/images/service-icon-02.png') }}" alt="">
                            </div>
                            <div class="down-content">
                                <h4>Supporting Islamic Leaders</h4>
                                <p>We help Imams and Sheikhs across Uganda by managing paperwork and ensuring
                                    Sharia-compliance.</p>
                            </div>
                        </div>

                        <!-- Item 3 -->
                        <div class="item">
                            <div class="icon">
                                <img src="{{ asset('assets/images/service-icon-03.png') }}" alt="">
                            </div>
                            <div class="down-content">
                                <h4>Your Trusted Nikah Platform</h4>
                                <p>Our digital Nikah system makes the marriage process easy and Sharia-compliant for
                                    couples across Uganda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="upcoming-meetings" style="padding-top: 8rem;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>How Our Nikah System Works</h2>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="nikah-timeline-container">
                        <h4 class="text-center mb-5 fw-bold text-white">Registration Journey</h4>

                        <div class="timeline-item">
                            <div class="timeline-marker">1</div>
                            <div class="timeline-content">
                                <h5 class="fw-bold">Create Account</h5>
                                <p>Register with your basic information to get started.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker">2</div>
                            <div class="timeline-content">
                                <h5 class="fw-bold">Complete Profiles</h5>
                                <p>Both spouses provide personal details and upload documents.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker">3</div>
                            <div class="timeline-content">
                                <h5 class="fw-bold">Schedule Nikah</h5>
                                <p>Choose your preferred date, location, and officiant.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker">4</div>
                            <div class="timeline-content">
                                <h5 class="fw-bold">Finalize Details</h5>
                                <p>Confirm Mahr, assign witnesses, and complete registration.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker">5</div>
                            <div class="timeline-content">
                                <h5 class="fw-bold">Make Payment</h5>
                                <p>Securely pay the Nikah charges online.</p>
                            </div>
                        </div>

                        <div class="timeline-item">
                            <div class="timeline-marker success"><i class="fa fa-check"></i></div>
                            <div class="timeline-content">
                                <h5 class="fw-bold text-success">Print Certificate</h5>
                                <p>Preview and print out your official Nikah Certificate.</p>
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <a href="javascript:void();" class="btn btn-danger btn-lg rounded-pill px-5">Start
                                Process</a>
                        </div>
                    </div>
                </div>

                <style>
                    /* CSS Styling */
                    .nikah-timeline-container {
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                    }

                    .timeline-item {
                        padding-left: 40px;
                        padding-bottom: 30px;
                        position: relative;
                        border-left: 2px solid #e9ecef;
                    }

                    .timeline-item:last-child {
                        border-left: 2px solid transparent;
                    }

                    .timeline-marker {
                        position: absolute;
                        left: -16px;
                        top: 0;
                        width: 32px;
                        height: 32px;
                        border-radius: 50%;
                        background: #fff;
                        border: 2px solid #dc3545;
                        /* Red Theme */
                        color: #dc3545;
                        text-align: center;
                        line-height: 28px;
                        font-weight: bold;
                    }

                    .timeline-marker.success {
                        background: #198754;
                        border-color: #198754;
                        color: #fff;
                    }

                    .timeline-content {
                        background: #fff;
                        padding: 15px 20px;
                        border-radius: 8px;
                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
                        transition: transform 0.2s;
                    }

                    .timeline-content:hover {
                        transform: translateX(5px);
                    }

                    .timeline-content h5 {
                        margin-bottom: 5px;
                        color: #333;
                    }

                    .timeline-content p {
                        margin: 0;
                        color: #666;
                        font-size: 0.95rem;
                    }
                </style>

                <div class="col-lg-12 mt-5">
                    <div class="row">

                        <div class="col-lg-6">
                            <div class="meeting-item feature-card-2">
                                <div class="thumb">
                                    <div class="price"><span>Feature 1</span></div>
                                    <a href="#"><img src="{{ asset('asset/images/meeting-01.jpg') }}"
                                            alt="Registration"></a>
                                </div>

                                <div class="down-content text-center p-4">
                                    <a href="#" class="text-decoration-none">
                                        <h4 class="fw-bold mb-1" style="color: #dc3545;">Digital Registration</h4>
                                    </a>
                                    <p class="text-muted small mb-3">Fast, Secure, & Official</p>

                                    <div class="tags-container d-flex flex-wrap justify-content-center gap-2 mb-4">
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-laptop me-1"></i> Online App
                                        </span>

                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-lock me-1"></i> Secure Upload
                                        </span>

                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-clock-o me-1"></i> Fast Process
                                        </span>
                                    </div>


                                    <div class="main-button-red">
                                        <a href="javascript:void();" class="shadow-sm">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .feature-card-2 {
                                border: 1px solid #eee;
                                border-radius: 12px;
                                background: #fff;
                            }

                            .feature-card-2 .badge {
                                font-weight: 500;
                                padding: 8px 12px;
                                border-radius: 8px;
                                font-size: 0.85rem;
                            }

                            .feature-card-2 h4 {
                                color: #2a2a2a;
                                transition: color 0.3s;
                            }

                            .feature-card-2:hover h4 {
                                color: #dc3545;
                            }
                        </style>
                        <div class="col-lg-6">
                            <div class="meeting-item feature-card-2">
                                <div class="thumb">
                                    <div class="price">
                                        <span>Feature 2</span>
                                    </div>
                                    <a href="#"><img src="{{ asset('asset/images/meeting-02.jpg') }}"
                                            alt="Wali and Witness"></a>
                                </div>
                                <div class="down-content text-center p-4">
                                    <a href="#" class="text-decoration-none">
                                        <h4 class="fw-bold mb-1" style="color: #dc3545;">Wali & Witness Coordination
                                        </h4>
                                    </a>
                                    <p class="text-muted small mb-3">Verified, Coordinated, & Transparent</p>

                                    <div class="tags-container d-flex flex-wrap justify-content-center gap-2 mb-4">
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-user me-1"></i> Verified Guardians
                                        </span>
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-users me-1"></i> Witness Sync
                                        </span>
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-book me-1"></i> Transparent
                                        </span>
                                    </div>

                                    <div class="main-button-red">
                                        <a href="javascript:void();" class="shadow-sm">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <div class="meeting-item feature-card-2">
                                <div class="thumb">
                                    <div class="price">
                                        <span>Feature 3</span>
                                    </div>
                                    <a href="#"><img src="{{ asset('asset/images/meeting-03.png') }}"
                                            alt="Mahr Agreement"></a>
                                </div>
                                <div class="down-content text-center p-4">
                                    <a href="#" class="text-decoration-none">
                                        <h4 class="fw-bold mb-1" style="color: #dc3545;">Mahr Agreement Facilitation
                                        </h4>
                                    </a>
                                    <p class="text-muted small mb-3">Structured, Islamic, & Secure</p>

                                    <div class="tags-container d-flex flex-wrap justify-content-center gap-2 mb-4">
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-file-text-o me-1"></i> Structured Docs
                                        </span>
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-book me-1"></i> Islamic Guide
                                        </span>
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-shield me-1"></i> Secure Record
                                        </span>
                                    </div>

                                    <div class="main-button-red">
                                        <a href="javascript:void();">{{ __('ui.landing.register_now') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mt-5">
                            <div class="meeting-item feature-card-2">
                                <div class="thumb">
                                    <div class="price">
                                        <span>Feature 4</span>
                                    </div>
                                    <a href="#"><img src="{{ asset('asset/images/meeting-04.jpg') }}"
                                            alt="Nikah Certificate"></a>
                                </div>
                                <div class="down-content text-center p-4">
                                    <a href="#" class="text-decoration-none">
                                        <h4 class="fw-bold mb-1" style="color: #dc3545;">Nikah Certificate Generation
                                        </h4>
                                    </a>
                                    <p class="text-muted small mb-3">Official & Recognized Documentation</p>

                                    <div class="tags-container d-flex flex-wrap justify-content-center gap-2 mb-4">
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-certificate me-1"></i> Official Cert
                                        </span>
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-print me-1"></i> Print & Digital
                                        </span>
                                        <span class="badge bg-light text-dark border"
                                            style="background-color: #dc3545 !important; color: #FFF !important;">
                                            <i class="fa fa-gavel me-1"></i> Legal Ready
                                        </span>
                                    </div>

                                    <div class="main-button-red">
                                        <a href="javascript:void();" class="shadow-sm">Apply Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <style>
                            .feature-card-2 {
                                border: 1px solid #eee;
                                border-radius: 12px;
                                background: #fff;
                                height: 100%;
                                /* Ensures cards are equal height in flex row */
                                display: flex;
                                flex-direction: column;
                            }

                            .feature-card-2 .thumb {
                                position: relative;
                            }

                            .feature-card-2 .down-content {
                                flex-grow: 1;
                                /* Pushes button to bottom if content varies */
                                display: flex;
                                flex-direction: column;
                                justify-content: space-between;
                            }

                            .feature-card-2 .badge {
                                font-weight: 500;
                                padding: 8px 12px;
                                border-radius: 8px;
                                font-size: 0.85rem;
                                display: inline-flex;
                                align-items: center;
                            }

                            .feature-card-2 h4 {
                                color: #2a2a2a;
                                transition: color 0.3s;
                            }

                            .feature-card-2:hover h4 {
                                color: #dc3545;
                            }

                            /* Hover effect for the whole card */
                            .feature-card-2:hover {
                                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                                transform: translateY(-5px);
                                transition: all 0.3s ease;
                            }

                            .video-overlay {
                                position: absolute;
                                background-color: rgb(63 63 63 / 75%);
                                top: 0;
                                left: 0;
                                bottom: 0;
                                right: 0;
                                width: 100%;
                            }
                        </style>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-courses" id="courses" style="padding-top:0px;margin-top:0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2>Our Successful Nikahs</h2>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="row">

                            <div class="col-lg-12" style="margin-bottom: 30px;">
                                <div class="item"
                                    style="background: linear-gradient(135deg, #A41E1E 0%, #7a1616 100%); padding: 35px; border-radius: 20px; box-shadow: 0 10px 30px rgba(164, 30, 30, 0.2); position: relative; overflow: hidden;">
                                    <div
                                        style="position: absolute; right: -20px; top: -20px; opacity: 0.1; font-size: 100px; color: #fff;">
                                        <i class="fa fa-users"></i>
                                    </div>

                                    <h3
                                        style="color: #ffffff; font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px;">
                                        Honoring the Role of Family in Nikah
                                    </h3>

                                    <p
                                        style="color: rgba(255,255,255,0.9); font-style: italic; line-height: 1.8; font-size: 1.05rem; margin-bottom: 25px;">
                                        "Asalaam Aleikum Warahmatullahi Wabarakhatuhu. We understand that marriage in
                                        our Ugandan Muslim tradition is not just between two individuals, but a union of
                                        families. Our platform respects the essential role of guardians (Walis) and
                                        families in the Nikah process."
                                    </p>

                                    <h3
                                        style="color: #ffffff; font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.2); padding-bottom: 10px;">
                                        Strengthening Uganda's Muslim Community
                                    </h3>

                                    <p
                                        style="color: rgba(255,255,255,0.9); font-style: italic; line-height: 1.8; font-size: 1.05rem; margin-bottom: 25px;">
                                        "Asalaam Aleikum Warahmatullahi Wabarakhatuhu. Beyond facilitating individual
                                        marriages, our Nikah system contributes to the strength and unity of Uganda's
                                        diverse Muslim population. We are preserving the beauty of our traditions in a
                                        modern, organized manner."
                                    </p>
                                    </p>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="faq-container">

                            <div
                                style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid #A41E1E;">
                                <div style="font-weight: bold; color: #333; margin-bottom: 10px; font-size: 1.1rem;">
                                    <i class="fa fa-book me-1" style="color: #A41E1E; margin-right: 8px;"></i>
                                    Recognition & Authority
                                </div>
                                <div style="color: #666; line-height: 1.5;">
                                    As the official system of the <b>Uganda Muslim Supreme Council</b>, we work closely
                                    with local scholars to ensure every Nikah is legally and religiously sound.
                                </div>
                            </div>

                            <div
                                style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid #A41E1E;">
                                <div style="font-weight: bold; color: #333; margin-bottom: 10px; font-size: 1.1rem;">
                                    <i class="fa fa-book me-1" style="color: #A41E1E; margin-right: 8px;"></i>
                                    Required Documentation
                                </div>
                                <div style="color: #666; line-height: 1.5;">
                                    Please prepare your National IDs, proof of faith, guardian (Wali) verification, and
                                    previous marriage termination documents if applicable.
                                </div>
                            </div>

                            <div
                                style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid #A41E1E;">
                                <div style="font-weight: bold; color: #333; margin-bottom: 10px; font-size: 1.1rem;">
                                    <i class="fa fa-book me-1" style="color: #A41E1E; margin-right: 8px;"></i>
                                    Traditional Nikah Ceremonies
                                </div>
                                <div style="color: #666; line-height: 1.5;">
                                    Absolutely! Our system is designed to help you seamlessly organize and schedule both
                                    the official legal registration and the ceremonial aspects of your Nikah.
                                </div>
                            </div>

                            <div
                                style="background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 20px; border-left: 5px solid #A41E1E;">
                                <div style="font-weight: bold; color: #333; margin-bottom: 10px; font-size: 1.1rem;">
                                    <i class="fa fa-book me-1" style="color: #A41E1E; margin-right: 8px;"></i> Support
                                    for
                                    Different Madhabs
                                </div>
                                <div style="color: #666; line-height: 1.5;">
                                    Yes, we accommodate and respect the various schools of Islamic thought (Madhabs)
                                    practiced across Uganda to ensure a culturally and religiously inclusive process.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="contact-us" id="contact"
        style="padding-top: 0px;margin-top:0px;padding-bottom: 0px;margin-bottom:0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 align-self-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="contact" action="#" method="post">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h2>Let's get in touch</h2>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset>
                                            <input name="name" type="text" id="name"
                                                placeholder="YOURNAME...*" required="">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset>
                                            <input name="email" type="text" id="email"
                                                pattern="[^ @]*@[^ @]*" placeholder="YOUR EMAIL..." required="">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-4">
                                        <fieldset>
                                            <input name="subject" type="text" id="subject"
                                                placeholder="SUBJECT...*" required="">
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <textarea name="message" type="text" class="form-control" id="message" placeholder="YOUR MESSAGE..."
                                                required=""></textarea>
                                        </fieldset>
                                    </div>
                                    <div class="col-lg-12">
                                        <fieldset>
                                            <button type="submit" id="form-submit" class="button">contact
                                                us</button>
                                        </fieldset>
                                    </div>
                                </div>
                            </form>

                            <script>
                                document.getElementById('contact').addEventListener('submit', function(e) {
                                    e.preventDefault(); // Stops form submission
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer"
            style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <p style="text-align: left; margin: 0;">
                Copyright &copy; {{ \Carbon\Carbon::now()->year }} umsc.
            </p>

            <p style="text-align: right; margin: 0;">All Rights Reserved.</p>
        </div>
    </section>

    <button onclick="scrollToTop()" id="scrollBtn">
        ↑
    </button>

    <script>
        const btn = document.getElementById("scrollBtn");

        window.onscroll = function() {
            if (document.documentElement.scrollTop > 200) {
                btn.style.display = "flex";
            } else {
                btn.style.display = "none";
            }
        };

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        }
    </script>

    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('asset/js/isotope.min.js') }}"></script>
    <script src="{{ asset('asset/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('asset/js/lightbox.js') }}"></script>
    <script src="{{ asset('asset/js/tabs.js') }}"></script>
    <script src="{{ asset('asset/js/video.js') }}"></script>
    <script src="{{ asset('asset/js/slick-slider.js') }}"></script>
    <script src="{{ asset('asset/js/custom.js') }}"></script>
    <script>
        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
            var
                direction = section.replace(/#/, ''),
                reqSection = $('.section').filter('[data-section="' + direction + '"]'),
                reqSectionPos = reqSection.offset().top - 0;

            if (isAnimate) {
                $('body, html').animate({
                        scrollTop: reqSectionPos
                    },
                    800);
            } else {
                $('body, html').scrollTop(reqSectionPos);
            }

        };

        var checkSection = function checkSection() {
            $('.section').each(function() {
                var
                    $this = $(this),
                    topEdge = $this.offset().top - 80,
                    bottomEdge = topEdge + $this.height(),
                    wScroll = $(window).scrollTop();
                if (topEdge < wScroll && bottomEdge > wScroll) {
                    var
                        currentId = $this.data('section'),
                        reqLink = $('a').filter('[href*=\\#' + currentId + ']');
                    reqLink.closest('li').addClass('active').
                    siblings().removeClass('active');
                }
            });
        };

        $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function(e) {
            e.preventDefault();
            showSection($(this).attr('href'), true);
        });

        $(window).scroll(function() {
            checkSection();
        });
    </script>
    <script>
        // replace Offered Courses blocks with API data where possible
        (function() {
            try {
                fetch('/api/courses').then(r => r.json()).then(courses => {
                    const container = document.querySelector('.upcoming-meetings .col-lg-8 .row');
                    if (!container) return;
                    // remove existing child meeting columns
                    const cols = Array.from(container.querySelectorAll('.col-lg-6'));
                    if (cols.length === 0) return;
                    // Replace up to cols.length courses
                    courses.slice(0, cols.length).forEach((course, i) => {
                        const col = cols[i];
                        const img = col.querySelector('.thumb a img');
                        if (img) img.src = course.thumbnail || 'assets/images/meeting-01.jpg';
                        const title = col.querySelector('.down-content h4');
                        if (title) {
                            title.textContent = course.title;
                            title.parentElement.querySelector('a').href =
                                `playlist.html?courseId=${course.id}`;
                            // update Apply Now button in the card if it exists
                            const applyBtn = col.querySelector('.main-button-red a');
                            if (applyBtn) applyBtn.href = `playlist.html?courseId=${course.id}`;
                        }
                        const p = col.querySelector('.down-content p');
                        if (p) p.textContent = course.description || '';
                    });
                }).catch(() => {});
            } catch (e) {}
        })();
        // make Apply/Join buttons go to profile if already logged in (otherwise to register)
        document.addEventListener('click', async (e) => {
            const t = e.target.closest('a');
            if (!t) return;
            try {
                const href = t.getAttribute('href');
                if (!href) return;
                if (href.includes('playlist.html')) return;
                if (href.endsWith('register.html') || href.includes('register.html')) {
                    // check session
                    const me = await fetch('/api/auth/me');
                    if (me.ok) {
                        e.preventDefault();
                        window.location.href = 'profile.html';
                    }
                }
            } catch (e) {}
        });
    </script>
</body>

</html>
