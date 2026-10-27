@extends('layouts.app')

@section('content')
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

    /* Custom Modal Styling */
    .modal-content {
        border-radius: 20px !important;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: #008F4C;
        color: white;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem 2rem;
    }

    .modal-header .btn-close {
        filter: invert(1);
        opacity: 0.8;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 2rem;
        background: #f8f9fa;
    }

    .modal-footer {
        background: #f8f9fa;
        border-radius: 0 0 20px 20px;
        padding: 1rem 2rem;
    }

    /* Section Styling */
    .section-title {
        color: #4a5568;
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e2e8f0;
        position: relative;
    }

    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -2px;
        width: 60px;
        height: 2px;
        background: #667eea;
    }

    /* Card Styling */
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        border: 1px solid #e2e8f0;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .person-card {
        border-left: 4px solid #667eea;
    }

    .consultant-card {
        border-left-color: #059568;
    }

    .photo-container {
        width: 120px;
        height: 120px;
        border-radius: 12px;
        overflow: hidden;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 1rem;
    }

    .photo-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 0.35rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-submitted {
        background: #E3F2FD;
        color: #1565C0;
    }

    .status-under_review {
        background: #FFF3E0;
        color: #E65100;
    }

    .status-reviewed {
        background: #F3E5F5;
        color: #6A1B9A;
    }

    .status-approved {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .status-rejected {
        background: #FFEBEE;
        color: #C62828;
    }

    .status-accomplished {
        background: #ECEFF1;
        color: #37474F;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .info-item {
        padding: 0.75rem;
        background: #f7fafc;
        border-radius: 8px;
        border-left: 3px solid #cbd5e0;
    }

    .info-item label {
        display: block;
        font-size: 0.8rem;
        color: #718096;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-item .value {
        font-weight: 600;
        color: #2d3748;
        font-size: 0.95rem;
    }

    .imam-assigned {
        color: #2b6cb0;
        font-weight: 600;
        padding: 0.75rem;
        background: #ebf8ff;
        border-radius: 8px;
        display: inline-block;
    }

    .imam-not-assigned {
        color: #718096;
        font-style: italic;
        padding: 0.75rem;
        background: #f7fafc;
        border-radius: 8px;
        display: inline-block;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 1rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .photo-container {
            margin: 0 auto 1rem;
        }
    }

    .modal-dialog-scrollable .modal-content {
        max-height: 85vh;
        overflow: hidden;
    }

    .modal-dialog-scrollable .modal-body {
        overflow-y: auto;
        max-height: calc(85vh - 120px);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
        <div>
            <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif; color:#059580;">ALL CONSULTANCY APPLICATIONS</h2>
        </div>
        <div class="avatar-group">
            <div class="bg-light p-2 rounded-3">
                <i class="bx bx-calendar text-success me-2"></i>
                <span id="currentDateFull" class="small fw-medium"></span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px;">
        <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <!-- Search Bar -->
            <div class="w-100 me-4">
                <div class="position-relative" style="max-width: 500px;">
                    <div class="input-group"
                        style="background: white; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06); padding: 8px; transition: all 0.3s ease;"
                        onmouseover="this.style.boxShadow='0 6px 25px rgba(0, 0, 0, 0.08)'">
                        <span class="input-group-text border-0 bg-transparent" style="padding-left: 15px;">
                            <i class="bx bx-search-alt-2" style="color:#059568; font-size: 1.2rem;"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-0 px-0 shadow-none"
                            placeholder="Search by ID, name, subject…"
                            style="background: transparent; color: #1a202c; font-weight: 600; padding: 8px 0; height: auto;">
                        <label class="position-absolute"
                            style="top: -10px; left: 50px; background: white; padding: 0 10px; font-size: 0.8rem; color: #059568; font-weight: 600; letter-spacing: 0.5px; z-index: 5;">
                            Search Records
                        </label>
                        <div class="d-flex align-items-center gap-2" style="padding-right: 10px;">
                            <button class="btn btn-sm p-1" id="clearSearch"
                                style="background: #059568; color: #FFF; border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none;">
                                <i class="bx bx-x" style="font-size: 1.1rem;"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('consultancy.dashboard') }}"
                class="text-decoration-none d-flex align-items-center fw-bold text-nowrap"
                style="background: #f0fdf4; padding: 10px 20px; border-radius: 10px; border: 1px solid rgba(5, 149, 104, 0.2); transition: all 0.3s ease; color:#00580F; flex-shrink: 0;"
                onmouseover="this.style.background='#dcfce7'; this.style.transform='translateY(-2px)'"
                onmouseout="this.style.background='#f0fdf4'; this.style.transform='translateY(0)'">
                <i class="bx bx-home fs-4 me-2" style="color:#059568;"></i>
                <span>Consultancy Dashboard</span>
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bold text-center">ACTIVITY & ID</th>
                            <th class="border-0 text-muted small fw-bold text-center">DESCRIPTION</th>
                            <th class="border-0 text-muted small fw-bold text-center">TIMELINE</th>
                            <th class="border-0 text-muted small fw-bold text-center">STATUS</th>
                            <th class="pe-4 border-0 text-muted small fw-bold text-center" style="width: 200px;">MANAGEMENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr class="border-bottom border-light application-row"
                                data-search="
                                    {{ strtolower($application->application_id) }}
                                    {{ strtolower($application->applicant_name) }}
                                    {{ strtolower($application->subject) }}
                                    {{ strtolower($application->consultation_type) }}
                                    {{ strtolower($application->status) }}
                                ">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                            style="background: #05956820; width: 40px; height: 40px;">
                                            <i class="bx bx-message-square-detail fs-4" style="color: #059568;"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Consultancy</h6>
                                            <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">
                                                #{{ $application->application_id }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">
                                        {{ $application->applicant_name }}
                                    </p>
                                    <small class="text-muted">{{ $application->consultation_type_label }}</small>
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="small fw-bold text-dark">
                                            {{ $application->created_at->format('d M Y, H:i') }}
                                        </span>
                                        <span class="text-muted" style="font-size: 11px;">Date & Time</span>
                                    </div>
                                </td>

                                <td>
                                    @php
                                        $statusColors = [
                                            'submitted' => ['#E3F2FD', '#1565C0'],
                                            'under_review' => ['#FFF3E0', '#E65100'],
                                            'reviewed' => ['#F3E5F5', '#6A1B9A'],
                                            'approved' => ['#E8F5E9', '#2E7D32'],
                                            'rejected' => ['#FFEBEE', '#C62828'],
                                            'accomplished' => ['#ECEFF1', '#37474F'],
                                        ];
                                        $bg = $statusColors[$application->status][0] ?? '#E7F3FF';
                                        $color = $statusColors[$application->status][1] ?? '#0D6EFD';
                                    @endphp
                                    <span class="badge rounded-pill px-3"
                                        style="background: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                        {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                                    </span>
                                </td>

                                <td class="pe-4 text-end">
                                    <div class="btn-group shadow-sm action-group" role="group"
                                        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">

                                        <!-- View -->
                                        <button type="button" class="btn btn-white btn-sm px-2 border-end view-application"
                                            data-id="{{ $application->id }}" title="View Details">
                                            <i class="bx bx-show-alt fs-5" style="color:#2563eb;"></i>
                                        </button>

                                        <!-- Edit -->
                                        @auth
                                            @if(in_array($application->status, ['submitted', 'under_review']) && (auth()->user()->id == $application->created_by || auth()->user()->hasRole('director')))
                                                <button type="button" class="btn btn-white btn-sm px-2 border-end edit-application"
                                                    data-id="{{ $application->id }}" title="Edit Entry">
                                                    <i class="bx bx-edit-alt fs-5" style="color:#16a34a;"></i>
                                                </button>
                                            @endif
                                        @endauth

                                        <!-- Review -->
                                        @can_permission('consultancy.review')
                                            @if(in_array($application->status, ['submitted', 'under_review']))
                                                <button type="button" class="btn btn-white btn-sm px-2 border-end review-application"
                                                    data-id="{{ $application->id }}" title="Review">
                                                    <i class="bx bx-check-square fs-5" style="color:#ff9f43;"></i>
                                                </button>
                                            @endif
                                        @endcan_permission

                                        <!-- Download/Print Certificate -->
                                        @if(in_array($application->status, ['approved', 'accomplished']))
                                            <a href="{{ route('consultancy.print', $application->id) }}" target="_blank"
                                                class="btn btn-white btn-sm px-2 border-end" title="Download Certificate">
                                                <i class="bx bx-download fs-5" style="color:#ff5e00;"></i>
                                            </a>
                                        @endif

                                        <!-- Update Status -->
                                        @full_access
                                            @if(in_array($application->status, ['submitted', 'under_review', 'reviewed']))
                                                <button type="button" class="btn btn-white btn-sm px-2 border-end update-status"
                                                    data-id="{{ $application->id }}" title="Update Status">
                                                    <i class="bx bx-refresh fs-5" style="color:#8b5cf6;"></i>
                                                </button>
                                            @endif
                                        @endfull_access

                                        <!-- Delete -->
                                        @auth
                                            @if(auth()->user()->id == $application->created_by || auth()->user()->hasRole('director'))
                                                <button type="button" class="btn btn-white btn-sm px-2 border-end delete-application"
                                                    data-id="{{ $application->id }}" title="Delete Application">
                                                    <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
                                                </button>
                                            @endif
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bx bx-folder-open fs-1 mb-2"></i>
                                    <p class="mb-0">No consultancy applications found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4 me-4">
                {{ $applications->links('pagination::bootstrap-5') }}
            </div>

            <!-- ============================================================ -->
            <!-- VIEW APPLICATION MODAL -->
            <!-- ============================================================ -->
            <div class="modal fade" id="viewApplicationModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <h5 class="modal-title fw-bold text-white"><i class="fas fa-file-contract me-2"></i>Consultation Details</h5>
                                <p class="small mb-0 opacity-75">Complete consultation information</p>
                            </div>
                            <button type="button" style="background-color: #4e8d5e; color: #ffffff; border: none; font-size: 1.7rem; line-height: 1; padding: 0.25rem 0.5rem; border-radius: 0.25rem; cursor: pointer;" data-bs-dismiss="modal">
                                &times;
                            </button>
                        </div>

                        <div class="modal-body" id="viewModalBody">
                            <!-- Dynamic content loaded via JS -->
                            <div class="text-center py-4">
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Close
                            </button>
                            <!-- Print Button in Footer -->
                            <button type="button" class="btn btn-primary px-4" id="printCertificateFromModal">
                                <i class="fas fa-print me-2"></i>Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- UPDATE STATUS MODAL -->
            <!-- ============================================================ -->
            @full_access
            <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-white">Update Application Status</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Current Status: <strong id="currentStatusText"></strong></p>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-warning status-option flex-fill" data-status="submitted">
                                    <i class="bx bx-time me-1"></i> Submitted
                                </button>
                                <button type="button" class="btn btn-info status-option flex-fill" data-status="under_review">
                                    <i class="bx bx-search-alt me-1"></i> Under Review
                                </button>
                                <button type="button" class="btn btn-primary status-option flex-fill" data-status="reviewed">
                                    <i class="bx bx-check-square me-1"></i> Reviewed
                                </button>
                                <button type="button" class="btn btn-success status-option flex-fill" data-status="approved">
                                    <i class="bx bx-check-circle me-1"></i> Approved
                                </button>
                                <button type="button" class="btn btn-danger status-option flex-fill" data-status="rejected">
                                    <i class="bx bx-x-circle me-1"></i> Rejected
                                </button>
                                <button type="button" class="btn btn-secondary status-option flex-fill" data-status="accomplished">
                                    <i class="bx bx-check-double me-1"></i> Accomplished
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endfull_access

           <!-- ============================================================ -->
