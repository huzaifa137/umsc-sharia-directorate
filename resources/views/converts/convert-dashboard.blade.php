@extends('layouts.app')

@section('content')
    <div class="container-fluid p-4">
        <!-- Header with Islamic Theme -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="dashboard-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xl bg-white rounded-circle shadow-sm me-3">
                                    <i class="bx bx-moon fs-3" style="color:#155a15;"></i>
                                </div>
                                <div>
                                    <h1 class="h3 mb-1 text-white">New Muslim Converts Certification System</h1>
                                    <p class="text-white opacity-75 mb-0">Islamic Conversion Certificate Management System
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <div class="d-flex align-items-center justify-content-md-end">
                                <div class="me-3">
                                    <p class="text-white mb-0 small">Logged in as</p>
                                    <p class="text-white fw-semibold mb-0">Conversion Officer</p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-light rounded-circle avatar" type="button"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-user"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-4">Conversion Records Summary</h5>
                        <div class="row g-4">
                            <!-- Total Converts -->
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('convert.status.applications', ['statusId' => 100]) }}"
                                    class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm stat-card"
                                        style="border-radius:20px; background:#f0f9ff;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="text-uppercase fw-bold"
                                                        style="font-size:0.65rem; color:#0369a1;">
                                                        Total Converts
                                                    </span>
                                                    <h2 class="fw-bold mb-1 mt-2" style="color:#0c4a6e;">
                                                        {{ $stats['total_converts'] ?? '0' }}</h2>
                                                    <small class="text-muted" style="color:#0284c7;">All Converts</small>
                                                </div>
                                                <div class="icon-box"
                                                    style="background:rgba(14, 165, 233, 0.25); border-radius: 10px; padding: 8px;">
                                                    <i class="bx bx-user-plus" style="color:#0ea5e9;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Pending Verification -->
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('convert.status.applications', ['statusId' => 0]) }}"
                                    class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm stat-card"
                                        style="border-radius:20px; background:#fef7e7;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="text-uppercase fw-bold"
                                                        style="font-size:0.65rem; color:#92400e;">
                                                        Pending Verification
                                                    </span>
                                                    <h2 class="fw-bold mb-1 mt-2" style="color:#78350f;">
                                                        {{ $stats['pending'] ?? '0' }}</h2>
                                                    <small class="text-muted" style="color:#b45309;">Awaiting
                                                        approval</small>
                                                </div>
                                                <div class="icon-box"
                                                    style="background:rgba(245, 158, 11, 0.25); border-radius: 10px; padding: 8px;">
                                                    <i class="bx bx-time-five" style="color:#f59e0b;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Certificates Issued -->
                            <div class="col-md-3 col-sm-6">
                                <a href="{{ route('convert.status.applications', ['statusId' => 10]) }}"
                                    class="text-decoration-none">
                                    <div class="card h-100 border-0 shadow-sm stat-card"
                                        style="border-radius:20px; background:#f0fdf4;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="text-uppercase fw-bold"
                                                        style="font-size:0.65rem; color:#065f46;">
                                                        Certificates Issued
                                                    </span>
                                                    <h2 class="fw-bold mb-1 mt-2" style="color:#064e3b;">
                                                        {{ $accomplished ?? '0' }}</h2>
                                                    <small class="text-muted" style="color:#047857;">Certified
                                                        Converts</small>
                                                </div>
                                                <div class="icon-box"
                                                    style="background:rgba(16, 185, 129, 0.25); border-radius: 10px; padding: 8px;">
                                                    <i class="bx bx-trophy" style="color:#10b981;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- Conversion Sources -->
                            <div class="col-md-3 col-sm-6">
                                <a href="#conversionSources">
                                    <div class="card h-100 border-0 shadow-sm stat-card"
                                        style="border-radius:20px; background:#eff6ff;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <span class="text-uppercase fw-bold"
                                                        style="font-size:0.65rem; color:#3730a3;">
                                                        Conversion Sources
                                                    </span>
                                                    <h2 class="fw-bold mb-1 mt-2" style="color:#312e81;">
                                                        {{ $stats['sources'] ?? '8' }}</h2>
                                                    <small class="text-muted" style="color:#4f46e5;">Different
                                                        religions</small>
                                                </div>
                                                <div class="icon-box"
                                                    style="background:rgba(99, 102, 241, 0.25); border-radius: 10px; padding: 8px;">
                                                    <i class="bx bx-globe" style="color:#6366f1;"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Actions Grid - Gradient Style -->
        <div class="row mb-4">
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100 overflow-hidden"
                    style="border-radius: 20px; border-left: 5px solid #4f46e5;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-wrapper me-3"
                                style="background: linear-gradient(100deg, #0bd2f5 0%, #0967b4 100%); border-radius: 12px; padding: 12px;">
                                <i class="bx bx-user-plus text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1 fw-bold text-dark">Register New Convert</h5>
                                <p class="text-muted small mb-0">Register a new convert with complete Islamic conversion
                                    details</p>
                            </div>
                        </div>

                        <div class="mt-auto pt-3">
                            <div class="d-grid">
                                <a href="{{ route('convert.application') }}" class="btn btn-lg text-white fw-semibold"
                                    style="background: linear-gradient(100deg, #0bd2f5 0%, #0967b4 100%); border: none; border-radius: 12px; padding: 12px;">
                                    <i class="bx bx-plus me-2"></i>New Registration
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 mb-4" id="conversionSources">
                <div class="card border-0 shadow-sm h-100 overflow-hidden"
                    style="border-radius: 20px; border-left: 5px solid #0891b2;">
                    <div class="card-body p-4 d-flex flex-column">
                        <div class="d-flex align-items-start mb-3">
                            <div class="icon-wrapper me-3"
                                style="background: linear-gradient(135deg, #155a15 0%, #b7e5b7 100%); border-radius: 12px; padding: 12px;">
                                <i class="bx bx-search-alt text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1 fw-bold text-dark">Search & Verify</h5>
                                <p class="text-muted small mb-0">Search convert records and verify conversion details</p>
                            </div>
                        </div>

                        <div class="mt-auto pt-3">
                            <div class="d-grid">
                                <a href="{{ route('convert.status.applications', ['statusId' => 100]) }}"
                                    class="btn btn-lg text-white fw-semibold"
                                    style="background: linear-gradient(135deg, #155a15 0%, #b7e5b7 100%); border: none; border-radius: 12px; padding: 12px;">
                                    <i class="bx bx-search me-2"></i>Search Records
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Converts & Statistics -->
        <div class="row">
            <div class="col-lg-12 mb-4">

                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                        <!-- Search Bar -->
                        <div class="w-100 me-4">
                            <div class="position-relative" style="max-width: 500px;">
                                <div class="input-group"
                                    style="
                    background: white;
                    border-radius: 12px;
                    border: 1px solid #e2e8f0;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                    padding: 8px;
                    transition: all 0.3s ease;
                "
                                    onmouseover="this.style.boxShadow='0 6px 25px rgba(0, 0, 0, 0.08)'">
                                    <!-- Search Icon -->
                                    <span class="input-group-text border-0 bg-transparent" style="padding-left: 15px;">
                                        <i class="bx bx-search-alt-2" style="color:#059568; font-size: 1.2rem;"></i>
                                    </span>

                                    <!-- Search Input -->
                                    <input type="text" id="searchInput" class="form-control border-0 px-0"
                                        placeholder="Search by ID, names, status…"
                                        style="
                                        background: transparent;
                                        color: #1a202c;
                                        font-weight: 600;
                                        padding: 8px 0;
                                        height: auto;
                                    ">

                                    <!-- Search Label -->
                                    <label class="position-absolute"
                                        style="
                                        top: -10px;
                                        left: 50px;
                                        background: white;
                                        padding: 0 10px;
                                        font-size: 0.8rem;
                                        color: #059568;
                                        font-weight: 600;
                                        letter-spacing: 0.5px;
                                    ">
                                        Search Records
                                    </label>

                                    <!-- Search Actions -->
                                    <div class="d-flex align-items-center gap-2" style="padding-right: 15px;">
                                        <!-- Clear Button -->
                                        <button class="btn btn-sm p-1" id="clearSearch"
                                            style="
                                            background: #059568;
                                            color: #FFF;
                                            border-radius: 8px;
                                            width: 32px;
                                            height: 32px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        "
                                            onmouseover="this.style.background='#059568'"
                                            onmouseout="this.style.background='#059568'">
                                            <i class="bx bx-x" style="font-size: 1.1rem;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dashboard Link - FIXED -->
                        <a href="{{ route('convert.status.applications', ['statusId' => 100]) }}"
                            class="text-decoration-none d-flex align-items-center text-primary fw-bold text-nowrap"
                            style="
            background: #f0fdf4;
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid rgba(5, 149, 104, 0.2);
            transition: all 0.3s ease;
            white-space: nowrap;
            flex-shrink: 0;
            margin-left: 16px;
        "
                            onmouseover="this.style.background='#dcfce7'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(5, 149, 104, 0.1)'"
                            onmouseout="this.style.background='#f0fdf4'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            <i class="bx bx-home fs-4 me-2" style="color:#059568;"></i>
                            <span style="color:#065f46;">View all Conversion Records</span>
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 border-0 text-muted small fw-bold text-center">
                                            ACTIVITY & ID
                                        </th>
                                        <th class="border-0 text-muted small fw-bold text-center">
                                            FORMER NAMES
                                        </th>
                                        <th class="border-0 text-muted small fw-bold text-center">
                                            NEW NAMES
                                        </th>
                                        <th class="border-0 text-muted small fw-bold text-center">
                                            TIMELINE
                                        </th>
                                        <th class="border-0 text-muted small fw-bold text-center">
                                            STATUS
                                        </th>
                                        <th class="pe-4 border-0 text-muted small fw-bold text-center"
                                            style="width: 150px;">
                                            MANAGEMENT
                                        </th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @forelse ($applications as $application)
                                        <tr class="border-bottom border-light application-row"
                                            data-search="
                                        {{ strtolower($application->application_id) }}
                                        {{ strtolower($application->former_names) }}
                                        {{ strtolower($application->new_names) }}
                                        {{ strtolower($application->created_at) }}
                                        {{ strtolower($application->status) }}
                                    ">

                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                                        style="background: #05956820; width: 40px; height: 40px;">
                                                        <i class="bx bx-heart fs-4" style="color: #059568;"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-bold">Converts</h6>
                                                        <small class="text-muted text-uppercase"
                                                            style="font-size: 10px; letter-spacing: 0.5px;">
                                                            #{{ $application->application_id }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">
                                                    {{ trim($application->former_names) }}
                                                </p>
                                                <small class="text-muted">Former names</small>
                                            </td>

                                            <td>
                                                <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">
                                                    {{ trim($application->new_names) }}
                                                </p>
                                                <small class="text-muted">New names</small>
                                            </td>


                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span class="small fw-bold text-dark">
                                                        {{ $application->created_at }}
                                                    </span>
                                                    <span class="text-muted" style="font-size: 11px;">
                                                        <p>Date & Time</p>
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'approved' => ['#05956815', '#059568'], // green
                                                        'pending' => ['#FFF7E6', '#FF9F43'], // yellow
                                                        'rejected' => ['#FFE5E5', '#EA5455'], // red
                                                    ];

                                                    // Map 'submitted' to 'pending' for color purposes
                                                    $statusKey =
                                                        $application->status === 'submitted'
                                                            ? 'pending'
                                                            : $application->status;

                                                    $bg = $statusColors[$statusKey][0] ?? '#E7F3FF';
                                                    $color = $statusColors[$statusKey][1] ?? '#0D6EFD';
                                                @endphp

                                                <span class="badge rounded-pill px-3"
                                                    style="background: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                                    {{ $application->status === 'submitted' ? 'Pending' : ucfirst($application->status) }}
                                                </span>

                                                 @include('layouts.views.converts-action')
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bx bx-folder-open fs-1 mb-2"></i>
                                                <p class="mb-0">No Nikah applications found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="mt-4 me-4">
                                {{ $applications->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Conversion Sources Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="mb-3">Former Religions</h6>

                        @foreach ($stats['religions'] as $religion => $percentage)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1 text-capitalize">
                                    <span>{{ $religion }}</span>
                                    <span>{{ $percentage }}%</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    @php
                                        // Choose color dynamically based on religion
                                        $colors = [
                                            'christianity' => 'bg-primary',
                                            'traditional' => 'bg-success',
                                            'islam' => 'bg-warning',
                                            'buddhist' => 'bg-info',
                                            'other' => 'bg-secondary',
                                        ];
                                        $color = $colors[$religion] ?? 'bg-dark';
                                    @endphp
                                    <div class="progress-bar {{ $color }}" style="width: {{ $percentage }}%">
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <style>
        .dashboard-header {
            background: linear-gradient(180deg, #155a15 0%, #263b26 100%);
            border-radius: 16px;
            padding: 2rem;
            color: white;
            box-shadow: 0 4px 20px rgba(14, 165, 233, 0.3);
        }

        .metric-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .metric-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .action-card {
            transition: transform 0.3s ease;
            border-radius: 16px;
            overflow: hidden;
        }

        .action-card:hover {
            transform: translateY(-8px);
        }

        .action-card .action-icon {
            width: 64px;
            height: 64px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .action-card:nth-child(1) .action-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        }

        .action-card:nth-child(2) .action-icon {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .action-card:nth-child(3) .action-icon {
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
        }

        .field-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
        }

        .field-card:hover {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
            transform: translateY(-2px);
        }

        .field-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .bg-light-primary {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(245, 158, 11, 0.1);
        }

        .bg-light-success {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bg-light-info {
            background-color: rgba(14, 165, 233, 0.1);
        }

        .avatar {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: #f3f4f6;
        }

        .avatar-xs {
            width: 32px;
            height: 32px;
            font-size: 0.875rem;
        }

        .badge {
            padding: 0.35em 0.65em;
            font-weight: 500;
        }

        .progress {
            background-color: #f3f4f6;
        }

        .progress-bar {
            border-radius: 3px;
        }

        .btn-lg {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
        }

        .table th {
            font-weight: 600;
            color: #4b5563;
            border-top: none;
            border-bottom: 2px solid #f3f4f6;
            padding: 1rem;
        }

        .table td {
            vertical-align: middle;
            border-color: #f3f4f6;
            padding: 1rem;
        }

        .list-unstyled li {
            padding: 0.125rem 0;
            color: #6b7280;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animate metric numbers
            const metrics = document.querySelectorAll('.metric-card h2');
            metrics.forEach(metric => {
                const text = metric.textContent;
                if (text !== '0' && !isNaN(text.replace(/,/g, ''))) {
                    const finalValue = parseInt(text.replace(/,/g, ''));
                    metric.textContent = '0';
                    let current = 0;
                    const increment = finalValue / 30;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= finalValue) {
                            metric.textContent = finalValue.toLocaleString();
                            clearInterval(timer);
                        } else {
                            metric.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 40);
                }
            });

            // Add hover effects
            const cards = document.querySelectorAll('.metric-card, .action-card, .field-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.zIndex = '10';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.zIndex = '';
                });
            });

            // Update progress bars
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                    bar.style.transition = 'width 1.5s ease-in-out';
                }, 300);
            });
        });
    </script>

    <script>
        document.getElementById('clearSearch').addEventListener('click', function() {
            const input = document.getElementById('searchInput');
            input.value = '';
            input.dispatchEvent(new Event('keyup'));
        });
    </script>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('.application-row');

            rows.forEach(row => {
                const searchableText = row.getAttribute('data-search');
                if (searchableText.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
