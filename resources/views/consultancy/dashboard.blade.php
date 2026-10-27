@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row align-items-center mb-5">
        <div class="col-md-7">
            <h3 class="fw-extra-bold mb-1" style="color: #1a202c; letter-spacing: -0.5px;">
                <span style="color: #059568;">Consultancy Dashboard</span>
            </h3>
            <p class="text-dark fw-bold mb-0">
                Full administrative oversight of consultancy requests, guidance, and activities.
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <!-- TOTAL -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index') }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#f0fdf4;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#065f46;">
                                Total Consultations
                            </span>
                            <div class="icon-box" style="background:rgba(5, 149, 104, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-message-square-detail" style="color:#059568;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#065f46;">{{ $stats['total'] }}</h2>
                        <small class="text-muted" style="color:#047857;">All requests</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- SUBMITTED -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index', ['status' => 'submitted']) }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#E3F2FD;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#0d47a1;">
                                Submitted
                            </span>
                            <div class="icon-box" style="background:rgba(21, 101, 192, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-time-five" style="color:#1565C0;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#0d47a1;">{{ $stats['submitted'] }}</h2>
                        <small class="text-muted" style="color:#1565C0;">Awaiting review</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- UNDER REVIEW -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index', ['status' => 'under_review']) }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#FFF3E0;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#e65100;">
                                Under Review
                            </span>
                            <div class="icon-box" style="background:rgba(230, 81, 0, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-search-alt" style="color:#E65100;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#e65100;">{{ $stats['under_review'] }}</h2>
                        <small class="text-muted" style="color:#E65100;">Being examined</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- APPROVED -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index', ['status' => 'approved']) }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#E8F5E9;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#1b5e20;">
                                Approved
                            </span>
                            <div class="icon-box" style="background:rgba(46, 125, 50, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-check-circle" style="color:#2E7D32;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#1b5e20;">{{ $stats['approved'] }}</h2>
                        <small class="text-muted" style="color:#2E7D32;">Completed & signed</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Second Row: Reviewed, Rejected, Accomplished -->
    <div class="row mb-4">
        <!-- REVIEWED -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index', ['status' => 'reviewed']) }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#F3E5F5;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#4a148c;">
                                Reviewed
                            </span>
                            <div class="icon-box" style="background:rgba(106, 27, 154, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-check-square" style="color:#6A1B9A;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#4a148c;">{{ $stats['reviewed'] }}</h2>
                        <small class="text-muted" style="color:#6A1B9A;">Guidance provided</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- REJECTED -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index', ['status' => 'rejected']) }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#FFEBEE;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#b71c1c;">
                                Rejected
                            </span>
                            <div class="icon-box" style="background:rgba(198, 40, 40, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-x-circle" style="color:#C62828;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#b71c1c;">{{ $stats['rejected'] }}</h2>
                        <small class="text-muted" style="color:#C62828;">Declined requests</small>
                    </div>
                </div>
            </a>
        </div>

        <!-- ACCOMPLISHED -->
        <div class="col-lg-3 col-md-6 mb-4">
            <a href="{{ route('consultancy.index', ['status' => 'accomplished']) }}">
                <div class="card h-100 border-0 shadow-sm stat-card" style="border-radius:20px; background:#ECEFF1;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#37474f;">
                                Accomplished
                            </span>
                            <div class="icon-box" style="background:rgba(55, 71, 79, 0.25); border-radius: 10px; padding: 8px;">
                                <i class="bx bx-check-double" style="color:#37474F;"></i>
                            </div>
                        </div>
                        <h2 class="fw-bold text-dark" style="color:#37474f;">{{ $stats['accomplished'] }}</h2>
                        <small class="text-muted" style="color:#37474F;">Fully completed</small>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <style>
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.08) !important;
        }
        .icon-box {
            transition: transform 0.3s ease;
        }
        .stat-card:hover .icon-box {
            transform: scale(1.1);
        }
    </style>

    <div class="row g-4">
        <!-- LEFT CARD: Records Management -->
        <div class="col-xl-6 col-lg-6 d-flex">
            <div class="card border-0 shadow-sm overflow-hidden w-100 d-flex flex-column"
                style="border-radius:16px; background: #ffffff;">
                <div class="card-body p-4 d-flex flex-column flex-fill">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2 rounded-circle me-3" style="background: #05956810;">
                            <i class="bx bx-file fs-4" style="color: #059568;"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Consultancy Records Management</h5>
                    </div>

                    <a href="{{ route('consultancy.index', ['status' => 'submitted']) }}"
                        class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                        style="transition: all 0.2s ease;">
                        <span class="text-primary fw-bold">Submitted</span>
                        <span class="badge bg-primary text-white fw-bold">{{ $stats['submitted'] }}</span>
                    </a>

                    <a href="{{ route('consultancy.index', ['status' => 'under_review']) }}"
                        class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                        style="transition: all 0.2s ease;">
                        <span class="text-warning fw-bold">Under Review</span>
                        <span class="badge bg-warning text-dark fw-bold">{{ $stats['under_review'] }}</span>
                    </a>

                    <a href="{{ route('consultancy.index', ['status' => 'reviewed']) }}"
                        class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                        style="transition: all 0.2s ease;">
                        <span class="text-purple fw-bold" style="color:#6A1B9A;">Reviewed</span>
                        <span class="badge bg-purple text-white fw-bold" style="background:#6A1B9A;">{{ $stats['reviewed'] }}</span>
                    </a>

                    <a href="{{ route('consultancy.index', ['status' => 'approved']) }}"
                        class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                        style="transition: all 0.2s ease;">
                        <span class="text-success fw-bold">Approved</span>
                        <span class="badge bg-success text-white fw-bold">{{ $stats['approved'] }}</span>
                    </a>

                    <a href="{{ route('consultancy.index', ['status' => 'rejected']) }}"
                        class="d-flex justify-content-between align-items-center py-2 px-3 mb-3 border-bottom border-light text-decoration-none rounded hover-shadow"
                        style="transition: all 0.2s ease;">
                        <span class="text-danger fw-bold">Rejected</span>
                        <span class="badge bg-danger text-white fw-bold">{{ $stats['rejected'] }}</span>
                    </a>

                    <div class="row g-2 mt-auto">
                        <div class="col-12">
                            <a href="{{ route('consultancy.index') }}"
                                class="btn btn-sm w-100 py-2 text-white fw-bold d-flex align-items-center justify-content-center text-decoration-none"
                                style="background: #059568; border-radius:8px; border: none; transition: all 0.3s ease;"
                                onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(5, 149, 104, 0.3)'"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                <i class="bx bx-list-check me-2" style="font-size: 1.1rem;"></i>
                                View All Consultancy Records
                            </a>
                        </div>
                    </div>
                </div>
                <style>
                    .hover-shadow:hover {
                        background-color: #f9fafb;
                        transform: translateY(-1px);
                        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
                    }
                </style>
            </div>
        </div>

        <!-- RIGHT CARD: Report Exports -->
        <div class="col-xl-6 col-lg-6 d-flex">
            <div class="card border-0 shadow-lg w-100"
                style="border-radius:16px; background:#1a202c; overflow: hidden;">
                <div class="card-body p-4">
                    <h5 class="text-white fw-bold mb-4">Report Exports</h5>

                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ url('reports/consultancy') }}" class="text-decoration-none d-block text-center p-3"
                                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; cursor: pointer;">
                                <i class="bx bxs-file-pdf mb-2" style="color: #ff4d4d; font-size: 2.5rem;"></i>
                                <p class="text-white mb-0 fw-bold" style="font-size: 0.8rem;">PDF</p>
                                <small class="text-white-50" style="font-size: 0.65rem;">Filter & Export</small>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ url('reports/consultancy') }}" class="text-decoration-none d-block text-center p-3"
                                style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; cursor: pointer;">
                                <i class="bx bxs-file-export mb-2" style="color: #059568; font-size: 2.5rem;"></i>
                                <p class="text-white mb-0 fw-bold" style="font-size: 0.8rem;">REPORTS</p>
                                <small class="text-white-50" style="font-size: 0.65rem;">View All Formats</small>
                            </a>
                        </div>
                    </div>

                    <p class="text-white-50 small mt-4 mb-0 text-center" style="font-style: italic;">
                        Download certified summaries for consultancy records.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; }
    .fw-extra-bold { font-weight: 800; }
    .bg-soft-dark { background: #e2e8f0; }
    .text-purple { color: #6A1B9A; }
    .bg-purple { background: #6A1B9A; }
</style>
@endsection