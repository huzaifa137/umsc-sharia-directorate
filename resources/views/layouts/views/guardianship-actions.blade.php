<td class="pe-4 text-end">
    <div class="btn-group shadow-sm action-group" role="group"
        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">

        <!-- View -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end view-guardianship"
            data-id="{{ $application->id }}" title="View Details">
            <i class="bx bx-show-alt fs-5" style="color:#2563eb;"></i>
        </button>

        <!-- Edit -->
        <!-- Edit Button in your table/listing -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end edit-guardianship"
            data-id="{{ $application->id }}" data-bs-toggle="modal" data-bs-target="#editGuardianshipModal"
            title="Edit Entry">
            <i class="bx bx-edit-alt fs-5" style="color:#16a34a;"></i>
        </button>

        <!-- Delete -->
        <button type="button" class="btn btn-white btn-sm px-2 delete-guardianship" data-id="{{ $application->id }}"
            title="Delete Application">
            <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
        </button>

    </div>
</td>

<!-- VIEW MODAL -->
<div class="modal fade" id="viewGuardianshipModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 shadow-lg border-0">

            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white">
                    Guardianship Application
                    <small class="d-block fs-6">#<span id="viewAppId"></span></small>
                </h5>
                <button type="button" class="btn-close btn-close-white"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">

                    <!-- Ward Info -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Ward Information</div>
                            <div class="card-body row g-3">
                                <div class="col-md-4"><strong>Name:</strong> <span id="viewWardName"></span></div>
                                <div class="col-md-4"><strong>Gender:</strong> <span id="viewWardGender"></span></div>
                                <div class="col-md-4"><strong>Age:</strong> <span id="viewWardAge"></span></div>
                                <div class="col-md-6"><strong>DOB:</strong> <span id="viewWardDob"></span></div>
                                <div class="col-md-6"><strong>Type:</strong> <span id="viewWardType"></span></div>
                                <div class="col-md-6"><strong>Guardianship Type:</strong> <span
                                        id="viewGuardianshipType"></span></div>
                                <div class="col-md-6"><strong>Health Conditions:</strong> <span
                                        id="viewHealthConditions"></span></div>
                                <div class="col-md-6"><strong>Education Level:</strong> <span
                                        id="viewWardEducation"></span></div>
                                <div class="col-md-6"><strong>Birth Certificate No:</strong> <span
                                        id="viewBirthCertNumber"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Parental Info -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Parental Information</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6"><strong>Father Name:</strong> <span id="viewFatherName"></span>
                                </div>
                                <div class="col-md-6"><strong>Father Status:</strong> <span
                                        id="viewFatherStatus"></span></div>
                                <div class="col-md-6"><strong>Mother Name:</strong> <span id="viewMotherName"></span>
                                </div>
                                <div class="col-md-6"><strong>Mother Status:</strong> <span
                                        id="viewMotherStatus"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Guardian Info -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Guardian Information</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6"><strong>Name:</strong> <span id="viewGuardianName"></span></div>
                                <div class="col-md-6"><strong>Gender:</strong> <span id="viewGuardianGender"></span>
                                </div>
                                <div class="col-md-6"><strong>DOB:</strong> <span id="viewGuardianDob"></span></div>
                                <div class="col-md-6"><strong>NIN:</strong> <span id="viewGuardianNIN"></span></div>
                                <div class="col-md-6"><strong>Relationship:</strong> <span id="viewRelationship"></span>
                                </div>
                                <div class="col-md-6"><strong>Phone:</strong> <span id="viewGuardianPhone"></span></div>
                                <div class="col-12"><strong>Address:</strong> <span id="viewGuardianAddress"></span>
                                </div>
                                <div class="col-md-6"><strong>Previous Experience:</strong> <span
                                        id="viewPreviousExperience"></span></div>
                                <div class="col-md-6"><strong>Criminal Record:</strong> <span
                                        id="viewCriminalRecord"></span></div>
                                <div class="col-md-6"><strong>Health Status:</strong> <span
                                        id="viewHealthStatus"></span></div>
                                <div class="col-md-6"><strong>Religious Background:</strong> <span
                                        id="viewReligiousBackground"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Guardianship Terms -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Guardianship Terms</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6"><strong>Duration:</strong> <span id="viewDuration"></span></div>
                                <div class="col-md-6"><strong>Reporting Frequency:</strong> <span
                                        id="viewReportingFrequency"></span></div>
                                <div class="col-md-6"><strong>Powers Granted:</strong> <span
                                        id="viewPowersGranted"></span></div>
                                <div class="col-6"><strong>Restrictions:</strong> <span id="viewRestrictions"></span>
                                </div>
                                <div class="col-12"><strong>Motivation:</strong> <span id="viewMotivation"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Verification -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Verification</div>
                            <div class="card-body row g-3">
                                <div class="col-md-4"><strong>Imam Name:</strong> <span id="viewImamName"></span></div>
                                <div class="col-md-4"><strong>Reg Number:</strong> <span id="viewImamReg"></span></div>
                                <div class="col-md-4"><strong>Mosque:</strong> <span id="viewMosqueName"></span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Witnesses -->
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header fw-bold bg-light">Witnesses</div>
                            <div class="card-body row g-3">
                                <div class="col-md-6"><strong>Witness 1 Name:</strong> <span
                                        id="viewWitness1Name"></span></div>
                                <div class="col-md-6"><strong>Witness 1 NIN:</strong> <span id="viewWitness1NIN"></span>
                                </div>
                                <div class="col-md-6"><strong>Witness 2 Name:</strong> <span
                                        id="viewWitness2Name"></span></div>
                                <div class="col-md-6"><strong>Witness 2 NIN:</strong> <span id="viewWitness2NIN"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- EDIT MODAL -->