<!-- REVIEW MODAL - Fixed Scrolling                               -->
<!-- ============================================================ -->
@can_permission('consultancy.review')
<div class="modal fade" id="reviewModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); max-height: 90vh;">

            <!-- Modal Header - Fixed (not scrollable) -->
            <div class="modal-header" style="background: linear-gradient(135deg, #ff9f43, #f39c12); border-radius: 16px 16px 0 0; padding: 1.5rem 2rem; flex-shrink: 0;">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-circle me-3" style="background: rgba(255,255,255,0.2);">
                        <i class="bx bx-check-square text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0">Review Consultation</h5>
                        <small class="text-white-50">Provide Islamic guidance and ruling on this matter</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="reviewForm" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem 2rem; overflow-y: auto; max-height: calc(90vh - 140px);">

                    <!-- Consultation Summary -->
                    <div class="alert alert-light mb-3" style="border-radius: 10px; border-left: 4px solid #ff9f43; flex-shrink: 0;">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Applicant</small>
                                <div class="fw-bold" id="reviewApplicant"></div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Subject</small>
                                <div id="reviewSubject"></div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Type</small>
                                <span class="badge" style="background: rgba(5,88,15,.08); color:#00580f;" id="reviewType"></span>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="consultancy_id" id="reviewConsultancyId">

                    <!-- Islamic Guidance -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bx bx-check-shield me-1" style="color: #ff9f43;"></i>
                            Islamic Guidance <span class="text-danger">*</span>
                        </label>
                        <textarea name="islamic_guidance" class="form-control" rows="4" required
                            style="border-radius: 10px; border: 2px solid #e9ecef; resize: vertical;"
                            placeholder="Provide the Islamic ruling, guidance, or fatwa on this matter..."></textarea>
                    </div>

                    <!-- Recommendation -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bx bx-bulb me-1" style="color: #f39c12;"></i>
                            Recommendation
                        </label>
                        <textarea name="recommendation" class="form-control" rows="3"
                            style="border-radius: 10px; border: 2px solid #e9ecef; resize: vertical;"
                            placeholder="What action is recommended based on the guidance?"></textarea>
                    </div>

                    <!-- Conditions & Restrictions -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="bx bx-list-check me-1" style="color: #2ecc71;"></i>
                                Conditions
                            </label>
                            <textarea name="conditions" class="form-control" rows="2"
                                style="border-radius: 10px; border: 2px solid #e9ecef; resize: vertical;"
                                placeholder="Any conditions that must be met..."></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="bx bx-block me-1" style="color: #e74c3c;"></i>
                                Restrictions
                            </label>
                            <textarea name="restrictions" class="form-control" rows="2"
                                style="border-radius: 10px; border: 2px solid #e9ecef; resize: vertical;"
                                placeholder="Any restrictions that apply..."></textarea>
                        </div>
                    </div>

                    <!-- References -->
                    <div class="mt-3">
                        <label class="fw-bold mb-2" style="color: #00580f;">
                            <i class="bx bx-book-open me-1"></i> References
                        </label>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Qur'an Reference</label>
                                <input type="text" name="quran_reference" class="form-control"
                                    style="border-radius: 10px; border: 2px solid #e9ecef;"
                                    placeholder="e.g. Surah Al-Baqarah 2:183">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Hadith Reference</label>
                                <input type="text" name="hadith_reference" class="form-control"
                                    style="border-radius: 10px; border: 2px solid #e9ecef;"
                                    placeholder="e.g. Sahih Bukhari 1:1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small text-muted">Scholar Reference</label>
                                <input type="text" name="scholar_reference" class="form-control"
                                    style="border-radius: 10px; border: 2px solid #e9ecef;"
                                    placeholder="e.g. Imam Al-Shafi'i">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer - Fixed (not scrollable) -->
                <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 1rem 2rem; flex-shrink: 0;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.5rem 1.5rem;">Cancel</button>
                    <button type="submit" class="btn fw-bold text-white" style="background: linear-gradient(135deg, #ff9f43, #f39c12); border: none; border-radius: 10px; padding: 0.5rem 2rem;">
                        <i class="bx bx-check-square me-1"></i> Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endcan_permission
