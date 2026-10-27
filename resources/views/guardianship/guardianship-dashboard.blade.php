@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-2">Guardianship Applications</h4>
                <p class="text-muted mb-4">Manage all guardianship applications efficiently</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <!-- Stats Cards - Glassmorphism Option (Adapted Height) -->
        <div class="row mb-4">
            @php
                $statsCards = [
                    [
                        'label' => 'TOTAL APPLICATIONS',
                        'label_color' => '#3b82f6',
                        'value' => $stats['total'],
                        'statusId' => 100,
                        'color' => '#3b82f6',
                        'gradient' => '#3b82f6',
                        'icon' => 'bx bx-folder-open',
                        'sub' => 'All Submitted Applications',
                        'trend' => '100%',
                        'percentage' => 100,
                    ],
                    [
                        'label' => 'PENDING REVIEW',
                        'value' => $stats['pending'],
                        'color' => '#f59e0b',
                        'statusId' => 0,
                        'gradient' => '#f59e0b',
                        'icon' => 'bx bx-time-five',
                        'sub' => 'Awaiting Processing',
                        'trend' => '100%',
                        'percentage' => 25,
                    ],
                    [
                        'label' => 'APPROVED',
                        'statusId' => 10,
                        'value' => $stats['approved'],
                        'color' => '#10b981',
                        'gradient' => '#10b981',
                        'icon' => 'bx bx-check-circle',
                        'sub' => 'Successfully Approved',
                        'trend' => '100%',
                        'percentage' => 100,
                    ],
                    [
                        'label' => 'REJECTED',
                        'statusId' => -10,
                        'value' => $stats['rejected'],
                        'color' => '#ef4444',
                        'gradient' => '#ef4444',
                        'icon' => 'bx bx-x-circle',
                        'sub' => 'Declined Applications',
                        'trend' => '100%',
                        'percentage' => 100,
                    ],
                ];
            @endphp

            @foreach ($statsCards as $stat)
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="{{ route('guardianship.status.applications', ['statusId' => $stat['statusId']]) }}"
                        class="text-decoration-none">
                        <div class="glass-card-container position-relative" style="height: 180px; perspective: 1000px;">
                            <div class="glass-card h-100"
                                style="transform-style: preserve-3d;
                            transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
                            cursor: pointer;"
                                onmouseenter="this.style.transform='translateY(-10px) rotateY(5deg) rotateX(2deg)';"
                                onmouseleave="this.style.transform='translateY(0) rotateY(0) rotateX(0)';">

                                <div class="position-absolute w-100 h-100 glass-surface"
                                    style="backface-visibility: hidden;
                                background: rgba(255, 255, 255, 0.1);
                                backdrop-filter: blur(20px);
                                border: 1px solid rgba(255, 255, 255, 0.2);
                                border-radius: 20px;
                                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1),
                                            0 0 0 1px rgba(0, 0, 0, 0.05);
                                overflow: hidden;">

                                    <!-- Animated border -->
                                    <div class="position-absolute top-0 start-0 w-100 h-100 border-animation"
                                        style="border-radius: 20px; padding: 2px;">
                                        <div class="w-100 h-100"
                                            style="background: {{ $stat['color'] }};
                                        border-radius: 20px;
                                        animation: rotate 3s linear infinite;
                                        opacity: 0.5;">
                                        </div>
                                    </div>

                                    <!-- Blurred background shape -->
                                    <div class="position-absolute bottom-0 end-0 w-50 h-50 rounded-circle"
                                        style="background: {{ $stat['color'] }};
                                    filter: blur(40px);
                                    transform: translate(30%, 30%);
                                    z-index: 0;">
                                    </div>

                                    <!-- Side accent -->
                                    <div class="position-absolute top-0 start-0 h-100 w-3"
                                        style="background: {{ $stat['gradient'] }};
                                    border-radius: 20px 0 0 20px;">
                                    </div>

                                    <div
                                        class="card-body p-4 position-relative z-1 h-100 d-flex flex-column justify-content-between">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <span class="text-uppercase fw-bold d-block mb-1"
                                                    style="font-size: 0.65rem; letter-spacing: 1.2px; color: rgba(0, 0, 0, 0.8);">
                                                    {{ $stat['label'] }}
                                                </span>
                                                <div class="mt-1">
                                                    <span class="badge rounded-pill px-3 py-1"
                                                        style="background: rgba(255, 255, 255, 0.2); 
                                                     color: {{ $stat['color'] }};
                                                     backdrop-filter: blur(5px);
                                                     border: 1px solid rgba(255, 255, 255, 0.1);">
                                                        {{ $stat['trend'] }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="glass-icon d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px; 
                                            background: rgba(255, 255, 255, 0.2);
                                            backdrop-filter: blur(10px);
                                            border: 1px solid rgba(255, 255, 255, 0.3);
                                            border-radius: 14px;
                                            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                                            transition: all 0.3s ease;">
                                                <i class="{{ $stat['icon'] }} bx-lg"
                                                    style="color: {{ $stat['color'] }};"></i>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="d-flex align-items-end">
                                                <h2 class="fw-bold mb-0 display-5" style="color: {{ $stat['color'] }};">
                                                    {{ $stat['value'] }}
                                                </h2>
                                            </div>

                                            <!-- Progress ring (glass version) -->
                                            <div class="mt-3 position-relative" style="width: 80px; height: 80px;">
                                                <svg class="glass-progress-ring" width="80" height="80">
                                                    <circle cx="40" cy="40" r="35"
                                                        stroke="rgba(255, 255, 255, 0.2)" stroke-width="4" fill="none" />
                                                    <circle cx="40" cy="40" r="35"
                                                        stroke="{{ $stat['color'] }}" stroke-width="4" fill="none"
                                                        stroke-linecap="round" stroke-dasharray="220"
                                                        stroke-dashoffset="{{ 220 - (220 * $stat['percentage']) / 100 }}" />
                                                </svg>
                                                <div class="position-absolute top-50 start-50 translate-middle text-center">
                                                    <small class="fw-bold" style="color: {{ $stat['color'] }};">
                                                        {{ $stat['percentage'] }}%
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-between align-items-center mt-2">
                                            <small class="fw-medium" style="color: rgba(255, 255, 255, 0.7);">
                                                {{ $stat['sub'] }}
                                            </small>

                                            <div class="glass-arrow d-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px; 
                                            background: rgba(255, 255, 255, 0.2);
                                            backdrop-filter: blur(5px);
                                            border: 1px solid rgba(255, 255, 255, 0.3);
                                            border-radius: 10px;
                                            transition: all 0.3s ease;">
                                                <i class="bx bx-chevron-right bx-sm"
                                                    style="color: {{ $stat['color'] }};"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <style>
            @keyframes rotate {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .glass-card:hover .glass-icon {
                transform: translateY(-5px) rotate(10deg);
                background: rgba(255, 255, 255, 0.3);
                border-color: rgba(255, 255, 255, 0.4);
                box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2),
                    0 10px 10px rgba(0, 0, 0, 0.1);
            }

            .glass-card:hover .glass-arrow {
                transform: translateX(8px);
                background: rgba(255, 255, 255, 0.3);
                box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            }

            .glass-progress-ring circle {
                transition: stroke-dashoffset 0.35s ease;
                transform: rotate(-90deg);
                transform-origin: 50% 50%;
            }

            .border-animation {
                mask: #fff content-box, #fff;
                mask-composite: exclude;
                -webkit-mask: #fff content-box, #fff;
                -webkit-mask-composite: xor;
            }

            /* Mouse tracking effect */
            .glass-card {
                position: relative;
            }

            .glass-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.1);
                border-radius: 20px;
                opacity: 0;
                transition: opacity 0.3s ease;
                pointer-events: none;
                z-index: 1;
            }

            .glass-card:hover::before {
                opacity: 1;
            }

            @media (max-width: 768px) {
                .glass-card-container {
                    height: 160px;
                }

                .glass-card-container .display-5 {
                    font-size: 2rem !important;
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const glassCards = document.querySelectorAll('.glass-card');

                glassCards.forEach(card => {
                    card.addEventListener('mousemove', function(e) {
                        const rect = this.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;

                        const centerX = rect.width / 2;
                        const centerY = rect.height / 2;

                        const rotateY = ((x - centerX) / centerX) * 5;
                        const rotateX = ((centerY - y) / centerY) * 3;

                        this.style.transform =
                            `translateY(-10px) rotateY(${rotateY}deg) rotateX(${rotateX}deg)`;

                        // Update mouse position for gradient effect
                        const mouseX = (x / rect.width) * 100;
                        const mouseY = (y / rect.height) * 100;
                        this.style.setProperty('--mouse-x', `${mouseX}%`);
                        this.style.setProperty('--mouse-y', `${mouseY}%`);
                    });

                    card.addEventListener('mouseleave', function() {
                        this.style.transform = 'translateY(0) rotateY(0) rotateX(0)';
                        this.style.removeProperty('--mouse-x');
                        this.style.removeProperty('--mouse-y');
                    });
                });
            });
        </script>

        <!-- Action Buttons -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div
                            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-4">
                            <!-- Title Section -->
                            <div class="d-flex align-items-center gap-3">
                                <div class="text-center">
                                    <div class="bg-opacity-10 p-3 rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="background-color:#008F4C; width: 60px; height: 60px;">
                                        <i class="bx bx-user-check fs-3 text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="mb-1 fw-semibold">Guardianship Records</h4>
                                    <p class="text-muted mb-0">
                                        <i class="bx bx-layer fs-6 me-1"></i>
                                        {{ $applications->count() }} Total Applications
                                    </p>
                                </div>
                            </div>

                            <!-- Actions Section -->
                            <div class="d-flex flex-wrap gap-3">
                                <!-- Quick Stats -->
                                <div class="d-flex flex-wrap gap-3 me-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                            <i class="bx bx-time me-1"></i>
                                            {{ $applications->where('status', 'pending')->count() }} Pending
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                            <i class="bx bx-check-circle me-1"></i>
                                            {{ $applications->where('status', 'approved')->count() }} Approved
                                        </span>
                                    </div>
                                </div>

                                <!-- Primary Action -->
                                <a href="{{ url('guardianship-application') }}"
                                    class="btn btn-lg px-4 rounded-pill text-white" style="background-color: #008F4C;">
                                    <i class="bx bx-plus me-2"></i> New Application
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Applications Grid -->

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach ($applications as $application)
                @php
                    $statusColor = match ($application->status) {
                        'submitted' => 'warning',
                        'accomplished' => 'success',
                        'rejected' => 'danger',
                        default => 'primary',
                    };

                    $progressValue = match ($application->status) {
                        'submitted' => '100%',
                        'accomplished' => '100%',
                        'rejected' => '100%',
                        default => '0%',
                    };
                @endphp

                <div class="col">
                    <div class="card h-100 shadow-sm border-0 hover-lift transition-all">
                        <!-- Card Header -->
                        <div class="card-header bg-white border-bottom-0 pt-3 pb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="badge bg-label-{{ $statusColor }} rounded-pill px-3 py-1 fw-semibold">
                                   {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                </div>

                                <div class="d-flex gap-2">
                                                                     

                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body pt-2">
                            <!-- Ward Info -->
                            <div class="d-flex align-items-start mb-4">
                                @if ($application->ward_photo_path)
                                    <div class="avatar avatar-xl me-3 position-relative">
                                        <img src="{{ Storage::url($application->ward_photo_path) }}"
                                            alt="{{ $application->ward_name }}"
                                            class="rounded-circle border border-3 border-white shadow-sm">
                                    </div>
                                @else
                                    <div
                                        class="avatar avatar-xl me-3 bg-light-primary rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bx bx-child fs-3 text-primary"></i>
                                    </div>
                                @endif

                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-semibold text-dark">{{ $application->ward_name }}</h5>

                                    <div class="d-flex align-items-center text-muted mb-2">
                                        <div class="d-flex align-items-center me-3">
                                            <i class="bx bx-cake bx-xs me-1"></i>
                                            <span class="small">{{ $application->ward_age }} years</span>
                                        </div>
                                        <span class="text-muted mx-1">•</span>
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-male-female bx-xs me-1"></i>
                                            <span class="small">{{ ucfirst($application->ward_gender) }}</span>
                                        </div>
                                    </div>

                                    <div class="bg-light rounded px-2 py-1 d-inline-block">
                                        <small class="text-muted fw-medium">{{ $application->application_id }}</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Guardian Info -->
                            <div class="mb-4 p-3 bg-light-subtle rounded">
                                <div class="d-flex align-items-center">
                                    @if ($application->guardian_photo_path)
                                        <div class="avatar avatar-sm me-3">
                                            <img src="{{ Storage::url($application->guardian_photo_path) }}"
                                                alt="{{ $application->guardian_name }}"
                                                class="rounded-circle border border-2 border-white">
                                        </div>
                                    @else
                                        <div
                                            class="avatar avatar-sm me-3 bg-light-success rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="bx bx-user fs-5 text-success"></i>
                                        </div>
                                    @endif

                                    <div class="flex-grow-1">
                                        <h6 class="mb-1 fw-semibold">{{ $application->guardian_name }}</h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <p class="mb-0 text-muted small">
                                                <i class="bx bx-phone me-1"></i>{{ $application->guardian_phone }}
                                            </p>
                                            <span class="badge bg-light text-dark small px-2 py-1">
                                                {{ ucfirst($application->relationship_to_ward) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="bg-light-subtle p-3 rounded text-center border">
                                        <small class="text-muted d-block mb-1">Type</small>
                                        <strong class="text-dark">{{ ucfirst($application->guardianship_type) }}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light-subtle p-3 rounded text-center border">
                                        <small class="text-muted d-block mb-1">Submitted</small>
                                        <strong class="text-dark">{{ $application->created_at->format('M d') }}</strong>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    @if ($application->status == 'submitted')
                                        <small class="text-muted fw-medium">Pending Approval</small>
                                        <small class="fw-semibold text-{{ $statusColor }}">
                                            {{ $progressValue }}
                                        </small>
                                    @elseif($application->status == 'accomplished')
                                        <small class="text-muted fw-medium">Application Approved</small>
                                        <small class="fw-semibold text-{{ $statusColor }}">
                                            {{ $progressValue }}
                                        </small>
                                    @elseif($application->status == 'rejected')
                                        <small class="text-muted fw-medium">Application Terminated</small>
                                        <small class="fw-semibold text-{{ $statusColor }}">
                                            {{ $progressValue }}
                                        </small>
                                    @endif

                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-{{ $statusColor }} rounded-pill"
                                        style="width: {{ $progressValue }}" role="progressbar"
                                        aria-valuenow="{{ str_replace('%', '', $progressValue) }}" aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="card-footer bg-transparent border-top-0 pt-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted small">
                                    <i class="bx bx-calendar me-1"></i>
                                    {{ $application->created_at->format('M d, Y') }}
                                </small>
                                <a href="{{url('guardianship-status-applications/100')}}" class="btn btn-sm btn-primary px-3 rounded-pill fw-medium">
                                    View Details <i class="bx bx-chevron-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Pagination -->
        @if ($applications->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <div class="mt-4 me-4">
                        {{ $applications->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 mt-1">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <div class="p-3 rounded-circle me-3" style="background: #00580f;">
                                    <i class="bx bx-file text-white fs-4"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Report Exports</h6>
                                    <p class="text-muted small mb-0">Filter Guardianship records and export a certified report</p>
                                </div>
                            </div>
                            <a href="{{ url('reports/guardianship') }}" class="btn fw-bold" style="background: #00580f; color: white;">
                                <i class="bx bxs-file-pdf me-1"></i> Open Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <style>
        .hover-shadow:hover {
            transform: translateY(-4px);
            transition: transform 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .timeline {
            position: relative;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e9ecef;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-marker {
            position: absolute;
            left: -1.75rem;
            top: 0.5rem;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 3px solid #fff;
            z-index: 1;
        }

        .timeline-content {
            margin-left: 0.5rem;
        }
    </style>
@endsection