<div class="modal fade" id="editGuardianshipModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius:18px;">

            <form id="editGuardianshipForm">
                @csrf
                <input type="hidden" name="application_id" id="editApplicationId">

                <!-- Header -->
                <div class="modal-header text-white" style="background: linear-gradient(135deg,#16a34a,#15803d);">
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Edit Guardianship Application</h5>
                        <small id="editModalAppId" class="opacity-75"></small>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4">
                    <div class="row g-4">

                        <!-- Ward Information -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Ward Information</div>
                                <div class="card-body row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Ward Name</label>
                                        <input type="text" class="form-control" id="editWardName" name="ward_name">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" id="editWardGender" name="ward_gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Age</label>
                                        <input type="number" class="form-control" id="editWardAge" name="ward_age">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">DOB</label>
                                        <input type="date" class="form-control" id="editWardDob" name="ward_dob">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Type</label>
                                        <input type="text" class="form-control" id="editWardType" name="ward_type">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Guardianship Type</label>
                                        <select class="form-select" id="editGuardianshipType" name="guardianship_type">
                                            <option value="minor">Minor</option>
                                            <option value="incapacitated">Incapacitated</option>
                                            <option value="testamentary">Testamentary</option>
                                            <option value="emergency">Emergency</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Health Conditions</label>
                                        <input type="text" class="form-control" id="editHealthConditions"
                                            name="health_conditions">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Education Level</label>
                                        <select class="form-select" id="editWardEducation" name="ward_education_level">
                                            <option value="">Select</option>
                                            <option value="none">None</option>
                                            <option value="nursery">Nursery</option>
                                            <option value="primary">Primary</option>
                                            <option value="secondary">Secondary</option>
                                            <option value="vocational">Vocational</option>
                                            <option value="university">University</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Birth Certificate Number</label>
                                        <input type="text" class="form-control" id="editBirthCertNumber"
                                            name="birth_certificate_number">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Parental Information -->
                        <div class="col-md-6">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Parental Information</div>
                                <div class="card-body row g-3">
                                    <div class="col-6">
                                        <label class="form-label">Father Name</label>
                                        <input type="text" class="form-control" id="editFatherName" name="father_name">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Father Status</label>
                                        <select class="form-select" id="editFatherStatus" name="father_status">
                                            <option value="alive">Alive</option>
                                            <option value="deceased">Deceased</option>
                                            <option value="unknown">Unknown</option>
                                            <option value="incapacitated">Incapacitated</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Mother Name</label>
                                        <input type="text" class="form-control" id="editMotherName" name="mother_name">
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Mother Status</label>
                                        <select class="form-select" id="editMotherStatus" name="mother_status">
                                            <option value="alive">Alive</option>
                                            <option value="deceased">Deceased</option>
                                            <option value="unknown">Unknown</option>
                                            <option value="incapacitated">Incapacitated</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guardian Information -->
                        <div class="col-12">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Guardian Information</div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" id="editGuardianName"
                                            name="guardian_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Gender</label>
                                        <select class="form-select" id="editGuardianGender" name="guardian_gender">
                                            <option value="">Select</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">DOB</label>
                                        <input type="date" class="form-control" id="editGuardianDob"
                                            name="guardian_dob">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">NIN</label>
                                        <input type="text" class="form-control" id="editGuardianNIN"
                                            name="guardian_nin">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Relationship</label>
                                        <select class="form-select" id="editRelationship" name="relationship_to_ward">
                                            <option value="father">Father</option>
                                            <option value="mother">Mother</option>
                                            <option value="relative">Relative</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" id="editGuardianPhone"
                                            name="guardian_phone">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <input type="text" class="form-control" id="editGuardianAddress"
                                            name="guardian_address">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Previous Experience</label>
                                        <input type="text" class="form-control" id="editPreviousExperience"
                                            name="previous_experience">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Criminal Record</label>
                                        <select class="form-select" id="editCriminalRecord" name="criminal_record">
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Health Status</label>
                                        <input type="text" class="form-control" id="editHealthStatus"
                                            name="health_status">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Religious Background</label>
                                        <input type="text" class="form-control" id="editReligiousBackground"
                                            name="religious_background">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Motivation</label>
                                        <input type="text" class="form-control" id="editMotivation" name="motivation">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Guardianship Terms -->
                        <div class="col-12">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Guardianship Terms</div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Duration</label>
                                        <select class="form-select" id="editDuration" name="guardianship_duration">
                                            <option value="until_majority">Until Majority</option>
                                            <option value="specific_period">Specific Period</option>
                                            <option value="indefinite">Indefinite</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Reporting Frequency</label>
                                        <select class="form-select" id="editReportingFrequency"
                                            name="reporting_frequency">
                                            <option value="">None</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="annually">Annually</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Powers Granted</label>
                                        <input type="text" class="form-control" id="editPowersGranted"
                                            name="powers_granted">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Restrictions</label>
                                        <input type="text" class="form-control" id="editRestrictions"
                                            name="restrictions">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Verification -->
                        <div class="col-12">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Verification</div>
                                <div class="card-body row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Imam Name</label>
                                        <input type="text" class="form-control" id="editImamName" name="imam_name">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Imam Reg Number</label>
                                        <input type="text" class="form-control" id="editImamReg" name="imam_reg_number">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Mosque Name</label>
                                        <input type="text" class="form-control" id="editMosqueName" name="mosque_name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Witnesses -->
                        <div class="col-12">
                            <div class="card h-100 border-0 shadow-sm">
                                <div class="card-header fw-bold bg-light">Witnesses</div>
                                <div class="card-body row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Witness 1 Name</label>
                                        <input type="text" class="form-control" id="editWitness1Name"
                                            name="witness1_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Witness 1 NIN</label>
                                        <input type="text" class="form-control" id="editWitness1NIN"
                                            name="witness1_nin">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Witness 2 Name</label>
                                        <input type="text" class="form-control" id="editWitness2Name"
                                            name="witness2_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Witness 2 NIN</label>
                                        <input type="text" class="form-control" id="editWitness2NIN"
                                            name="witness2_nin">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success px-4">
                        <i class="bx bx-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /* ================= VIEW ================= */
        document.querySelectorAll('.view-guardianship').forEach(btn => {
            btn.addEventListener('click', () => {

                fetch(`/guardianship/${btn.dataset.id}/details`)
                    .then(res => res.json())
                    .then(d => {

                        viewAppId.innerText = d.application_id;
                        viewWardName.innerText = d.ward_name;
                        viewWardGender.innerText = d.ward_gender;
                        viewWardAge.innerText = d.ward_age;
                        viewWardDob.innerText = d.ward_dob;
                        viewWardType.innerText = d.ward_type;

                        viewGuardianName.innerText = d.guardian_name;
                        viewGuardianNIN.innerText = d.guardian_nin;
                        viewGuardianPhone.innerText = d.guardian_phone;
                        viewGuardianAddress.innerText = d.guardian_address;

                        viewDuration.innerText = d.guardianship_duration;
                        viewMotivation.innerText = d.motivation;

                        bootstrap.Modal.getOrCreateInstance(viewGuardianshipModal).show();
                    });
            });
        });

        /* ================= EDIT ================= */
        document.addEventListener('DOMContentLoaded', () => {

            /* ================= VIEW ================= */
            document.querySelectorAll('.view-guardianship').forEach(btn => {
                btn.addEventListener('click', () => {
                    fetch(`/guardianship/${btn.dataset.id}/details`)
                        .then(res => res.json())
                        .then(d => {

                            viewAppId.innerText = d.application_id;
                            viewWardName.innerText = d.ward_name;
                            viewWardGender.innerText = d.ward_gender;
                            viewWardAge.innerText = d.ward_age;
                            viewWardDob.innerText = d.ward_dob;
                            viewWardType.innerText = d.ward_type;

                            viewGuardianName.innerText = d.guardian_name;
                            viewGuardianNIN.innerText = d.guardian_nin;
                            viewGuardianPhone.innerText = d.guardian_phone;
                            viewGuardianAddress.innerText = d.guardian_address;

                            viewDuration.innerText = d.guardianship_duration;
                            viewMotivation.innerText = d.motivation;

                            bootstrap.Modal.getOrCreateInstance(viewGuardianshipModal).show();
                        });
                });
            });

            /* ================= EDIT ================= */
            // EDIT MODAL HANDLER
            document.addEventListener('DOMContentLoaded', function () {
                // Event delegation for edit buttons
                document.addEventListener('click', function (e) {
                    if (!e.target.closest('.edit-guardianship')) return;

                    const button = e.target.closest('.edit-guardianship');
                    const id = button.dataset.id;

                    console.log('Edit clicked for ID:', id); // Debug
                    loadEditData(id);
                });

                // Function to load data into edit modal
                function loadEditData(id) {
                    const form = document.getElementById('editGuardianshipForm');
                    if (!form) {
                        console.error('Edit form not found');
                        return;
                    }

                    form.reset();

                    fetch(`/guardianship/${id}/details`)
                        .then(res => {
                            if (!res.ok) {
                                throw new Error(`HTTP error! Status: ${res.status}`);
                            }
                            return res.json();
                        })
                        .then(data => {
                            console.log('Received data:', data); // Debug

                            // Fill ALL fields
                            document.getElementById('editApplicationId').value = data.id || data.application_id;
                            document.getElementById('editModalAppId').innerText = `App ID: ${data.application_id || data.id}`;

                            // Ward Information - CORRECTED NAMES
                            document.getElementById('editWardName').value = data.ward_name || '';
                            document.getElementById('editWardGender').value = data.ward_gender || 'male';
                            document.getElementById('editWardAge').value = data.ward_age || '';
                            document.getElementById('editWardDob').value = data.ward_dob || '';
                            document.getElementById('editWardType').value = data.ward_type || '';
                            document.getElementById('editGuardianshipType').value = data.guardianship_type || 'minor';
                            document.getElementById('editHealthConditions').value = data.health_conditions || '';
                            document.getElementById('editWardEducation').value = data.ward_education_level || '';
                            document.getElementById('editBirthCertNumber').value = data.birth_certificate_number || '';

                            // Parental Information - CORRECTED NAMES
                            document.getElementById('editFatherName').value = data.father_name || '';
                            document.getElementById('editFatherStatus').value = data.father_status || 'alive';
                            document.getElementById('editMotherName').value = data.mother_name || '';
                            document.getElementById('editMotherStatus').value = data.mother_status || 'alive';

                            // Guardian Information - CORRECTED NAMES
                            document.getElementById('editGuardianName').value = data.guardian_name || '';
                            document.getElementById('editGuardianGender').value = data.guardian_gender || '';
                            document.getElementById('editGuardianDob').value = data.guardian_dob || '';
                            document.getElementById('editGuardianNIN').value = data.guardian_nin || '';
                            document.getElementById('editRelationship').value = data.relationship_to_ward || 'father';
                            document.getElementById('editGuardianPhone').value = data.guardian_phone || '';
                            document.getElementById('editGuardianAddress').value = data.guardian_address || '';
                            document.getElementById('editPreviousExperience').value = data.previous_experience || '';
                            document.getElementById('editCriminalRecord').value = data.criminal_record || 'no';
                            document.getElementById('editHealthStatus').value = data.health_status || '';
                            document.getElementById('editReligiousBackground').value = data.religious_background || '';
                            document.getElementById('editMotivation').value = data.motivation || '';

                            // Guardianship Terms - CORRECTED NAMES
                            document.getElementById('editDuration').value = data.guardianship_duration || 'until_majority';
                            document.getElementById('editReportingFrequency').value = data.reporting_frequency || '';
                            document.getElementById('editPowersGranted').value = data.powers_granted || '';
                            document.getElementById('editRestrictions').value = data.restrictions || '';

                            // Verification - CORRECTED NAMES
                            document.getElementById('editImamName').value = data.imam_name || '';
                            document.getElementById('editImamReg').value = data.imam_reg_number || '';
                            document.getElementById('editMosqueName').value = data.mosque_name || '';

                            // Witnesses - CORRECTED NAMES
                            document.getElementById('editWitness1Name').value = data.witness1_name || '';
                            document.getElementById('editWitness1NIN').value = data.witness1_nin || '';
                            document.getElementById('editWitness2Name').value = data.witness2_name || '';
                            document.getElementById('editWitness2NIN').value = data.witness2_nin || '';

                            // Show modal
                            const modalEl = document.getElementById('editGuardianshipModal');
                            if (modalEl) {
                                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                modal.show();
                            }

                        }).catch(err => {
                            console.error('Error loading edit data:', err);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Failed to load application data. Please try again.',
                                icon: 'error'
                            });
                        });
                }

                // Form submission handler - UPDATE THE FORM DATA TO MATCH YOUR DATABASE
                const editForm = document.getElementById('editGuardianshipForm');
                if (editForm) {
                    editForm.addEventListener('submit', function (e) {
                        e.preventDefault();

                        Swal.fire({
                            title: 'Update Application?',
                            text: 'Are you sure you want to update this guardianship application?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#16a34a',
                            confirmButtonText: 'Yes, update it!',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const id = document.getElementById('editApplicationId').value;

                                // Create FormData with proper field names
                                const formData = new FormData(editForm);

                                // Make sure the ID is included
                                formData.append('id', id);

                                fetch(`/guardianship/${id}/update`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                        'Accept': 'application/json'
                                    },
                                    body: formData
                                })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(`HTTP error! Status: ${response.status}`);
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                title: 'Success!',
                                                text: data.message || 'Application updated successfully.',
                                                icon: 'success'
                                            }).then(() => {
                                                const modal = bootstrap.Modal.getInstance(document.getElementById('editGuardianshipModal'));
                                                if (modal) modal.hide();
                                                location.reload();
                                            });
                                        } else {
                                            Swal.fire('Error!', data.message || 'Update failed.', 'error');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Update error:', error);
                                        Swal.fire('Error!', 'Failed to update application. Please try again.', 'error');
                                    });
                            }
                        });
                    });
                }
            });


            /* ================= UPDATE ================= */
            const editForm = document.getElementById('editGuardianshipForm');
            editForm.addEventListener('submit', e => {
                e.preventDefault();

                Swal.fire({
                    title: 'Update Application?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a'
                }).then(r => {

                    if (!r.isConfirmed) return;

                    const id = document.getElementById('editApplicationId').value;

                    fetch(`/guardianship/${id}/update`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: new FormData(editForm)
                    })
                        .then(res => res.ok ? res.json() : res.text().then(h => document.write(h)))
                        .then(d => {
                            if (!d) return;

                            Swal.fire('Updated!', 'Application updated successfully.', 'success')
                                .then(() => location.href = '/guardianship-dashboard');
                        });
                });
            });

            /* ================= DELETE ================= */
            document.querySelectorAll('.delete-guardianship').forEach(btn => {
                btn.addEventListener('click', () => {

                    Swal.fire({
                        title: 'Delete Application?',
                        text: 'This cannot be undone.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626'
                    }).then(r => {

                        if (!r.isConfirmed) return;

                        fetch(`/guardianship/${btn.dataset.id}/delete`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                            .then(res => res.ok ? res.json() : res.text().then(h => document.write(h)))
                            .then(d => {
                                Swal.fire('Deleted!', 'Application removed.', 'success')
                                    .then(() => location.href = '/guardianship-dashboard');
                            });
                    });
                });
            });
        });


        /* ================= UPDATE ================= */
        editGuardianshipForm.addEventListener('submit', e => {
            e.preventDefault();

            Swal.fire({
                title: 'Update Application?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#16a34a'
            }).then(r => {

                if (!r.isConfirmed) return;

                const id = editApplicationId.value;

                fetch(`/guardianship/${id}/update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(editGuardianshipForm)
                })
                    .then(res => res.ok ? res.json() : res.text().then(h => document.write(h)))
                    .then(d => {
                        if (!d) return;

                        Swal.fire('Updated!', 'Application updated successfully.', 'success')
                            .then(() => location.href = '/guardianship-dashboard');
                    });
            });
        });

        /* ================= DELETE ================= */
        document.querySelectorAll('.delete-guardianship').forEach(btn => {
            btn.addEventListener('click', () => {

                Swal.fire({
                    title: 'Delete Application?',
                    text: 'This cannot be undone.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626'
                }).then(r => {

                    if (!r.isConfirmed) return;

                    fetch(`/guardianship/${btn.dataset.id}/delete`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                        .then(res => res.ok ? res.json() : res.text().then(h => document.write(h)))
                        .then(d => {
                            Swal.fire('Deleted!', 'Application removed.', 'success')
                                .then(() => location.href = '/guardianship-dashboard');
                        });
                });
            });
        });

    });
</script>