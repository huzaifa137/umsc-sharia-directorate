@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 rounded-3" style="background: linear-gradient(135deg, rgba(5, 88, 15, 0.08) 0%, rgba(5, 149, 104, 0.04) 100%); border: 1px solid rgba(5, 88, 15, 0.1);">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-circle me-3" style="background: linear-gradient(135deg, #00580f, #059568);">
                        <i class="bx bx-plus text-white fs-3"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1" style="color: #111827; font-size: 1.6rem;">New Consultation Request</h1>
                        <p class="text-muted mb-0">Submit a matter for Islamic guidance and consultation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-body p-4">
            <form action="{{ route('consultancy.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Applicant Information -->
                    <div class="col-12">
                        <h6 class="fw-bold mb-3" style="color: #00580f;">
                            <i class="bx bx-user me-2"></i>Applicant Information
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="applicant_name" class="form-control @error('applicant_name') is-invalid @enderror"
                            value="{{ old('applicant_name') }}" required style="border-radius: 10px;">
                        @error('applicant_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" name="applicant_phone" class="form-control @error('applicant_phone') is-invalid @enderror"
                            value="{{ old('applicant_phone') }}" required style="border-radius: 10px;">
                        @error('applicant_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email Address</label>
                        <input type="email" name="applicant_email" class="form-control @error('applicant_email') is-invalid @enderror"
                            value="{{ old('applicant_email') }}" style="border-radius: 10px;">
                        @error('applicant_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">National ID (NIN)</label>
                        <input type="text" name="applicant_nin" class="form-control @error('applicant_nin') is-invalid @enderror"
                            value="{{ old('applicant_nin') }}" style="border-radius: 10px;">
                        @error('applicant_nin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Residential Address</label>
                        <input type="text" name="applicant_address" class="form-control @error('applicant_address') is-invalid @enderror"
                            value="{{ old('applicant_address') }}" style="border-radius: 10px;">
                        @error('applicant_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Occupation</label>
                        <input type="text" name="applicant_occupation" class="form-control @error('applicant_occupation') is-invalid @enderror"
                            value="{{ old('applicant_occupation') }}" style="border-radius: 10px;">
                        @error('applicant_occupation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Consultation Details -->
                    <div class="col-12 mt-3">
                        <h6 class="fw-bold mb-3" style="color: #00580f;">
                            <i class="bx bx-message-square-detail me-2"></i>Consultation Details
                        </h6>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Consultation Type <span class="text-danger">*</span></label>
                        <select name="consultation_type" class="form-select @error('consultation_type') is-invalid @enderror"
                            required style="border-radius: 10px;" id="consultationType">
                            <option value="">Select Type...</option>
                            <option value="business" {{ old('consultation_type') == 'business' ? 'selected' : '' }}>Business & Commerce</option>
                            <option value="family" {{ old('consultation_type') == 'family' ? 'selected' : '' }}>Family Matters</option>
                            <option value="financial" {{ old('consultation_type') == 'financial' ? 'selected' : '' }}>Financial & Banking</option>
                            <option value="property" {{ old('consultation_type') == 'property' ? 'selected' : '' }}>Property & Real Estate</option>
                            <option value="employment" {{ old('consultation_type') == 'employment' ? 'selected' : '' }}>Employment & Labor</option>
                            <option value="educational" {{ old('consultation_type') == 'educational' ? 'selected' : '' }}>Educational</option>
                            <option value="health" {{ old('consultation_type') == 'health' ? 'selected' : '' }}>Health & Medical</option>
                            <option value="social" {{ old('consultation_type') == 'social' ? 'selected' : '' }}>Social Issues</option>
                            <option value="religious" {{ old('consultation_type') == 'religious' ? 'selected' : '' }}>Religious Matters</option>
                            <option value="other" {{ old('consultation_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('consultation_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6" id="otherTypeContainer" style="display: none;">
                        <label class="form-label fw-bold">Please Specify</label>
                        <input type="text" name="consultation_type_other" class="form-control @error('consultation_type_other') is-invalid @enderror"
                            value="{{ old('consultation_type_other') }}" style="border-radius: 10px;" placeholder="Specify the type...">
                        @error('consultation_type_other')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Subject / Title</label>
                        <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                            value="{{ old('subject') }}" style="border-radius: 10px;" placeholder="Brief title of the consultation">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Description of the Matter <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                            rows="6" required style="border-radius: 10px;" placeholder="Provide a detailed description of the matter you need guidance on...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Background Information</label>
                        <textarea name="background_info" class="form-control @error('background_info') is-invalid @enderror"
                            rows="4" style="border-radius: 10px;" placeholder="Any additional context, previous efforts, or relevant details...">{{ old('background_info') }}</textarea>
                        @error('background_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Supporting Documents</label>
                        <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror"
                            style="border-radius: 10px;">
                        <small class="text-muted">Accepted formats: PDF, DOC, DOCX, JPG, PNG. Max size: 5MB</small>
                        @error('attachment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <div class="col-12 mt-3">
                        <hr>
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn fw-bold px-5 py-2 text-white"
                                style="background: linear-gradient(135deg, #00580f, #059568); border: none; border-radius: 12px;">
                                <i class="bx bx-send me-2"></i> Submit Consultation
                            </button>
                            <a href="{{ route('consultancy.dashboard') }}" class="btn btn-light px-4 py-2" style="border-radius: 12px;">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('consultationType');
    const otherContainer = document.getElementById('otherTypeContainer');

    typeSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            otherContainer.style.display = 'block';
        } else {
            otherContainer.style.display = 'none';
        }
    });

    // Check on load
    if (typeSelect.value === 'other') {
        otherContainer.style.display = 'block';
    }
});
</script>
@endsection