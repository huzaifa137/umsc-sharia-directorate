@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;" data-i18n="directorate_of_sharia"></h2>
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
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 16px; background: #ffffff; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-secondary small fw-semibold text-uppercase"
                                        style="letter-spacing: 0.5px;">Divorce Cases</span>
                                    <div class="d-flex align-items-center my-2">
                                        <h3 class="mb-0 me-2 fw-bold text-dark" style="font-size: 2.2rem;">
                                            {{ $totalDivorce }}
                                        </h3>
                                        <span class="text-success small">
                                            +{{ $currentMonthCases }}
                                        </span>
                                    </div>
                                    <p class="mb-0 small text-muted">Current period</p>
                                </div>

                                <span
                                    class="badge bg-warning p-2 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="bx bx-x-circle fs-4 text-white"></i>
                                </span>
                            </div>
                        </div>
                        <div class="w-100 bg-warning" style="height: 5px; border-radius: 0 0 16px 16px; opacity: 0.8;">
                        </div>
                    </div>
                </a>
            </div>
            <!-- Total Nikah -->
            <div class="col-lg-4 col-md-6">
                <a href="{{ url('nikah-dashboard') }}">
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 16px; background: #ffffff; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-secondary small fw-semibold text-uppercase"
                                        style="letter-spacing: 0.5px;">Total Nikah</span>
                                    <div class="d-flex align-items-center my-2">
                                        <h3 class="mb-0 me-2 fw-bold text-dark" style="font-size: 2.2rem;">
                                            {{ number_format($totalNikah) }}
                                        </h3>
                                        @if ($currentMonthNikah)
                                            <span class="text-success small">
                                                +{{ $currentMonthNikah }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mb-0 small text-muted">Current period</p>
                                </div>
                                <span
                                    class="badge bg-primary p-2 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
                                    <i class="bx bx-heart fs-4 text-white"></i>
                                </span>
                            </div>
                        </div>
                        <div class="w-100 bg-primary" style="height: 5px; border-radius: 0 0 16px 16px; opacity: 0.8;">
                        </div>
                    </div>
                </a>
            </div>


            <!-- Inheritance Settled -->
            <div class="col-lg-4 col-md-6">
                <a href="{{ url('inheritance-dashboard') }}">
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 16px; background: #ffffff; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="content-left">
                                    <span class="text-secondary small fw-semibold text-uppercase"
                                        style="letter-spacing: 0.5px;">Inheritance Settled</span>
                                    <div class="d-flex align-items-center my-2">
                                        <h3 class="mb-0 me-2 fw-bold text-dark" style="font-size: 2.2rem;">
                                            {{ number_format($totalInheritance) }}
                                        </h3>
                                        @if ($currentMonthInheritance)
                                            <span class="text-success small">
                                                +{{ $currentMonthInheritance }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mb-0 small text-muted">Current period</p>
                                </div>
                                <span
                                    class="badge bg-info p-2 rounded-circle d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px;">
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
                                <h5 class="fw-semibold mb-1">Inheritance Division</h5>
                                <small class="text-muted">Sharia-compliant distribution</small>
                            </div>
                            <i class="bx bx-pie-chart-alt fs-2 text-success"></i>
                        </div>

                        <div class="flex-grow-1">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Pending Calculation</span>
                                    <strong>{{ $pendingInheritance }}</strong>
                                </div>
                                <div class="progress mt-1" style="height:6px;">
                                    <div class="progress-bar bg-danger"
                                        style="width: {{ $totalInheritance ? ($pendingInheritance / $totalInheritance) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <span>Settled This Month</span>
                                    <strong>{{ $thisMonthInheritance }}</strong>
                                </div>
                                <div class="progress mt-1" style="height:6px;">
                                    <div class="progress-bar bg-success"
                                        style="width: {{ $totalInheritance ? ($thisMonthInheritance / $totalInheritance) * 100 : 0 }}%">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span>Total Settlements</span>
                                <strong class="text-success">{{ $totalInheritance }}</strong>
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ url('inheritance-application') }}" class="btn btn-success">Register
                                Application</a>
                            <a href="{{ url('inheritance-dashboard') }}" class="btn btn-outline-success">Manage
                                Records</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side: Nikah Registry Card -->
            <!-- Right side: Nikah Registry Card -->
            <div class="col-md-8">
                <div class="row">
                    <!-- Nikah Management -->
                    <div class="col-md-12 mb-4">
                        <div class="card h-100 border-start border-4 border-primary shadow-sm" style="border-radius:14px;">
                            <div class="card-body p-4 d-flex flex-column">
                                <!-- Card Header -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <h5 class="fw-semibold mb-1">Nikah Registry</h5>
                                        <small class="text-muted">Marriage contracts & certificates</small>
                                    </div>
                                    <i class="bx bx-heart fs-2 text-primary"></i>
                                </div>

                                <!-- Card Body: Progress Bars & Stats -->
                                <div class="flex-grow-1">
                                    <!-- Pending Review -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Pending Review</span>
                                            <strong>{{ $pendingNikah }}</strong>
                                        </div>
                                        <div class="progress mt-1" style="height:6px;">
                                            <div class="progress-bar bg-warning"
                                                style="width: {{ $totalNikah ? ($pendingNikah / $totalNikah) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Approved Today -->
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <span>Approved Today</span>
                                            <strong>{{ $approvedTodayNikah }}</strong>
                                        </div>
                                        <div class="progress mt-1" style="height:6px;">
                                            <div class="progress-bar bg-success"
                                                style="width: {{ $totalNikah ? ($approvedTodayNikah / $totalNikah) * 100 : 0 }}%">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Certificates -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Total Certificates</span>
                                        <div class="d-flex align-items-center">
                                            <strong class="text-primary me-2">{{ $totalNikah }}</strong>
                                            @if (isset($currentMonthCases) && $currentMonthCases > 0)
                                                <span class="text-success small">+{{ $currentMonthCases }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer: Actions -->
                                <div class="d-grid gap-2 mt-4">
                                    <a href="{{ url('nikah') }}" class="btn btn-primary">Register New Nikah</a>
                                    <a href="{{ url('nikah-dashboard') }}" class="btn btn-outline-primary">Manage
                                        Records</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divorce Management can go here similarly -->
                </div>
            </div>
        </div>

        <!-- Second Row of Action Cards -->
        <div class="row">
            <!-- Converts Management -->
            <!-- Converts Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-lg border-0 overflow-hidden">
                    <!-- Top indicator -->
                    <div class="position-absolute top-0 start-0 w-100 bg-info" style="height: 5px;"></div>

                    <div class="card-body d-flex flex-column p-4">
                        <!-- Header: Icon + Title -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar bg-light-info p-3 me-3 rounded-circle">
                                <i class="bx bx-user-plus fs-2 text-info"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Islamic Conversion</h5>
                                <p class="text-muted small mb-0">New Muslims Registrations</p>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Awaiting Approval</span>
                                <span class="badge bg-label-warning">{{ $pendingConverts }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Converted This Month</span>
                                <span class="badge bg-label-success">{{ $thisMonthConverts }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Converts</span>
                                <span class="badge bg-label-info">{{ $totalConverts }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ url('convert-application') }}" class="btn btn-info text-white">New
                                Declaration</a>
                            <a href="{{ url('convert-dashboard') }}" class="btn btn-outline-info">View Converts</a>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Guardianship Management -->
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-lg border-0 overflow-hidden">
                    <!-- Top indicator -->
                    <div class="position-absolute top-0 start-0 w-100 bg-danger" style="height: 5px;"></div>

                    <div class="card-body d-flex flex-column p-4">
                        <!-- Header: Icon + Title -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar bg-light-danger p-3 me-3 rounded-circle">
                                <i class="bx bx-shield-alt-2 fs-2 text-danger"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Guardianship</h5>
                                <p class="text-muted small mb-0">Wilayah & custody cases</p>
                            </div>
                        </div>

                        <!-- Stats -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Active Guardianships</span>
                                <span class="badge bg-label-primary">{{ $activeGuardianships }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Pending Review</span>
                                <span class="badge bg-label-warning">{{ $pendingGuardianships }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Appointments</span>
                                <span class="badge bg-label-danger">{{ $totalGuardianships }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <a href="{{ url('guardianship-application') }}" class="btn btn-danger">New Guardian</a>
                            <a href="{{ url('guardianship-dashboard') }}" class="btn btn-outline-danger">View Records</a>
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
                                <h5 class="card-title mb-0">Reports & Analytics</h5>
                                <p class="text-muted small mb-0">Statistics & insights</p>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="list-group list-group-flush">
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex justify-content-between">
                                        <span>Monthly Summary</span>
                                        <i class="bx bx-chevron-right"></i>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex justify-content-between">
                                        <span>Export All Data</span>
                                        <i class="bx bx-download"></i>
                                    </div>
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex justify-content-between">
                                        <span>Generate Annual Report</span>
                                        <i class="bx bx-file"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <a href="javascript:void();" class="btn btn-secondary">View Full Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">Activity Logs</h5>
                <button class="btn btn-sm text-white px-3"
                    style="background: #059568; border-radius: 8px; font-weight: 600;">View All</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-muted small fw-bold">ACTIVITY & ID</th>
                                <th class="border-0 text-muted small fw-bold">DESCRIPTION</th>
                                <th class="border-0 text-muted small fw-bold">TIMELINE</th>
                                <th class="border-0 text-muted small fw-bold">STATUS</th>
                                <th class="pe-4 border-0 text-end text-muted small fw-bold" style="width: 150px;">
                                    MANAGEMENT</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Nikah -->
                            <tr class="border-bottom border-light">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                            style="background: #05956820; width: 40px; height: 40px;">
                                            <i class="bx bx-heart fs-4" style="color: #059568;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Nikah</h6>
                                            <small class="text-muted text-uppercase"
                                                style="font-size: 10px;">#NK-1023</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">Ali & Fatima</p>
                                    <small class="text-muted">Marriage Registration</small>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small fw-bold text-dark">10 Jan 2026</span>
                                        <span class="text-muted" style="font-size: 11px;">09:45 AM</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3"
                                        style="background: #05956815; color: #059568; border: 1px solid #05956830;">Approved</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group shadow-sm action-group" role="group"
                                        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="View Details">
                                            <i class="bx bx-show-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="Edit Entry">
                                            <i class="bx bx-edit-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 text-danger"
                                            title="Delete Record">
                                            <i class="bx bx-trash-alt fs-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Inheritance -->
                            <tr class="border-bottom border-light">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                            style="background: #28a74520; width: 40px; height: 40px;">
                                            <i class="bx bx-pie-chart-alt fs-4" style="color: #28a745;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Inheritance</h6>
                                            <small class="text-muted text-uppercase"
                                                style="font-size: 10px;">#IN-5412</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">Estate of John Doe</p>
                                    <small class="text-muted">Sharia-compliant division</small>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small fw-bold text-dark">08 Jan 2026</span>
                                        <span class="text-muted" style="font-size: 11px;">11:15 AM</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3"
                                        style="background: #28a74515; color: #28a745; border: 1px solid #28a74530;">Pending</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group shadow-sm action-group" role="group"
                                        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="View Details">
                                            <i class="bx bx-show-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="Edit Entry">
                                            <i class="bx bx-edit-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 text-danger"
                                            title="Delete Record">
                                            <i class="bx bx-trash-alt fs-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Converts -->
                            <tr class="border-bottom border-light">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                            style="background: #17a2b820; width: 40px; height: 40px;">
                                            <i class="bx bx-user-plus fs-4" style="color: #17a2b8;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Converts</h6>
                                            <small class="text-muted text-uppercase"
                                                style="font-size: 10px;">#CV-3321</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">Peter Burke</p>
                                    <small class="text-muted">New Muslim Declaration</small>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small fw-bold text-dark">11 Jan 2026</span>
                                        <span class="text-muted" style="font-size: 11px;">02:20 PM</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3"
                                        style="background: #17a2b815; color: #17a2b8; border: 1px solid #17a2b830;">Approved</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group shadow-sm action-group" role="group"
                                        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="View Details">
                                            <i class="bx bx-show-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="Edit Entry">
                                            <i class="bx bx-edit-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 text-danger"
                                            title="Delete Record">
                                            <i class="bx bx-trash-alt fs-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Guardianship -->
                            <tr class="border-bottom border-light">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                            style="background: #dc354520; width: 40px; height: 40px;">
                                            <i class="bx bx-shield-alt-2 fs-4" style="color: #dc3545;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Guardianship</h6>
                                            <small class="text-muted text-uppercase"
                                                style="font-size: 10px;">#GUI-1029</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">Serena Mcguire</p>
                                    <small class="text-muted">Wilayah & Custody Case</small>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small fw-bold text-dark">11 Jan 2026</span>
                                        <span class="text-muted" style="font-size: 11px;">04:10 PM</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge rounded-pill px-3"
                                        style="background: #dc354515; color: #dc3545; border: 1px solid #dc354530;">Pending</span>
                                </td>
                                <td class="pe-4 text-end">
                                    <div class="btn-group shadow-sm action-group" role="group"
                                        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="View Details">
                                            <i class="bx bx-show-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end"
                                            title="Edit Entry">
                                            <i class="bx bx-edit-alt text-muted fs-5"></i>
                                        </button>
                                        <button type="button" class="btn btn-white btn-sm px-2 text-danger"
                                            title="Delete Record">
                                            <i class="bx bx-trash-alt fs-5"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div> --}}


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

        <script>
            document.getElementById('smartSearch').addEventListener('focus', function () {
                var suggestions = document.getElementById('searchSuggestions');
                suggestions.classList.add('show');
            });

            document.getElementById('smartSearch').addEventListener('blur', function () {
                setTimeout(function () {
                    var suggestions = document.getElementById('searchSuggestions');
                    suggestions.classList.remove('show');
                }, 200);
            });
        </script>
    </div>

    <style>
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .border-start {
            border-left-width: 4px !important;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-light-primary {
            background-color: rgba(102, 126, 234, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(255, 193, 7, 0.1);
        }

        .bg-light-success {
            background-color: rgba(40, 167, 69, 0.1);
        }

        .bg-light-info {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .bg-light-danger {
            background-color: rgba(220, 53, 69, 0.1);
        }

        .bg-light-secondary {
            background-color: rgba(108, 117, 125, 0.1);
        }

        .bg-label-primary {
            background-color: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .bg-label-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .bg-label-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .bg-label-info {
            background-color: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .bg-label-danger {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function (e) {
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') return;
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            const searchInput = document.querySelector('input[placeholder*="Search"]');
            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    performSearch();
                }
            });

            function performSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    console.log('Searching for:', query);
                }
            }
        });
    </script>
@endsection