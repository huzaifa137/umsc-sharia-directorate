@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row align-items-center mb-5">
            <div class="col-md-7">
                <h3 class="fw-extra-bold mb-1" style="color: #1a202c; letter-spacing: -0.5px;"><span
                        style="color: #059568;">Nikkah Dashboard</span></h3>
                <p class="text-dark fw-bold mb-0">
                    Full administrative oversight of Nikkah events, records, and activities.
                </p>

            </div>
        </div>
        <div class="row mb-4">

            <!-- TOTAL NIKAH -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('nikah.status.applications', ['statusId' => 100]) }}">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius:20px; background:#f0fdf4;">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#065f46;">
                                    Total Nikah
                                </span>
                                <div class="icon-box"
                                    style="background:rgba(5, 149, 104, 0.25); border-radius: 10px; padding: 8px;">
                                    <i class="bx bx-heart" style="color:#059568;"></i>
                                </div>
                            </div>

                            <h2 class="fw-bold text-dark" style="color:#065f46;">{{ $totalNikah }}</h2>
                            <small class="text-muted" style="color:#047857;">All applications</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Pending -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('nikah.status.applications', ['statusId' => 0]) }}">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius:20px; background:#fef9e7;">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#92400e;">
                                    Pending
                                </span>
                                <div class="icon-box"
                                    style="background:rgba(245, 158, 11, 0.25); border-radius: 10px; padding: 8px;">
                                    <i class="bx bx-time-five" style="color:#d97706;"></i>
                                </div>
                            </div>

                            <h2 class="fw-bold text-dark" style="color:#92400e;">{{ $submittedNikah }}</h2>
                            <small class="text-muted" style="color:#b45309;">Awaiting review</small>

                        </div>
                    </div>
                </a>
            </div>

            <!-- APPROVED -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('nikah.status.applications', ['statusId' => 10]) }}">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius:20px; background:#f0fdf9;">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#065f46;">
                                    Approved
                                </span>
                                <div class="icon-box"
                                    style="background:rgba(16, 185, 129, 0.25); border-radius: 10px; padding: 8px;">
                                    <i class="bx bx-check-circle" style="color:#10b981;"></i>
                                </div>
                            </div>

                            <h2 class="fw-bold text-dark" style="color:#065f46;">{{ $approvedNikah }}</h2>
                            <small class="text-muted" style="color:#047857;">Completed Nikah</small>

                        </div>
                    </div>
                </a>
            </div>

            <!-- REJECTED -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a href="{{ route('nikah.status.applications', ['statusId' => -10]) }}">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius:20px; background:#fef2f2;">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-uppercase fw-bold" style="font-size:0.65rem; color:#991b1b;">
                                    Rejected
                                </span>
                                <div class="icon-box"
                                    style="background:rgba(239, 68, 68, 0.25); border-radius: 10px; padding: 8px;">
                                    <i class="bx bx-x-circle" style="color:#ef4444;"></i>
                                </div>
                            </div>

                            <h2 class="fw-bold text-dark" style="color:#991b1b;">{{ $rejectedNikah }}</h2>
                            <small class="text-muted" style="color:#dc2626;">Declined applications</small>

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

            .bento-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02) !important;
            }
        </style>

        <div class="row g-4">
            <!-- LEFT CARD: Nikah Records Management -->
            <div class="col-xl-6 col-lg-6 d-flex">
                <div class="card border-0 shadow-sm overflow-hidden w-100 d-flex flex-column"
                    style="border-radius:16px; background: linear-gradient(to bottom right, #ffffff, #f9fafb);">

                    <div class="card-body p-4 d-flex flex-column flex-fill">
                        <!-- Header -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-2 rounded-circle me-3" style="background: #05956810;">
                                <i class="bx bx-file fs-4" style="color: #059568;"></i>
                            </div>
                            <h5 class="mb-0 fw-bold">Monthly Nikah Records Management</h5>
                        </div>

                        <!-- Stats rows as full links -->
                        <a href="{{ route('nikah.status.applications', ['statusId' => 0]) }}"
                            class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                            style="transition: all 0.2s ease;">
                            <span class="text-warning fw-bold">Pending</span>
                            <span class="badge bg-warning text-dark fw-bold">{{ $pendingNikah }}</span>
                        </a>

                        <a href="{{ route('nikah.status.applications', ['statusId' => 10]) }}"
                            class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                            style="transition: all 0.2s ease;">
                            <span class="text-success fw-bold">Approved</span>
                            <span class="badge bg-success text-dark fw-bold">{{ $approvedNikah }}</span>
                        </a>

                        <a href="{{ route('nikah.status.applications', ['statusId' => -10]) }}"
                            class="d-flex justify-content-between align-items-center py-2 px-3 mb-1 border-bottom border-light text-decoration-none rounded hover-shadow"
                            style="transition: all 0.2s ease;">
                            <span class="text-danger fw-bold">Rejected</span>
                            <span class="badge bg-danger text-dark fw-bold">{{ $rejectedNikah }}</span>
                        </a>

                        <!-- Month Total (non-clickable) -->
                        <div class="d-flex justify-content-between py-2 px-3 mb-3">
                            <span class="text-muted fw-bold">Month Total</span>
                            <span class="badge bg-soft-dark text-dark fw-bold">{{ $thisMonthNikah }}</span>
                        </div>

                        <!-- Button -->
                        <div class="row g-2 mt-auto">
                            <div class="col-12">
                                <a href="{{ url('nikah-applications') }}"
                                    class="btn btn-sm w-100 py-2 text-white fw-bold d-flex align-items-center justify-content-center text-decoration-none"
                                    style="background: linear-gradient(90deg, #059568 0%, #10b981 100%);
                      border-radius:8px; border: none; transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(5, 149, 104, 0.3)'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <i class="bx bx-list-check me-2" style="font-size: 1.1rem;"></i>
                                    View All Nikkah Records
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

            <!-- RIGHT CARD: Monthly Reports -->
            <div class="col-xl-6 col-lg-6 d-flex">
                <div class="card border-0 shadow-lg w-100"
                    style="border-radius:16px; background:#1a202c; overflow: hidden;">
                    <div class="card-body p-4">
                        <h5 class="text-white fw-bold mb-4">Report Exports</h5>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="text-center p-3"
                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; cursor: pointer;">
                                    <i class="bx bxs-file-pdf mb-2" style="color: #ff4d4d; font-size: 2.5rem;"></i>
                                    <p class="text-white mb-0 fw-bold" style="font-size: 0.8rem;">PDF</p>
                                    <small class="text-white-50" style="font-size: 0.65rem;">Summary</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-3"
                                    style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 15px; cursor: pointer;">
                                    <i class="bx bxs-file-export mb-2" style="color: #059568; font-size: 2.5rem;"></i>
                                    <p class="text-white mb-0 fw-bold" style="font-size: 0.8rem;">EXCEL</p>
                                    <small class="text-white-50" style="font-size: 0.65rem;">Summary</small>
                                </div>
                            </div>
                        </div>

                        <p class="text-white-50 small mt-4 mb-0 text-center" style="font-style: italic;">
                            Download certified summaries for monthly Nikah Records.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7f6;
        }

        .fw-extra-bold {
            font-weight: 800;
        }

        .transition-hover:hover {
            background: #f9fafb;
            transform: scale(1.02);
            transition: 0.2s;
        }

        .bg-soft-dark {
            background: #e2e8f0;
        }
    </style>
@endsection
