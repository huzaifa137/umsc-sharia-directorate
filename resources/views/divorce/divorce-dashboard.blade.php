@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Dashboard Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg" style="background-color:#059580;">

                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="text-white mb-1">Divorce Dashboard</h2>
                                <p class="text-white opacity-75 mb-0">Manage all Sharia-compliant divorce cases and
                                    proceedings</p>
                            </div>
                            <div class="text-end">
                                <div class="avatar avatar-xl bg-white rounded-circle shadow-sm">
                                    <i class="bx bx-x-circle fs-2" style="color:#059580;"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Divorce Statistics Overview</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <!-- ALL DIVORCES -->
                            <div class="col-xl-3 col-md-6">
                                <a href="{{ route('divorce.status.applications', ['statusId' => 100]) }}">

                                    <div class="card h-100 border-0 shadow-sm"
                                        style="border-radius:20px; background:#f0f9ff;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="icon-box"
                                                    style="background:rgba(59, 130, 246, 0.25); border-radius: 10px; padding: 10px;">
                                                    <i class="bx bx-group" style="color:#3b82f6;"></i>
                                                </div>
                                                <div class="stat-change positive" style="color:#059568; font-weight:600;">✓✓
                                                </div>
                                            </div>

                                            <h2 class="fw-bold text-dark" style="color:#0369a1;">{{ $all }}</h2>
                                            <small class="text-muted" style="color:#0284c7;">All Divorces</small>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- CANCELLED DIVORCES -->
                            <div class="col-xl-3 col-md-6">
                                <a href="{{ route('divorce.status.applications', ['statusId' => -10]) }}">

                                    <div class="card h-100 border-0 shadow-sm"
                                        style="border-radius:20px; background:#fef2f2;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="icon-box"
                                                    style="background:rgba(239, 68, 68, 0.25); border-radius: 10px; padding: 10px;">
                                                    <i class="bx bx-folder-minus" style="color:#ef4444;"></i>
                                                </div>
                                                <div class="stat-change positive" style="color:#ef4444; font-weight:600;">✓✓
                                                </div>
                                            </div>

                                            <h2 class="fw-bold text-dark" style="color:#991b1b;">{{ $Rejected }}</h2>
                                            <small class="text-muted" style="color:#dc2626;">Cancelled Divorces</small>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- PENDING DIVORCES -->
                            <div class="col-xl-3 col-md-6">
                                <a href="{{ route('divorce.status.applications', ['statusId' => 0]) }}">

                                    <div class="card h-100 border-0 shadow-sm"
                                        style="border-radius:20px; background:#fef9e7;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="icon-box"
                                                    style="background:rgba(245, 158, 11, 0.25); border-radius: 10px; padding: 10px;">
                                                    <i class="bx bx-time" style="color:#d97706;"></i>
                                                </div>
                                                <div class="stat-change positive" style="color:#d97706; font-weight:600;">✓✓
                                                </div>
                                            </div>

                                            <h2 class="fw-bold text-dark" style="color:#92400e;">{{ $pending }}</h2>
                                            <small class="text-muted" style="color:#b45309;">Pending Divorces</small>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- FINALISED DIVORCES -->
                            <div class="col-xl-3 col-md-6">
                                <a href="{{ route('divorce.status.applications', ['statusId' => 10]) }}">

                                    <div class="card h-100 border-0 shadow-sm"
                                        style="border-radius:20px; background:#f0fdf4;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <div class="icon-box"
                                                    style="background:rgba(16, 185, 129, 0.25); border-radius: 10px; padding: 10px;">
                                                    <i class="bx bx-check-circle" style="color:#10b981;"></i>
                                                </div>
                                                <div class="stat-change positive" style="color:#059568; font-weight:600;">✓✓
                                                </div>
                                            </div>

                                            <h2 class="fw-bold text-dark" style="color:#065f46;">{{ $Finalised }}</h2>
                                            <small class="text-muted" style="color:#047857;">Finalised Divorces</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <style>
                        .stat-glass {
                            background: rgba(255, 255, 255, 0.85);
                            backdrop-filter: blur(10px);
                            border-radius: 16px;
                            padding: 1.5rem;
                            height: 100%;
                            border: 1px solid rgba(255, 255, 255, 0.2);
                            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
                            position: relative;
                            overflow: hidden;
                            transition: all 0.3s ease;
                        }

                        .stat-glass::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            height: 4px;
                            border-radius: 16px 16px 0 0;
                        }

                        .stat-glass-danger::before {
                            background: #ff6b6b;
                        }

                        .stat-glass-warning::before {
                            background: #ffd93d;
                        }

                        .stat-glass-success::before {
                            background: #6bcf7f;
                        }

                        .stat-glass-info::before {
                            background: #5ac8fa;
                        }

                        .stat-glass:hover {
                            transform: translateY(-5px);
                            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                        }

                        .stat-glass-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 1.5rem;
                        }

                        .icon-wrapper {
                            width: 56px;
                            height: 56px;
                            border-radius: 12px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 1.75rem;
                        }

                        .stat-glass-danger .icon-wrapper {
                            background: #ff6b6b;
                            color: white;
                        }

                        .stat-glass-warning .icon-wrapper {
                            background: #ffd93d;
                            color: white;
                        }

                        .stat-glass-success .icon-wrapper {
                            background: #6bcf7f;
                            color: white;
                        }

                        .stat-glass-info .icon-wrapper {
                            background: #5ac8fa;
                            color: white;
                        }

                        .stat-change {
                            font-size: 0.875rem;
                            font-weight: 600;
                            padding: 0.25rem 0.75rem;
                            border-radius: 20px;
                            background: rgba(108, 117, 125, 0.1);
                        }

                        .stat-change.positive {
                            background: rgba(40, 167, 69, 0.1);
                            color: #28a745;
                        }

                        .stat-number {
                            font-size: 2.25rem;
                            font-weight: 700;
                            margin-bottom: 0.5rem;
                            color: #2c3e50;
                        }

                        .stat-unit {
                            font-size: 1rem;
                            font-weight: 400;
                            color: #6c757d;
                        }

                        .stat-title {
                            color: #6c757d;
                            font-size: 0.9375rem;
                            margin-bottom: 0;
                            font-weight: 500;
                        }
                    </style>
                </div>
            </div>
        </div>

        <!-- Main Action Cards -->
        <div class="row">
            <!-- New Divorce Application -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-lg border-0 overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100" style="height: 5px;background:#078ae2;"></div>
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar p-3 me-3 rounded-circle" style="background:#078ae2;">
                                <i class="bx bx-plus-circle fs-2" style="color:#FFF;"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">New Application</h5>
                                <p class="text-muted small mb-0">Register new divorce case</p>
                            </div>
                        </div>

                        <div class="flex-grow-1">
                           <a href="{{ route('divorce.status.applications', ['statusId' => 0]) }}">
                            <div class="d-flex justify-content-between align-items-center mb-2 p-3 rounded-3 position-relative"
                                style="
                                        transition: all 0.3s ease; 
                                        cursor: pointer;
                                        background: white;
                                        border: 1px solid #e5e7eb;
                                    "
                                onmouseover="this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.1)'; this.style.borderColor='#3b82f6'; this.style.transform='translateX(4px)';"
                                onmouseout="this.style.boxShadow='none'; this.style.borderColor='#e5e7eb'; this.style.transform='translateX(0)';">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3"
                                        style="width: 8px; height: 8px; background: #3b82f6;">
                                    </div>
                                    <span class="text-muted fw-medium">Pending</span>
                                </div>
                                <span class="badge bg-light-primary text-primary fw-bold px-3 py-1"
                                    style="font-size: 0.85rem;">{{ $pending }}</span>
                            </div>
                            </a>
                            <a href="{{ route('divorce.status.applications', ['statusId' => 10]) }}">
                            <div class="d-flex justify-content-between align-items-center mb-2 p-3 rounded-3"
                                style="
                                            transition: all 0.3s ease; 
                                            cursor: pointer;
                                            background: white;
                                            border: 1px solid #e5e7eb;
                                        "
                                onmouseover="this.style.boxShadow='0 4px 12px rgba(34, 197, 94, 0.1)'; this.style.borderColor='#22c55e'; this.style.transform='translateX(4px)';"
                                onmouseout="this.style.boxShadow='none'; this.style.borderColor='#e5e7eb'; this.style.transform='translateX(0)';">
                                
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3"
                                        style="width: 8px; height: 8px; background: #22c55e;"></div>
                                    <span class="text-muted fw-medium">Approved</span>
                                </div>
                                <span class="badge bg-light-success text-success fw-bold px-3 py-1"
                                    style="font-size: 0.85rem;">{{ $Finalised }}</span>
                            </div>
                            </a>
                            <a href="{{ route('divorce.status.applications', ['statusId' => -10]) }}">
                            <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded-3"
                                style="
                                    transition: all 0.3s ease; 
                                    cursor: pointer;
                                    background: white;
                                    border: 1px solid #e5e7eb;
                                "
                                onmouseover="this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.1)'; this.style.borderColor='#ef4444'; this.style.transform='translateX(4px)';"
                                onmouseout="this.style.boxShadow='none'; this.style.borderColor='#e5e7eb'; this.style.transform='translateX(0)';">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle me-3"
                                        style="width: 8px; height: 8px; background: #ef4444;"></div>
                                    <span class="text-muted fw-medium">Rejected</span>
                                </div>
                                <span class="badge bg-light-danger text-danger fw-bold px-3 py-1"
                                    style="font-size: 0.85rem;">{{ $Rejected }}</span>
                            </div>
                            </a>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ url('divorce-application') }}" class="btn btn-outline-custom">
                                Start New Application
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .btn-outline-custom {
                    color: #078ae2;
                    border: 2px solid #078ae2;
                    background-color: transparent;
                }

                .btn-outline-custom:hover {
                    background-color: #078ae2;
                    color: #fff;
                }
            </style>

            <!-- Certificates & Documents -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-lg border-0 overflow-hidden">
                    <div class="position-absolute top-0 start-0 w-100 bg-success" style="height: 5px;"></div>
                    <div class="card-body d-flex flex-column p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="avatar bg-light-success p-3 me-3 rounded-circle">
                                <i class="bx bxs-certification fs-2 text-success"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-0">Monthly Certificates & Documents</h5>
                                <p class="text-muted small mb-0">Download official documents</p>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Issued This Month</span>
                                <span class="badge bg-label-success">{{ $all }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Pending Approval</span>
                                <span class="badge bg-label-warning">{{ $pending }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Rejected Cases</span>
                                <span class="badge bg-label-danger">{{ $Rejected }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Total Issued</span>
                                <span class="badge bg-label-success">{{ $all }}</span>
                            </div>
                        </div>
                        <div class="row g-2 mt-3">
                            <div class="col-6">
                                <a href="{{ url('reports/divorce') }}"
                                    class="btn w-100 d-flex flex-column align-items-center justify-content-center py-3 position-relative text-decoration-none"
                                    style="
                            background: rgba(5, 149, 104, 0.1);
                            color: #059568;
                            border-radius: 12px;
                            border: 2px solid rgba(5, 149, 104, 0.2);
                            transition: all 0.3s ease;
                        "
                                    onmouseover="this.style.background='rgba(5, 149, 104, 0.2)'; this.style.borderColor='#059568'; this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.background='rgba(5, 149, 104, 0.1)'; this.style.borderColor='rgba(5, 149, 104, 0.2)'; this.style.transform='translateY(0)'">
                                    <i class="bx bxs-file-pdf mb-2" style="font-size: 1.5rem;"></i>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold" style="font-size: 0.9rem;">PDF</span>
                                        <span class="badge bg-white text-success ms-2"
                                            style="font-size: 0.6rem; padding: 2px 6px; border: 1px solid rgba(5, 149, 104, 0.3);">.pdf</span>
                                    </div>
                                    <small class="text-muted">Download</small>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ url('reports/divorce') }}"
                                    class="btn w-100 d-flex flex-column align-items-center justify-content-center py-3 position-relative text-decoration-none"
                                    style="
                            background: rgba(37, 99, 235, 0.1);
                            color: #2563eb;
                            border-radius: 12px;
                            border: 2px solid rgba(37, 99, 235, 0.2);
                            transition: all 0.3s ease;
                        "
                                    onmouseover="this.style.background='rgba(37, 99, 235, 0.2)'; this.style.borderColor='#2563eb'; this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.background='rgba(37, 99, 235, 0.1)'; this.style.borderColor='rgba(37, 99, 235, 0.2)'; this.style.transform='translateY(0)'">
                                    <i class="bx bxs-file mb-2" style="font-size: 1.5rem;"></i>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold" style="font-size: 0.9rem;">Excel</span>
                                        <span class="badge bg-white text-primary ms-2"
                                            style="font-size: 0.6rem; padding: 2px 6px; border: 1px solid rgba(37, 99, 235, 0.3);">.xlsx</span>
                                    </div>
                                    <small class="text-muted">Download</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-danger {
            background: #dc2626;
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

        .bg-light-danger {
            background-color: rgba(220, 38, 38, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(245, 158, 11, 0.1);
        }

        .bg-light-success {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bg-light-info {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .bg-light-secondary {
            background-color: rgba(107, 114, 128, 0.1);
        }

        .bg-light-purple {
            background-color: rgba(111, 66, 193, 0.1);
        }

        .bg-label-danger {
            background-color: rgba(220, 38, 38, 0.1);
            color: #dc3545;
        }

        .bg-label-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .bg-label-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .bg-label-info {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .bg-label-primary {
            background-color: rgba(37, 99, 235, 0.1);
            color: #2563eb;
        }

        .bg-label-purple {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-outline-purple {
            color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-outline-purple:hover {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: white;
        }

        /* Custom table styles */
        .table-hover tbody tr:hover {
            background-color: rgba(220, 38, 38, 0.05);
        }

        /* Badge styles */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
    </style>

    <script>
        // Add some interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add click animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A' || e.target
                        .closest('button') || e.target.closest('a')) return;
                    this.style.transform = 'scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });

            // Quick search functionality
            const searchInput = document.querySelector('input[placeholder*="Search case ID"]');
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    performCaseSearch();
                }
            });

            function performCaseSearch() {
                const query = searchInput.value.trim();
                if (query) {
                    // In a real application, this would trigger an AJAX search
                    console.log('Searching for divorce case:', query);
                    alert('Searching for: ' + query);
                }
            }

            // Task completion animation
            const taskButtons = document.querySelectorAll(
                '.btn-outline-danger, .btn-outline-warning, .btn-outline-info, .btn-outline-secondary');
            taskButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.innerHTML = '<i class="bx bx-check me-2"></i>Completed';
                    this.classList.remove('btn-outline-danger', 'btn-outline-warning',
                        'btn-outline-info', 'btn-outline-secondary');
                    this.classList.add('btn-success');
                    this.disabled = true;

                    // Update pending tasks count
                    const taskBadge = document.querySelector('.badge.bg-danger');
                    if (taskBadge) {
                        let count = parseInt(taskBadge.textContent);
                        if (count > 0) {
                            count--;
                            taskBadge.textContent = count;
                            if (count === 0) {
                                taskBadge.classList.remove('bg-danger');
                                taskBadge.classList.add('bg-success');
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection
