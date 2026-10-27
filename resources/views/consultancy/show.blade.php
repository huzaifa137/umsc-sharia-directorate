@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-3" style="background: linear-gradient(135deg, rgba(5, 88, 15, 0.08) 0%, rgba(5, 149, 104, 0.04) 100%); border: 1px solid rgba(5, 88, 15, 0.1);">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: linear-gradient(135deg, #00580f, #059568);">
                            <i class="bx bx-message-square-detail text-white fs-3"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-1" style="color: #111827; font-size: 1.6rem;">Consultation Details</h1>
                            <p class="text-muted mb-0">
                                <code>{{ $consultancy->application_id }}</code>
                                <span class="badge rounded-pill ms-2" style="background: {{ $consultancy->status_color }}15; color: {{ $consultancy->status_color }};">
                                    {{ $consultancy->status_label }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        <!-- Edit Button -->
                        @auth
                            @if(in_array($consultancy->status, ['submitted', 'under_review']) && (auth()->user()->id == $consultancy->created_by || auth()->user()->hasRole('director')))
                                <a href="{{ route('consultancy.edit', $consultancy->id) }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                                    <i class="bx bx-edit me-1"></i> Edit
                                </a>
                            @endif
                        @endauth

                        <!-- Review Button -->
                        @can_permission('consultancy.review')
                            @if(in_array($consultancy->status, ['submitted', 'under_review']))
                                <button class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#reviewModal" style="border-radius: 10px;">
                                    <i class="bx bx-check-square me-1"></i> Review
                                </button>
                            @endif
                        @endcan_permission

                        <!-- Status Change Button -->
                        @full_access
                            @if(in_array($consultancy->status, ['submitted', 'under_review', 'reviewed']))
                                <button class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#statusModal" style="border-radius: 10px;">
                                    <i class="bx bx-transfer-alt me-1"></i> Change Status
                                </button>
                            @endif
                        @endfull_access


                        <!-- In the action buttons section, add this after the Reject button -->
                            <!-- Print Certificate -->
                            @if(in_array($consultancy->status, ['approved', 'accomplished']))
                                <a href="{{ route('consultancy.print', $consultancy->id) }}" target="_blank" class="btn btn-primary" style="border-radius: 10px;">
                                    <i class="bx bx-download me-1"></i> Download Certificate
                                </a>
                            @endif



                        <!-- Approve & Sign Button -->
                        @full_access
                            @if($consultancy->status == 'reviewed')
                                <form action="{{ route('consultancy.sign', $consultancy->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success" style="border-radius: 10px;">
                                        <i class="bx bx-check-shield me-1"></i> Approve & Sign
                                    </button>
                                </form>
                            @endif
                        @endfull_access

                        <!-- Reject Button -->
                        @full_access
                            @if(in_array($consultancy->status, ['submitted', 'under_review', 'reviewed']))
                                <form action="{{ route('consultancy.reject', $consultancy->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to reject this consultation?')" style="border-radius: 10px;">
                                        <i class="bx bx-x-circle me-1"></i> Reject
                                    </button>
                                </form>
                            @endif
                        @endfull_access

                        <!-- Print Certificate -->
                        @if(in_array($consultancy->status, ['approved', 'accomplished']))
                            <a href="{{ route('consultancy.print', $consultancy->id) }}" target="_blank" class="btn btn-primary" style="border-radius: 10px;">
                                <i class="bx bx-printer me-1"></i> Print Certificate
                            </a>
                        @endif

                        <!-- Delete Button -->
                        @auth
                            @if(auth()->user()->id == $consultancy->created_by || auth()->user()->hasRole('director'))
                                <form action="{{ route('consultancy.destroy', $consultancy->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this consultation permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger" style="border-radius: 10px;">
                                        <i class="bx bx-trash me-1"></i>
                                    </button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Applicant Info -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0" style="color: #00580f;">
                        <i class="bx bx-user me-2"></i>Applicant Information
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-sm table-borderless">
                        <tr><td class="text-muted" style="width: 40%;">Full Name</td><td class="fw-bold">{{ $consultancy->applicant_name }}</td></tr>
                        <tr><td class="text-muted">Phone</td><td>{{ $consultancy->applicant_phone }}</td></tr>
                        @if($consultancy->applicant_email)<tr><td class="text-muted">Email</td><td>{{ $consultancy->applicant_email }}</td></tr>@endif
                        @if($consultancy->applicant_nin)<tr><td class="text-muted">NIN</td><td>{{ $consultancy->applicant_nin }}</td></tr>@endif
                        @if($consultancy->applicant_address)<tr><td class="text-muted">Address</td><td>{{ $consultancy->applicant_address }}</td></tr>@endif
                        @if($consultancy->applicant_occupation)<tr><td class="text-muted">Occupation</td><td>{{ $consultancy->applicant_occupation }}</td></tr>@endif
                        <tr><td class="text-muted">Submitted</td><td>{{ $consultancy->created_at->format('d M Y, H:i') }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Consultation Info -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0" style="color: #00580f;">
                        <i class="bx bx-info-circle me-2"></i>Consultation Details
                    </h6>
                </div>
                <div class="card-body pt-0">
                    <table class="table table-sm table-borderless">
                        <tr><td class="text-muted" style="width: 40%;">Type</td>
                            <td><span class="badge" style="background: rgba(5,88,15,.08); color:#00580f;">{{ $consultancy->consultation_type_label }}</span>
                            @if($consultancy->consultation_type_other)<small class="text-muted">({{ $consultancy->consultation_type_other }})</small>@endif</td>
                        </tr>
                        @if($consultancy->subject)<tr><td class="text-muted">Subject</td><td class="fw-bold">{{ $consultancy->subject }}</td></tr>@endif
                        <tr><td class="text-muted">Description</td><td class="text-wrap" style="white-space: pre-line;">{{ $consultancy->description }}</td></tr>
                        @if($consultancy->background_info)<tr><td class="text-muted">Background</td><td class="text-wrap" style="white-space: pre-line;">{{ $consultancy->background_info }}</td></tr>@endif
                        @if($consultancy->attachment_path)
                        <tr><td class="text-muted">Attachment</td>
                            <td><a href="{{ Storage::url($consultancy->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary"><i class="bx bx-file me-1"></i> View Document</a></td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <!-- Islamic Guidance / Response -->
        @if($consultancy->islamic_guidance || $consultancy->recommendation)
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-header bg-transparent border-0">
                    <h6 class="fw-bold mb-0" style="color: #059568;">
                        <i class="bx bx-check-shield me-2"></i>Islamic Guidance & Response
                    </h6>
                </div>
                <div class="card-body pt-0">
                    @if($consultancy->islamic_guidance)
                    <div class="mb-3">
                        <label class="fw-bold small text-muted">Islamic Guidance</label>
                        <div class="p-3 rounded-3" style="background: rgba(5,149,104,.06); white-space: pre-line;">{{ $consultancy->islamic_guidance }}</div>
                    </div>
                    @endif

                    @if($consultancy->recommendation)
                    <div class="mb-3">
                        <label class="fw-bold small text-muted">Recommendation</label>
                        <div class="p-3 rounded-3" style="background: rgba(13,110,253,.06); white-space: pre-line;">{{ $consultancy->recommendation }}</div>
                    </div>
                    @endif

                    @if($consultancy->conditions || $consultancy->restrictions)
                    <div class="row g-3">
                        @if($consultancy->conditions)
                        <div class="col-md-6">
                            <label class="fw-bold small text-muted">Conditions</label>
                            <div class="p-3 rounded-3" style="background: rgba(255,193,7,.08); white-space: pre-line;">{{ $consultancy->conditions }}</div>
                        </div>
                        @endif
                        @if($consultancy->restrictions)
                        <div class="col-md-6">
                            <label class="fw-bold small text-muted">Restrictions</label>
                            <div class="p-3 rounded-3" style="background: rgba(220,53,69,.06); white-space: pre-line;">{{ $consultancy->restrictions }}</div>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($consultancy->quran_reference || $consultancy->hadith_reference || $consultancy->scholar_reference)
                    <div class="mt-3">
                        <hr>
                        <div class="row g-2">
                            @if($consultancy->quran_reference)
                            <div class="col-md-4">
                                <span class="badge" style="background: rgba(5,149,104,.12); color: #059568;">
                                    <i class="bx bx-book me-1"></i> Qur'an
                                </span>
                                <small class="d-block text-muted">{{ $consultancy->quran_reference }}</small>
                            </div>
                            @endif
                            @if($consultancy->hadith_reference)
                            <div class="col-md-4">
                                <span class="badge" style="background: rgba(13,110,253,.12); color: #0d6efd;">
                                    <i class="bx bx-bookmark me-1"></i> Hadith
                                </span>
                                <small class="d-block text-muted">{{ $consultancy->hadith_reference }}</small>
                            </div>
                            @endif
                            @if($consultancy->scholar_reference)
                            <div class="col-md-4">
                                <span class="badge" style="background: rgba(108,117,125,.12); color: #6c757d;">
                                    <i class="bx bx-user me-1"></i> Scholar
                                </span>
                                <small class="d-block text-muted">{{ $consultancy->scholar_reference }}</small>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <small class="text-muted">Reviewed by: {{ $consultancy->reviewer->full_name ?? 'Not yet reviewed' }} @if($consultancy->reviewed_at) on {{ $consultancy->reviewed_at->format('d M Y, H:i') }} @endif</small>
                        @if($consultancy->signed_at)<br><small class="text-success"><i class="bx bx-check-circle me-1"></i> Signed by: {{ $consultancy->signatory->full_name ?? 'Director' }} on {{ $consultancy->signed_at->format('d M Y, H:i') }}</small>@endif
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- ============================================================ -->
<!-- REVIEW MODAL - Fixed Scrolling                               -->
<!-- ============================================================ -->
@can_permission('consultancy.review')
@if(in_array($consultancy->status, ['submitted', 'under_review']))
<div class="modal fade" id="reviewModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); max-height: 90vh;">

            <!-- Modal Header - Fixed -->
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

            <form action="{{ route('consultancy.review', $consultancy->id) }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem 2rem; overflow-y: auto; max-height: calc(90vh - 140px);">

                    <!-- Consultation Summary -->
                    <div class="alert alert-light mb-3" style="border-radius: 10px; border-left: 4px solid #ff9f43; flex-shrink: 0;">
                        <div class="row">
                            <div class="col-md-4">
                                <small class="text-muted">Applicant</small>
                                <div class="fw-bold">{{ $consultancy->applicant_name }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Subject</small>
                                <div>{{ $consultancy->subject ?? 'No subject provided' }}</div>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">Type</small>
                                <span class="badge" style="background: rgba(5,88,15,.08); color:#00580f;">{{ $consultancy->consultation_type_label }}</span>
                            </div>
                        </div>
                    </div>

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

                <!-- Modal Footer - Fixed -->
                <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 1rem 2rem; flex-shrink: 0;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.5rem 1.5rem;">Cancel</button>
                    <button type="submit" class="btn fw-bold text-white" style="background: linear-gradient(135deg, #ff9f43, #f39c12); border: none; border-radius: 10px; padding: 0.5rem 2rem;">
                        <i class="bx bx-check-square me-1"></i> Submit Review
                    </button>
                </div>
           

                <div class="modal-footer">
    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
        <i class="fas fa-times me-2"></i>Close
    </button>
    @if(in_array($consultancy->status, ['approved', 'accomplished']))
        <a href="{{ route('consultancy.print', $consultancy->id) }}" target="_blank" class="btn btn-primary px-4">
            <i class="fas fa-print me-2"></i>Print Certificate
        </a>
    @endif
</div>


            </form>
        </div>
    </div>
</div>
@endif
@endcan_permission

<!-- ============================================================ -->
<!-- STATUS CHANGE MODAL -->
<!-- ============================================================ -->
@full_access
@if(in_array($consultancy->status, ['submitted', 'under_review', 'reviewed']))
<div class="modal fade" id="statusModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: linear-gradient(135deg, #2d3436, #636e72); border-radius: 16px 16px 0 0; padding: 1.5rem 2rem;">
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-circle me-3" style="background: rgba(255,255,255,0.2);">
                        <i class="bx bx-transfer-alt text-white fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title text-white fw-bold mb-0">Change Status</h5>
                        <small class="text-white-50">Update the consultation workflow status</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('consultancy.status', $consultancy->id) }}" method="POST">
                @csrf
                <div class="modal-body" style="padding: 1.5rem 2rem;">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Application ID</label>
                        <div><code>{{ $consultancy->application_id }}</code></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Status</label>
                        <div>
                            <span class="badge rounded-pill" style="background: {{ $consultancy->status_color }}15; color: {{ $consultancy->status_color }}; padding: 0.5rem 1rem;">
                                {{ $consultancy->status_label }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Select New Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" style="border-radius: 10px; border: 2px solid #e9ecef;" required>
                            <option value="">Select Status...</option>
                            <option value="submitted">Submitted</option>
                            <option value="under_review">Under Review</option>
                            <option value="reviewed">Reviewed</option>
                            <option value="approved">Approved</option>
                            <option value="rejected">Rejected</option>
                            <option value="accomplished">Accomplished</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e9ecef; padding: 1rem 2rem;">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.5rem 1.5rem;">Cancel</button>
                    <button type="submit" class="btn fw-bold text-white" style="background: linear-gradient(135deg, #2d3436, #636e72); border: none; border-radius: 10px; padding: 0.5rem 2rem;">
                        <i class="bx bx-check-circle me-1"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endfull_access

<style>
    .modal-content { animation: slideUp 0.3s ease; }
    @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .form-control:focus, .form-select:focus { border-color: #6c5ce7 !important; box-shadow: 0 0 0 0.2rem rgba(108, 92, 231, 0.25) !important; }
    .alert-light { background-color: #f8f9fa; }
</style>
@endsection