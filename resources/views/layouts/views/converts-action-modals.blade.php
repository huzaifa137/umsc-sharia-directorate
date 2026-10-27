{{-- This partial renders the View/Edit modals + their JS exactly ONCE per page.
     It must be included AFTER the loop over applications, NOT inside it, or
     duplicate element IDs and duplicate event listeners break the buttons. --}}



<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-contract me-2"></i>
                    Convert Application Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Application Info Card -->
                    <div class="col-12 mb-3">
                        <div class="info-card mb-0">
                            <h6 class="section-title mb-3">Application Information</h6>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <label>Application ID</label>
                                        <div class="value" id="viewApplicationId"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <label>Application Date</label>
                                        <div class="value" id="viewCreatedAt"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-item">
                                        <label>Application Status</label>
                                        <div class="value" id="viewStatus"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Navigation -->
                    <div class="col-12">
                        <ul class="nav nav-tabs nav-justified" id="viewTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="stepA-tab" data-bs-toggle="tab"
                                    data-bs-target="#stepA" type="button">
                                    <i class="bx bx-user me-1"></i> Convert's Info
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="stepB-tab" data-bs-toggle="tab" data-bs-target="#stepB"
                                    type="button">
                                    <i class="bx bx-refresh me-1"></i> Conversion
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="stepC-tab" data-bs-toggle="tab" data-bs-target="#stepC"
                                    type="button">
                                    <i class="bx bx-edit me-1"></i> Declaration
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="stepD-tab" data-bs-toggle="tab" data-bs-target="#stepD"
                                    type="button">
                                    <i class="bx bx-check-shield me-1"></i> Verification
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content p-4 border border-top-0 rounded-bottom" id="viewTabContent">
                            <!-- Step A -->
                            <div class="tab-pane fade show active" id="stepA" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Former Names</label>
                                        <div class="fw-bold" id="viewFormerNames"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Former Religion</label>
                                        <div class="fw-bold" id="viewFormerReligion"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Date of Birth</label>
                                        <div class="fw-bold" id="viewDateOfBirth"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Occupation</label>
                                        <div class="fw-bold" id="viewOccupation"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Contact</label>
                                        <div class="fw-bold" id="viewContact"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Current Residence</label>
                                        <div class="fw-bold" id="viewCurrentResidence"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Father's Name</label>
                                        <div class="fw-bold" id="viewFatherName"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Mother's Name</label>
                                        <div class="fw-bold" id="viewMotherName"></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted small">Home Address</label>
                                        <div class="fw-bold" id="viewHomeAddress"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">County</label>
                                        <div class="fw-bold" id="viewCounty"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">District</label>
                                        <div class="fw-bold" id="viewDistrict"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step B -->
                            <div class="tab-pane fade" id="stepB" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">New Names</label>
                                        <div class="fw-bold" id="viewNewNames"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Conversion Date</label>
                                        <div class="fw-bold" id="viewConversionDate"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Conversion Place</label>
                                        <div class="fw-bold" id="viewConversionPlace"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Guardian Name</label>
                                        <div class="fw-bold" id="viewGuardianName"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Guardian Occupation</label>
                                        <div class="fw-bold" id="viewGuardianOccupation"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Guardian Declaration Date</label>
                                        <div class="fw-bold" id="viewGuardianDeclarationDate"></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted small">Conversion Reasons</label>
                                        <div class="fw-bold" id="viewConversionReasons"></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted small">Guardian Declaration</label>
                                        <div class="fw-bold" id="viewGuardianDeclaration"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step C -->
                            <div class="tab-pane fade" id="stepC" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Declaration Date</label>
                                        <div class="fw-bold" id="viewDeclarationDate"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Declaration Agreement</label>
                                        <div>
                                            <span class="badge" id="viewDeclarationAgreement"></span>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted small">Signature</label>
                                        <div id="viewSignatureContainer"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step D -->
                            <div class="tab-pane fade" id="stepD" role="tabpanel">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Officer Name</label>
                                        <div class="fw-bold" id="viewOfficerName"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Officer Position</label>
                                        <div class="fw-bold" id="viewOfficerPosition"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Registration Number</label>
                                        <div class="fw-bold" id="viewRegistrationNumber"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Verification Date</label>
                                        <div class="fw-bold" id="viewVerificationDate"></div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label text-muted small">Officer Remarks</label>
                                        <div class="fw-bold" id="viewOfficerRemarks"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Officer Signature</label>
                                        <div id="viewOfficerSignatureContainer"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label text-muted small">Official Stamp</label>
                                        <div id="viewOfficialStampContainer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- Edit Modal --}}

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-gradient-success text-white">
                <h5 class="modal-title">
                    <i class="bx bx-edit-alt me-2"></i>
                    Edit Application
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editApplicationForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editId">

                <div class="modal-body">
                    <div class="row">
                        <!-- Application Header -->
                        <div class="col-12 mb-4">
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle me-2"></i>
                                Edit the application details below. Required fields are marked with *.
                            </div>
                        </div>

                        <!-- Tabs for Edit -->
                        <div class="col-12">
                            <ul class="nav nav-tabs nav-justified" id="editTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="editStepA-tab" data-bs-toggle="tab"
                                        data-bs-target="#editStepA" type="button">
                                        Convert's Info
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="editStepB-tab" data-bs-toggle="tab"
                                        data-bs-target="#editStepB" type="button">
                                        Conversion Details
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="editStepC-tab" data-bs-toggle="tab"
                                        data-bs-target="#editStepC" type="button">
                                        Declaration
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="editStepD-tab" data-bs-toggle="tab"
                                        data-bs-target="#editStepD" type="button">
                                        Verification
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="editTabContent">
                                <!-- Step A Edit -->
                                <div class="tab-pane fade show active" id="editStepA" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Former Names *</label>
                                            <input type="text" class="form-control" name="former_names"
                                                id="editFormerNames" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Former Religion *</label>
                                            <input type="text" class="form-control" name="former_religion"
                                                id="editFormerReligion" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date of Birth *</label>
                                            <input type="date" class="form-control" name="date_of_birth"
                                                id="editDateOfBirth" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Occupation *</label>
                                            <input type="text" class="form-control" name="occupation"
                                                id="editOccupation" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Contact *</label>
                                            <input type="text" class="form-control" name="contact" id="editContact"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Current Residence *</label>
                                            <input type="text" class="form-control" name="current_residence"
                                                id="editCurrentResidence" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Father's Name *</label>
                                            <input type="text" class="form-control" name="father_name"
                                                id="editFatherName" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mother's Name *</label>
                                            <input type="text" class="form-control" name="mother_name"
                                                id="editMotherName" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Home Address *</label>
                                            <textarea class="form-control" name="home_address" id="editHomeAddress"
                                                rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">County *</label>
                                            <input type="text" class="form-control" name="county" id="editCounty"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">District *</label>
                                            <input type="text" class="form-control" name="district" id="editDistrict"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step B Edit -->
                                <div class="tab-pane fade" id="editStepB" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">New Names</label>
                                            <input type="text" class="form-control" name="new_names" id="editNewNames">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Conversion Date</label>
                                            <input type="date" class="form-control" name="conversion_date"
                                                id="editConversionDate">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Conversion Place</label>
                                            <input type="text" class="form-control" name="conversion_place"
                                                id="editConversionPlace">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Guardian Name</label>
                                            <input type="text" class="form-control" name="guardian_name"
                                                id="editGuardianName">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Guardian Occupation</label>
                                            <input type="text" class="form-control" name="guardian_occupation"
                                                id="editGuardianOccupation">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Guardian Declaration Date</label>
                                            <input type="date" class="form-control" name="guardian_declaration_date"
                                                id="editGuardianDeclarationDate">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Conversion Reasons</label>
                                            <textarea class="form-control" name="conversion_reasons"
                                                id="editConversionReasons" rows="3"></textarea>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Guardian Declaration</label>
                                            <textarea class="form-control" name="guardian_declaration"
                                                id="editGuardianDeclaration" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step C Edit -->
                                <div class="tab-pane fade" id="editStepC" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Declaration Date</label>
                                            <input type="date" class="form-control" name="declaration_date"
                                                id="editDeclarationDate">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Declaration Agreement</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox"
                                                    name="declaration_agreement" id="editDeclarationAgreement"
                                                    value="1">
                                                <label class="form-check-label"
                                                    for="editDeclarationAgreement">Agreed</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Signature File</label>
                                            <input type="file" class="form-control" name="signature" id="editSignature">
                                            <small class="text-muted">Current: <span
                                                    id="currentSignature"></span></small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step D Edit -->
                                <div class="tab-pane fade" id="editStepD" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Officer Name</label>
                                            <input type="text" class="form-control" name="officer_name"
                                                id="editOfficerName">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Officer Position</label>
                                            <input type="text" class="form-control" name="officer_position"
                                                id="editOfficerPosition">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Registration Number</label>
                                            <input type="text" class="form-control" name="registration_number"
                                                id="editRegistrationNumber">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Verification Date</label>
                                            <input type="date" class="form-control" name="verification_date"
                                                id="editVerificationDate">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Officer Remarks</label>
                                            <textarea class="form-control" name="officer_remarks"
                                                id="editOfficerRemarks" rows="3"></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Officer Signature</label>
                                            <input type="file" class="form-control" name="officer_signature"
                                                id="editOfficerSignature">
                                            <small class="text-muted">Current: <span
                                                    id="currentOfficerSignature"></span></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Official Stamp</label>
                                            <input type="file" class="form-control" name="official_stamp"
                                                id="editOfficialStamp">
                                            <small class="text-muted">Current: <span
                                                    id="currentOfficialStamp"></span></small>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" name="status" id="editStatus">
                                                <option value="pending">Pending</option>
                                                <option value="approved">Approved</option>
                                                <option value="rejected">Rejected</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // View Modal Handler
    document.querySelectorAll('.view-application').forEach(button => {
        button.addEventListener('click', function () {
            const application = JSON.parse(this.getAttribute('data-application'));
            populateViewModal(application);
        });
    });

    // Edit Modal Handler
    document.querySelectorAll('.edit-application').forEach(button => {
        button.addEventListener('click', function () {
            const application = JSON.parse(this.getAttribute('data-application'));
            populateEditModal(application);
        });
    });

    // Delete Handler with SweetAlert
    document.querySelectorAll('.delete-application').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            confirmDelete(id);
        });
    });

    function populateViewModal(application) {
        // Application Header
        document.getElementById('viewApplicationId').textContent = `${application.application_id}`;
        document.getElementById('viewStatus').innerHTML =
            `<span class="status-badge status-${application.status}">${(application.status ?? '').charAt(0).toUpperCase() + (application.status ?? '').slice(1)}</span>`;
        document.getElementById('viewCreatedAt').textContent = formatDate(application.created_at);

        // Step A
        document.getElementById('viewFormerNames').textContent = application.former_names || 'N/A';
        document.getElementById('viewFormerReligion').textContent = application.former_religion || 'N/A';
        document.getElementById('viewDateOfBirth').textContent = formatDate(application.date_of_birth) || 'N/A';
        document.getElementById('viewOccupation').textContent = application.occupation || 'N/A';
        document.getElementById('viewContact').textContent = application.contact || 'N/A';
        document.getElementById('viewCurrentResidence').textContent = application.current_residence || 'N/A';
        document.getElementById('viewFatherName').textContent = application.father_name || 'N/A';
        document.getElementById('viewMotherName').textContent = application.mother_name || 'N/A';
        document.getElementById('viewHomeAddress').textContent = application.home_address || 'N/A';
        document.getElementById('viewCounty').textContent = application.county || 'N/A';
        document.getElementById('viewDistrict').textContent = application.district || 'N/A';

        // Step B
        document.getElementById('viewNewNames').textContent = application.new_names || 'N/A';
        document.getElementById('viewConversionDate').textContent = formatDate(application.conversion_date) || 'N/A';
        document.getElementById('viewConversionPlace').textContent = application.conversion_place || 'N/A';
        document.getElementById('viewGuardianName').textContent = application.guardian_name || 'N/A';
        document.getElementById('viewGuardianOccupation').textContent = application.guardian_occupation || 'N/A';
        document.getElementById('viewGuardianDeclarationDate').textContent = formatDate(application.guardian_declaration_date) || 'N/A';
        document.getElementById('viewConversionReasons').textContent = application.conversion_reasons || 'N/A';
        document.getElementById('viewGuardianDeclaration').textContent = application.guardian_declaration || 'N/A';

        // Step C
        document.getElementById('viewDeclarationDate').textContent = formatDate(application.declaration_date) || 'N/A';
        const agreementBadge = application.declaration_agreement
            ? '<span class="badge bg-success">Agreed</span>'
            : '<span class="badge bg-danger">Not Agreed</span>';
        document.getElementById('viewDeclarationAgreement').innerHTML = agreementBadge;

        // Step D
        document.getElementById('viewOfficerName').textContent = application.officer_name || 'N/A';
        document.getElementById('viewOfficerPosition').textContent = application.officer_position || 'N/A';
        document.getElementById('viewRegistrationNumber').textContent = application.registration_number || 'N/A';
        document.getElementById('viewVerificationDate').textContent = formatDate(application.verification_date) || 'N/A';
        document.getElementById('viewOfficerRemarks').textContent = application.officer_remarks || 'N/A';

        // File previews
        showFilePreview('viewSignatureContainer', application.signature);
        showFilePreview('viewOfficerSignatureContainer', application.officer_signature);
        showFilePreview('viewOfficialStampContainer', application.official_stamp);
    }

    function populateEditModal(application) {
        document.getElementById('editId').value = application.id;

        // Step A
        document.getElementById('editFormerNames').value = application.former_names || '';
        document.getElementById('editFormerReligion').value = application.former_religion || '';
        document.getElementById('editDateOfBirth').value = application.date_of_birth || '';
        document.getElementById('editOccupation').value = application.occupation || '';
        document.getElementById('editContact').value = application.contact || '';
        document.getElementById('editCurrentResidence').value = application.current_residence || '';
        document.getElementById('editFatherName').value = application.father_name || '';
        document.getElementById('editMotherName').value = application.mother_name || '';
        document.getElementById('editHomeAddress').value = application.home_address || '';
        document.getElementById('editCounty').value = application.county || '';
        document.getElementById('editDistrict').value = application.district || '';

        // Step B
        document.getElementById('editNewNames').value = application.new_names || '';
        document.getElementById('editConversionDate').value = application.conversion_date || '';
        document.getElementById('editConversionPlace').value = application.conversion_place || '';
        document.getElementById('editGuardianName').value = application.guardian_name || '';
        document.getElementById('editGuardianOccupation').value = application.guardian_occupation || '';
        document.getElementById('editGuardianDeclarationDate').value = application.guardian_declaration_date || '';
        document.getElementById('editConversionReasons').value = application.conversion_reasons || '';
        document.getElementById('editGuardianDeclaration').value = application.guardian_declaration || '';

        // Step C
        document.getElementById('editDeclarationDate').value = application.declaration_date || '';
        document.getElementById('editDeclarationAgreement').checked = application.declaration_agreement || false;
        document.getElementById('currentSignature').textContent = application.signature ? 'File uploaded' : 'No file';

        // Step D
        document.getElementById('editOfficerName').value = application.officer_name || '';
        document.getElementById('editOfficerPosition').value = application.officer_position || '';
        document.getElementById('editRegistrationNumber').value = application.registration_number || '';
        document.getElementById('editVerificationDate').value = application.verification_date || '';
        document.getElementById('editOfficerRemarks').value = application.officer_remarks || '';
        document.getElementById('editStatus').value = application.status || 'pending';
        document.getElementById('currentOfficerSignature').textContent = application.officer_signature ? 'File uploaded' : 'No file';
        document.getElementById('currentOfficialStamp').textContent = application.official_stamp ? 'File uploaded' : 'No file';
    }

    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            customClass: {
                confirmButton: 'swal2-confirm',
                cancelButton: 'swal2-cancel'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX request to delete
                deleteApplication(id);
            }
        });
    }

    function deleteApplication(id) {
        // AJAX delete request
        fetch(`/applications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Deleted!',
                        'Application has been deleted.',
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Failed to delete application.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'Something went wrong.',
                    'error'
                );
            });
    }

    document.getElementById('editApplicationForm').addEventListener('submit', function (e) {
    e.preventDefault();

    Swal.fire({
        title: 'Confirm Update',
        text: 'Are you sure you want to update this application?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, update',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) {
            return; // ❌ user cancelled
        }

        submitEditForm(); // ✅ user confirmed
    });
});

function submitEditForm() {
    const form = document.getElementById('editApplicationForm');
    const formData = new FormData(form);

    fetch(`/applications/${document.getElementById('editId').value}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: formData
    })
    .then(async response => {
        if (!response.ok) {
            const errorText = await response.text();
            document.body.innerHTML = errorText;
            throw new Error('Request failed');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'Application updated successfully.',
                icon: 'success',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(() => {
                location.reload(); // ✅ reload ONLY after OK
            });
        } else {
            Swal.fire(
                'Error!',
                data.message || 'Failed to update application.',
                'error'
            );
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}



    // Utility functions
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function getStatusColor(status) {
        switch (status) {
            case 'approved':
            case 'completed':
                return 'success';
            case 'rejected':
                return 'danger';
            case 'pending':
                return 'warning';
            default:
                return 'secondary';
        }
    }

    function showFilePreview(containerId, filePath) {
        const container = document.getElementById(containerId);
        if (filePath) {
            const ext = filePath.split('.').pop().toLowerCase();
            if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                container.innerHTML = `<img src="${filePath}" class="img-thumbnail" style="max-width: 200px;">`;
            } else {
                container.innerHTML = `<a href="${filePath}" target="_blank" class="btn btn-sm btn-outline-primary">View File</a>`;
            }
        } else {
            container.innerHTML = '<span class="text-muted">No file</span>';
        }
    }

    // Print functionality
    const printBtn = document.querySelector('.print-application');
    if (printBtn) printBtn.addEventListener('click', function () {
        window.print();
    });
</script>

<style>
    <style>

    /* Custom modal styling */
    .modal-header.bg-gradient-primary {
        background: #00580f;
    }

    .modal-header.bg-gradient-success {
        background: #00580f;
    }

    .nav-tabs .nav-link {
        color: #6b7280;
        border: none;
        padding: 12px 20px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .nav-tabs .nav-link.active {
        color: #2563eb;
        background-color: rgba(37, 99, 235, 0.1);
        border-bottom: 3px solid #2563eb;
    }

    .nav-tabs .nav-link:hover:not(.active) {
        color: #4b5563;
        background-color: rgba(107, 114, 128, 0.1);
    }

    .tab-content {
        background: #f9fafb;
        min-height: 400px;
    }

    .form-label {
        font-weight: 500;
        color: #4b5563;
        margin-bottom: 4px;
    }

    .badge {
        padding: 6px 12px;
        font-weight: 500;
    }

    /* SweetAlert customization */
    .swal2-confirm {
        border-radius: 8px !important;
        padding: 10px 24px !important;
    }

    .swal2-cancel {
        border-radius: 8px !important;
        padding: 10px 24px !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .modal-dialog {
            margin: 10px;
        }

        .nav-tabs .nav-link {
            padding: 8px 12px;
            font-size: 14px;
        }
    }
</style>
</style>