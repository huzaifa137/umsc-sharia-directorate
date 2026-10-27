@extends('layouts.app')

@section('content')
<style>
    .dash-lang-switcher { display: flex; gap: 6px; }
    .dash-lang-btn {
        border: 1px solid #e2e8f0; background: #fff; color: #64748b;
        font-size: 11px; font-weight: 600; padding: 5px 10px;
        border-radius: 6px; cursor: pointer; transition: all .15s ease;
    }
    .dash-lang-btn:hover { border-color: #059568; color: #059568; }
    .dash-lang-btn.active { background: #059568; border-color: #059568; color: #fff; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
        <div>
            <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;" id="label_directorate_of_sharia">Directorate of Sharia</h2>
            <div class="dash-lang-switcher mt-2">
                <button type="button" class="dash-lang-btn active" data-lang="en">ENGLISH</button>
                <button type="button" class="dash-lang-btn" data-lang="ar">ARABIC</button>
                <button type="button" class="dash-lang-btn" data-lang="sw">SWAHILI</button>
            </div>
        </div>
        <div class="avatar-group">
            <div class="bg-light p-2 rounded-3">
                <i class="bx bx-calendar text-success me-2"></i>
                <span id="currentDateFull" class="small fw-medium"></span>
            </div>
        </div>

        <script>
            const dateElement = document.getElementById('currentDateFull');
            const now = new Date();
            const formattedDate = now.toLocaleDateString('en-US', {
                weekday: 'long',
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
            dateElement.textContent = formattedDate;
        </script>
    </div>

    <!-- Quick Search & Actions -->
    @include('layouts.search-feature')

    <!-- Stats Overview Cards -->
    <div class="row g-4 mb-4">
        <!-- Divorce Cases -->
        <div class="col-lg-4 col-md-6">
            <a href="{{ url('divorce-dashboard') }}">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: #ffffff; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-secondary small fw-semibold text-uppercase" style="letter-spacing: 0.5px;" id="label_divorce_cases">Divorce Cases</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2 fw-bold text-dark" style="font-size: 2.2rem;">{{ $totalDivorce }}</h3>
                                    <span class="text-success small">+{{ $currentMonthCases }}</span>
                                </div>
                                <p class="mb-0 small text-muted" id="label_current_period">Current period</p>
                            </div>
                            <span class="badge bg-warning p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bx bx-x-circle fs-4 text-white"></i>
                            </span>
                        </div>
                    </div>
                    <div class="w-100 bg-warning" style="height: 5px; border-radius: 0 0 16px 16px; opacity: 0.8;"></div>
                </div>
            </a>
        </div>

        <!-- Total Nikah -->
        <div class="col-lg-4 col-md-6">
            <a href="{{ url('nikah-dashboard') }}">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: #ffffff; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-secondary small fw-semibold text-uppercase" style="letter-spacing: 0.5px;" id="label_total_nikah">Total Nikah</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2 fw-bold text-dark" style="font-size: 2.2rem;">{{ number_format($totalNikah) }}</h3>
                                    @if ($currentMonthNikah)
                                        <span class="text-success small">+{{ $currentMonthNikah }}</span>
                                    @endif
                                </div>
                                <p class="mb-0 small text-muted" id="label_current_period_2">Current period</p>
                            </div>
                            <span class="badge bg-primary p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bx bx-heart fs-4 text-white"></i>
                            </span>
                        </div>
                    </div>
                    <div class="w-100 bg-primary" style="height: 5px; border-radius: 0 0 16px 16px; opacity: 0.8;"></div>
                </div>
            </a>
        </div>

        <!-- Inheritance Settled -->
        <div class="col-lg-4 col-md-6">
            <a href="{{ url('inheritance-dashboard') }}">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: #ffffff; transition: all 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="text-secondary small fw-semibold text-uppercase" style="letter-spacing: 0.5px;" id="label_inheritance_settled">Inheritance Settled</span>
                                <div class="d-flex align-items-center my-2">
                                    <h3 class="mb-0 me-2 fw-bold text-dark" style="font-size: 2.2rem;">{{ number_format($totalInheritance) }}</h3>
                                    @if ($currentMonthInheritance)
                                        <span class="text-success small">+{{ $currentMonthInheritance }}</span>
                                    @endif
                                </div>
                                <p class="mb-0 small text-muted" id="label_current_period_3">Current period</p>
                            </div>
                            <span class="badge bg-info p-2 rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="bx bx-pie-chart-alt fs-4 text-white"></i>
                            </span>
                        </div>
                    </div>
                    <div class="w-100 bg-info" style="height: 5px; border-radius: 0 0 16px 16px; opacity: 0.8;"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Inheritance Division Card -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 border-start border-4 border-success shadow-sm" style="border-radius:14px;">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-semibold mb-1" id="label_inheritance_division">Inheritance Division</h5>
                            <small class="text-muted" id="label_sharia_compliant_distribution">Sharia-compliant distribution</small>
                        </div>
                        <i class="bx bx-pie-chart-alt fs-2 text-success"></i>
                    </div>

                    <div class="flex-grow-1">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span id="label_pending_calculation">Pending Calculation</span>
                                <strong>{{ $pendingInheritance }}</strong>
                            </div>
                            <div class="progress mt-1" style="height:6px;">
                                <div class="progress-bar bg-danger" style="width: {{ $totalInheritance ? ($pendingInheritance / $totalInheritance) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span id="label_settled_this_month">Settled This Month</span>
                                <strong>{{ $thisMonthInheritance }}</strong>
                            </div>
                            <div class="progress mt-1" style="height:6px;">
                                <div class="progress-bar bg-success" style="width: {{ $totalInheritance ? ($thisMonthInheritance / $totalInheritance) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <span id="label_total_settlements">Total Settlements</span>
                            <strong class="text-success">{{ $totalInheritance }}</strong>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ url('inheritance-application') }}" class="btn btn-success" id="label_register_application">Register Application</a>
                        <a href="{{ url('inheritance-dashboard') }}" class="btn btn-outline-success" id="label_manage_records">Manage Records</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side: Nikah Registry Card -->
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card h-100 border-start border-4 border-primary shadow-sm" style="border-radius:14px;">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="fw-semibold mb-1" id="label_nikah_registry">Nikah Registry</h5>
                                    <small class="text-muted" id="label_marriage_contracts_certificates">Marriage contracts & certificates</small>
                                </div>
                                <i class="bx bx-heart fs-2 text-primary"></i>
                            </div>

                            <div class="flex-grow-1">
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span id="label_pending_review">Pending Review</span>
                                        <strong>{{ $pendingNikah }}</strong>
                                    </div>
                                    <div class="progress mt-1" style="height:6px;">
                                        <div class="progress-bar bg-warning" style="width: {{ $totalNikah ? ($pendingNikah / $totalNikah) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between">
                                        <span id="label_approved_today">Approved Today</span>
                                        <strong>{{ $approvedTodayNikah }}</strong>
                                    </div>
                                    <div class="progress mt-1" style="height:6px;">
                                        <div class="progress-bar bg-success" style="width: {{ $totalNikah ? ($approvedTodayNikah / $totalNikah) * 100 : 0 }}%"></div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span id="label_total_certificates">Total Certificates</span>
                                    <div class="d-flex align-items-center">
                                        <strong class="text-primary me-2">{{ $totalNikah }}</strong>
                                        @if (isset($currentMonthCases) && $currentMonthCases > 0)
                                            <span class="text-success small">+{{ $currentMonthCases }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ url('nikah') }}" class="btn btn-primary" id="label_register_new_nikah">Register New Nikah</a>
                                <a href="{{ url('nikah-dashboard') }}" class="btn btn-outline-primary" id="label_manage_records_2">Manage Records</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row of Action Cards -->
    <div class="row">
        <!-- Converts Management -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-lg border-0 overflow-hidden">
                <div class="position-absolute top-0 start-0 w-100 bg-info" style="height: 5px;"></div>
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-light-info p-3 me-3 rounded-circle">
                            <i class="bx bx-user-plus fs-2 text-info"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" id="label_islamic_conversion">Islamic Conversion</h5>
                            <p class="text-muted small mb-0" id="label_new_muslims_registrations">New Muslims Registrations</p>
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted" id="label_awaiting_approval">Awaiting Approval</span>
                            <span class="badge bg-label-warning">{{ $pendingConverts }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted" id="label_converted_this_month">Converted This Month</span>
                            <span class="badge bg-label-success">{{ $thisMonthConverts }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted" id="label_total_converts">Total Converts</span>
                            <span class="badge bg-label-info">{{ $totalConverts }}</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ url('convert-application') }}" class="btn btn-info text-white" id="label_new_declaration">New Declaration</a>
                        <a href="{{ url('convert-dashboard') }}" class="btn btn-outline-info" id="label_view_converts">View Converts</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guardianship Management -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-lg border-0 overflow-hidden">
                <div class="position-absolute top-0 start-0 w-100 bg-danger" style="height: 5px;"></div>
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-light-danger p-3 me-3 rounded-circle">
                            <i class="bx bx-shield-alt-2 fs-2 text-danger"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" id="label_guardianship">Guardianship</h5>
                            <p class="text-muted small mb-0" id="label_wilayah_custody_cases">Wilayah & custody cases</p>
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted" id="label_active_guardianships">Active Guardianships</span>
                            <span class="badge bg-label-primary">{{ $activeGuardianships }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted" id="label_pending_review_2">Pending Review</span>
                            <span class="badge bg-label-warning">{{ $pendingGuardianships }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted" id="label_total_appointments">Total Appointments</span>
                            <span class="badge bg-label-danger">{{ $totalGuardianships }}</span>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ url('guardianship-application') }}" class="btn btn-danger" id="label_new_guardian">New Guardian</a>
                        <a href="{{ url('guardianship-dashboard') }}" class="btn btn-outline-danger" id="label_view_records">View Records</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reports & Analytics -->
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-lg border-0 overflow-hidden">
                <div class="position-absolute top-0 start-0 w-100 bg-secondary" style="height: 5px;"></div>
                <div class="card-body d-flex flex-column p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="avatar bg-light-secondary p-3 me-3 rounded-circle">
                            <i class="bx bx-stats fs-2 text-secondary"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" id="label_reports_analytics">Reports & Analytics</h5>
                            <p class="text-muted small mb-0" id="label_statistics_insights">Statistics & insights</p>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="list-group list-group-flush">
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span id="label_monthly_summary">Monthly Summary</span>
                                    <i class="bx bx-chevron-right"></i>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span id="label_export_all_data">Export All Data</span>
                                    <i class="bx bx-download"></i>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span id="label_generate_annual_report">Generate Annual Report</span>
                                    <i class="bx bx-file"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="javascript:void();" class="btn btn-secondary" id="label_view_full_reports">View Full Reports</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .action-group .btn {
            background: #ffffff;
            padding-top: 6px;
            padding-bottom: 6px;
            transition: all 0.2s;
            border: none;
        }
        .action-group .btn:hover {
            background: #f8fafc;
            color: #059568 !important;
        }
        .action-group .btn-white i {
            vertical-align: middle;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(5, 149, 104, 0.02) !important;
        }
    </style>

    <style>
        .avatar { display: inline-flex; align-items: center; justify-content: center; }
        .bg-gradient-primary { background: #667eea; }
        .border-start { border-left-width: 4px !important; }
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important; }
        .bg-light-primary { background-color: rgba(102, 126, 234, 0.1); }
        .bg-light-warning { background-color: rgba(255, 193, 7, 0.1); }
        .bg-light-success { background-color: rgba(40, 167, 69, 0.1); }
        .bg-light-info { background-color: rgba(23, 162, 184, 0.1); }
        .bg-light-danger { background-color: rgba(220, 53, 69, 0.1); }
        .bg-light-secondary { background-color: rgba(108, 117, 125, 0.1); }
        .bg-label-primary { background-color: rgba(102, 126, 234, 0.1); color: #667eea; }
        .bg-label-warning { background-color: rgba(255, 193, 7, 0.1); color: #ffc107; }
        .bg-label-success { background-color: rgba(40, 167, 69, 0.1); color: #28a745; }
        .bg-label-info { background-color: rgba(23, 162, 184, 0.1); color: #17a2b8; }
        .bg-label-danger { background-color: rgba(220, 53, 69, 0.1); color: #dc3545; }
    </style>
</div>

<!-- ================================================================ -->
<!-- TRANSLATION SCRIPT - FIXED                                      -->
<!-- ================================================================ -->
<script>
    (function() {
        // Use a unique variable name to avoid conflicts
        if (typeof window._dashTranslations !== 'undefined') {
            // Already defined, skip re-definition
            return;
        }

        window._dashTranslations = {
            en: {
                "directorate_of_sharia": "Directorate of Sharia",
                "divorce_cases": "Divorce Cases",
                "current_period": "Current period",
                "total_nikah": "Total Nikah",
                "inheritance_settled": "Inheritance Settled",
                "inheritance_division": "Inheritance Division",
                "sharia_compliant_distribution": "Sharia-compliant distribution",
                "pending_calculation": "Pending Calculation",
                "settled_this_month": "Settled This Month",
                "total_settlements": "Total Settlements",
                "register_application": "Register Application",
                "manage_records": "Manage Records",
                "nikah_registry": "Nikah Registry",
                "marriage_contracts_certificates": "Marriage contracts & certificates",
                "pending_review": "Pending Review",
                "approved_today": "Approved Today",
                "total_certificates": "Total Certificates",
                "register_new_nikah": "Register New Nikah",
                "islamic_conversion": "Islamic Conversion",
                "new_muslims_registrations": "New Muslims Registrations",
                "awaiting_approval": "Awaiting Approval",
                "converted_this_month": "Converted This Month",
                "total_converts": "Total Converts",
                "new_declaration": "New Declaration",
                "view_converts": "View Converts",
                "guardianship": "Guardianship",
                "wilayah_custody_cases": "Wilayah & custody cases",
                "active_guardianships": "Active Guardianships",
                "total_appointments": "Total Appointments",
                "new_guardian": "New Guardian",
                "view_records": "View Records",
                "reports_analytics": "Reports & Analytics",
                "statistics_insights": "Statistics & insights",
                "monthly_summary": "Monthly Summary",
                "export_all_data": "Export All Data",
                "generate_annual_report": "Generate Annual Report",
                "view_full_reports": "View Full Reports"
            },
            ar: {
                "directorate_of_sharia": "مديرية الشريعة",
                "divorce_cases": "قضايا الطلاق",
                "current_period": "الفترة الحالية",
                "total_nikah": "إجمالي عقود النكاح",
                "inheritance_settled": "المواريث المُسوّاة",
                "inheritance_division": "تقسيم الميراث",
                "sharia_compliant_distribution": "توزيع متوافق مع الشريعة",
                "pending_calculation": "بانتظار الحساب",
                "settled_this_month": "تمت التسوية هذا الشهر",
                "total_settlements": "إجمالي التسويات",
                "register_application": "تسجيل طلب",
                "manage_records": "إدارة السجلات",
                "nikah_registry": "سجل النكاح",
                "marriage_contracts_certificates": "عقود وشهادات الزواج",
                "pending_review": "بانتظار المراجعة",
                "approved_today": "تمت الموافقة اليوم",
                "total_certificates": "إجمالي الشهادات",
                "register_new_nikah": "تسجيل عقد نكاح جديد",
                "islamic_conversion": "الدخول في الإسلام",
                "new_muslims_registrations": "تسجيلات المسلمين الجدد",
                "awaiting_approval": "بانتظار الموافقة",
                "converted_this_month": "أسلم هذا الشهر",
                "total_converts": "إجمالي المعتنقين",
                "new_declaration": "إقرار جديد",
                "view_converts": "عرض المعتنقين",
                "guardianship": "الولاية",
                "wilayah_custody_cases": "قضايا الولاية والحضانة",
                "active_guardianships": "حالات ولاية نشطة",
                "total_appointments": "إجمالي التعيينات",
                "new_guardian": "ولي جديد",
                "view_records": "عرض السجلات",
                "reports_analytics": "التقارير والتحليلات",
                "statistics_insights": "الإحصائيات والرؤى",
                "monthly_summary": "الملخص الشهري",
                "export_all_data": "تصدير جميع البيانات",
                "generate_annual_report": "إنشاء التقرير السنوي",
                "view_full_reports": "عرض التقارير الكاملة"
            },
            sw: {
                "directorate_of_sharia": "Idara ya Sheria za Kiislamu",
                "divorce_cases": "Kesi za Talaka",
                "current_period": "Kipindi cha sasa",
                "total_nikah": "Jumla ya Nikah",
                "inheritance_settled": "Urithi Uliotatuliwa",
                "inheritance_division": "Mgawanyo wa Urithi",
                "sharia_compliant_distribution": "Mgawanyo unaofuata Sheria za Kiislamu",
                "pending_calculation": "Inasubiri Hesabu",
                "settled_this_month": "Imetatuliwa Mwezi Huu",
                "total_settlements": "Jumla ya Utatuzi",
                "register_application": "Sajili Ombi",
                "manage_records": "Simamia Rekodi",
                "nikah_registry": "Rejista ya Nikah",
                "marriage_contracts_certificates": "Mikataba na vyeti vya ndoa",
                "pending_review": "Inasubiri Ukaguzi",
                "approved_today": "Imeidhinishwa Leo",
                "total_certificates": "Jumla ya Vyeti",
                "register_new_nikah": "Sajili Nikah Mpya",
                "islamic_conversion": "Kusilimu",
                "new_muslims_registrations": "Usajili wa Waislamu Wapya",
                "awaiting_approval": "Inasubiri Idhini",
                "converted_this_month": "Wamesilimu Mwezi Huu",
                "total_converts": "Jumla ya Waliosilimu",
                "new_declaration": "Tamko Jipya",
                "view_converts": "Angalia Waliosilimu",
                "guardianship": "Ulezi",
                "wilayah_custody_cases": "Kesi za Ulezi na Malezi",
                "active_guardianships": "Ulezi Unaoendelea",
                "total_appointments": "Jumla ya Uteuzi",
                "new_guardian": "Mlezi Mpya",
                "view_records": "Angalia Rekodi",
                "reports_analytics": "Ripoti na Uchambuzi",
                "statistics_insights": "Takwimu na Maarifa",
                "monthly_summary": "Muhtasari wa Mwezi",
                "export_all_data": "Hamisha Data Yote",
                "generate_annual_report": "Tengeneza Ripoti ya Mwaka",
                "view_full_reports": "Angalia Ripoti Kamili"
            }
        };

        function applyTranslations(lang) {
            const translations = window._dashTranslations;
            if (!translations[lang]) return;

            // Save preference
            localStorage.setItem('app_language', lang);
            document.documentElement.lang = lang;
            document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';

            // Apply translations to ALL elements with IDs
            const translationKeys = translations[lang];
            
            // Loop through all translation keys and find matching elements
            Object.keys(translationKeys).forEach(function(key) {
                // Try to find element by ID
                const el = document.getElementById('label_' + key);
                if (el) {
                    el.textContent = translationKeys[key];
                }
            });

            // Update active button state
            document.querySelectorAll('.dash-lang-btn').forEach(function (btn) {
                btn.classList.toggle('active', btn.dataset.lang === lang);
            });
        }

        // ================================================================
        // APPLY TRANSLATIONS IMMEDIATELY
        // ================================================================

        // Get saved language or default to English
        const savedLang = localStorage.getItem('app_language');
        const defaultLang = 'en';
        const initialLang = (savedLang && window._dashTranslations[savedLang]) ? savedLang : defaultLang;

        // Apply translations immediately if DOM is ready
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            applyTranslations(initialLang);
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                applyTranslations(initialLang);
            });
        }

        // Set up language switcher buttons
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dash-lang-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    applyTranslations(this.dataset.lang);
                });
            });
        });

        // Safety net - run on load too
        window.addEventListener('load', function() {
            const lang = localStorage.getItem('app_language') || 'en';
            applyTranslations(lang);
        });

    })(); // End of IIFE
</script>
@endsection