<!-- ============================================================ -->
<!-- SCRIPTS -->
<!-- ============================================================ -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date display
    const dateElement = document.getElementById('currentDateFull');
    const now = new Date();
    dateElement.textContent = now.toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.application-row').forEach(row => {
            const searchableText = row.getAttribute('data-search');
            row.style.display = searchableText.includes(query) ? '' : 'none';
        });
    });

    document.getElementById('clearSearch').addEventListener('click', function() {
        const input = document.getElementById('searchInput');
        input.value = '';
        input.dispatchEvent(new Event('keyup'));
    });

    // ================================================================
    // VIEW APPLICATION MODAL
    // ================================================================
    const viewModal = new bootstrap.Modal(document.getElementById('viewApplicationModal'));
    let currentViewApplicationId = null;

    document.querySelectorAll('.view-application').forEach(button => {
        button.addEventListener('click', function() {
            currentViewApplicationId = this.dataset.id;
            const modalBody = document.getElementById('viewModalBody');
            modalBody.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            `;
            viewModal.show();

            fetch(`/consultancy/${currentViewApplicationId}/data`)
                .then(res => res.json())
                .then(data => {
                    const statusLabels = {
                        'submitted': 'Submitted',
                        'under_review': 'Under Review',
                        'reviewed': 'Reviewed',
                        'approved': 'Approved',
                        'rejected': 'Rejected',
                        'accomplished': 'Accomplished'
                    };
                    const statusColors = {
                        'submitted': '#1565C0',
                        'under_review': '#E65100',
                        'reviewed': '#6A1B9A',
                        'approved': '#2E7D32',
                        'rejected': '#C62828',
                        'accomplished': '#37474F'
                    };

                    modalBody.innerHTML = `
                        <div class="info-card">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="section-title mb-0">Application Information</h6>
                                <div>
                                    <a href="/consultancy/${data.id}/print" target="_blank" class="btn btn-sm btn-primary">
                                        <i class="bx bx-printer me-1"></i> Print Certificate
                                    </a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <label>Application ID</label>
                                        <div class="value">${data.application_id || data.id}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <label>Application Date</label>
                                        <div class="value">${new Date(data.created_at).toLocaleDateString('en-US', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'})}</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <label>Application Status</label>
                                        <div class="value">
                                            <span class="badge rounded-pill" style="background: ${statusColors[data.status]}15; color: ${statusColors[data.status]}; border: 1px solid ${statusColors[data.status]}30;">
                                                ${statusLabels[data.status] || data.status}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="section-title mt-4">Applicant Information</h6>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="info-card person-card consultant-card">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1">
                                            <h5 class="mb-3">${data.applicant_name}</h5>
                                            <div class="info-grid">
                                                <div class="info-item">
                                                    <label>Phone</label>
                                                    <div class="value">${data.applicant_phone || 'Not provided'}</div>
                                                </div>
                                                <div class="info-item">
                                                    <label>Email</label>
                                                    <div class="value">${data.applicant_email || 'Not provided'}</div>
                                                </div>
                                                <div class="info-item">
                                                    <label>NIN</label>
                                                    <div class="value">${data.applicant_nin || 'Not provided'}</div>
                                                </div>
                                                <div class="info-item">
                                                    <label>Occupation</label>
                                                    <div class="value">${data.applicant_occupation || 'Not provided'}</div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <label class="text-muted small">Address</label>
                                                <p class="mb-0">${data.applicant_address || 'Not provided'}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6 class="section-title mt-4">Consultation Details</h6>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="info-card">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label>Type</label>
                                                <div class="value">${data.consultation_type_label || data.consultation_type}</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label>Subject</label>
                                                <div class="value">${data.subject || 'No subject provided'}</div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <div class="info-item">
                                                <label>Description</label>
                                                <div class="value" style="white-space: pre-line;">${data.description || 'No description provided'}</div>
                                            </div>
                                        </div>
                                        ${data.background_info ? `
                                        <div class="col-12 mt-3">
                                            <div class="info-item">
                                                <label>Background Information</label>
                                                <div class="value" style="white-space: pre-line;">${data.background_info}</div>
                                            </div>
                                        </div>
                                        ` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>

                        ${data.islamic_guidance ? `
                        <h6 class="section-title mt-4">Islamic Guidance & Response</h6>
                        <div class="row">
                            <div class="col-lg-12 mb-4">
                                <div class="info-card" style="border-left: 4px solid #059568;">
                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Islamic Guidance</label>
                                        <div class="p-3 rounded-3" style="background: rgba(5,149,104,.06); white-space: pre-line;">
                                            ${data.islamic_guidance}
                                        </div>
                                    </div>
                                    ${data.recommendation ? `
                                    <div class="mb-3">
                                        <label class="fw-bold small text-muted">Recommendation</label>
                                        <div class="p-3 rounded-3" style="background: rgba(13,110,253,.06); white-space: pre-line;">
                                            ${data.recommendation}
                                        </div>
                                    </div>
                                    ` : ''}
                                    ${data.conditions || data.restrictions ? `
                                    <div class="row g-3">
                                        ${data.conditions ? `
                                        <div class="col-md-6">
                                            <label class="fw-bold small text-muted">Conditions</label>
                                            <div class="p-3 rounded-3" style="background: rgba(255,193,7,.08); white-space: pre-line;">
                                                ${data.conditions}
                                            </div>
                                        </div>
                                        ` : ''}
                                        ${data.restrictions ? `
                                        <div class="col-md-6">
                                            <label class="fw-bold small text-muted">Restrictions</label>
                                            <div class="p-3 rounded-3" style="background: rgba(220,53,69,.06); white-space: pre-line;">
                                                ${data.restrictions}
                                            </div>
                                        </div>
                                        ` : ''}
                                    </div>
                                    ` : ''}
                                    ${data.quran_reference || data.hadith_reference || data.scholar_reference ? `
                                    <div class="mt-3">
                                        <hr>
                                        <div class="row g-2">
                                            ${data.quran_reference ? `
                                            <div class="col-md-4">
                                                <span class="badge" style="background: rgba(5,149,104,.12); color: #059568;">
                                                    <i class="bx bx-book me-1"></i> Qur'an
                                                </span>
                                                <small class="d-block text-muted">${data.quran_reference}</small>
                                            </div>
                                            ` : ''}
                                            ${data.hadith_reference ? `
                                            <div class="col-md-4">
                                                <span class="badge" style="background: rgba(13,110,253,.12); color: #0d6efd;">
                                                    <i class="bx bx-bookmark me-1"></i> Hadith
                                                </span>
                                                <small class="d-block text-muted">${data.hadith_reference}</small>
                                            </div>
                                            ` : ''}
                                            ${data.scholar_reference ? `
                                            <div class="col-md-4">
                                                <span class="badge" style="background: rgba(108,117,125,.12); color: #6c757d;">
                                                    <i class="bx bx-user me-1"></i> Scholar
                                                </span>
                                                <small class="d-block text-muted">${data.scholar_reference}</small>
                                            </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                    ` : ''}
                                    <div class="mt-3">
                                        <small class="text-muted">Reviewed by: ${data.reviewer || 'Not yet reviewed'} ${data.reviewed_at ? 'on ' + new Date(data.reviewed_at).toLocaleDateString('en-US', {day: 'numeric', month: 'short', year: 'numeric'}) : ''}</small>
                                        ${data.signed_at ? `<br><small class="text-success"><i class="bx bx-check-circle me-1"></i> Signed by: ${data.signatory || 'Director'} on ${new Date(data.signed_at).toLocaleDateString('en-US', {day: 'numeric', month: 'short', year: 'numeric'})}</small>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    `;
                })
                .catch(err => {
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="bx bx-error-circle me-2"></i>
                            Failed to load application details. Please try again.
                        </div>
                    `;
                });
            });
        });

        // Print from modal
        document.getElementById('printCertificateFromModal').addEventListener('click', function() {
            if (currentViewApplicationId) {
                window.open(`/consultancy/${currentViewApplicationId}/print`, '_blank');
            }
        });

        // ================================================================
        // REVIEW MODAL
        // ================================================================
        const reviewModal = new bootstrap.Modal(document.getElementById('reviewModal'));

        document.querySelectorAll('.review-application').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                document.getElementById('reviewConsultancyId').value = id;
                document.getElementById('reviewForm').action = `/consultancy/${id}/review`;

                fetch(`/consultancy/${id}/data`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('reviewApplicant').textContent = data.applicant_name;
                        document.getElementById('reviewSubject').textContent = data.subject || 'No subject provided';
                        document.getElementById('reviewType').textContent = data.consultation_type_label || data.consultation_type;
                    })
                    .catch(() => {});

                reviewModal.show();
            });
        });

        // ================================================================
        // UPDATE STATUS MODAL
        // ================================================================
        const statusModal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
        let selectedApplicationId = null;

        document.querySelectorAll('.update-status').forEach(btn => {
            btn.addEventListener('click', function() {
                selectedApplicationId = this.dataset.id;
                const currentStatus = this.closest('tr').querySelector('.badge').textContent.trim();
                document.getElementById('currentStatusText').textContent = currentStatus;
                statusModal.show();
            });
        });

        document.querySelectorAll('.status-option').forEach(btn => {
            btn.addEventListener('click', function() {
                const newStatus = this.dataset.status;
                const statusLabel = this.textContent.trim();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Change status to "${statusLabel}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/consultancy/${selectedApplicationId}/status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status: newStatus })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                statusModal.hide();
                                Swal.fire('Updated!', 'Application status has been updated.', 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message || 'Failed to update status.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to update status.', 'error');
                        });
                    }
                });
            });
        });

        // ================================================================
        // DELETE APPLICATION
        // ================================================================
        document.querySelectorAll('.delete-application').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const row = this.closest('tr');

                Swal.fire({
                    title: 'Delete Application?',
                    text: 'This action cannot be undone!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/consultancy/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                Swal.fire('Deleted!', 'Application deleted successfully.', 'success')
                                    .then(() => {
                                        row.style.transition = 'opacity 0.3s';
                                        row.style.opacity = '0';
                                        setTimeout(() => row.remove(), 300);
                                    });
                            } else {
                                Swal.fire('Error', data.message || 'Failed to delete.', 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Failed to delete application.', 'error');
                        });
                    }
                });
            });
        });

        // ================================================================
        // EDIT APPLICATION - Redirect to edit page
        // ================================================================
        document.querySelectorAll('.edit-application').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                window.location.href = `/consultancy/${id}/edit`;
            });
        });
    });
</script>
@endsection