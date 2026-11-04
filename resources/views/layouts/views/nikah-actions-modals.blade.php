{{-- Nikah View / Edit / Delete modals + their JS, rendered ONCE per page.
     Include AFTER the applications loop (never inside it) together with
     layouts.views.case-modal-styles, exactly like divorce-actions-modals. --}}

<!-- SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

{{-- ================= EDIT MODAL ================= --}}
                    <div class="modal fade" id="editApplicationModal" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">

                                <!-- HEADER -->
                                <div class="modal-header text-white" style="background: #00580f; border-radius: 18px 18px 0 0;">
                                    <div>
<h5 class="modal-title fw-bold mb-0">Edit Nikah Application</h5>
<small id="editModalAppId" class="opacity-75"></small>
</div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <form id="editApplicationForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="edit_id">

                                    <div class="modal-body">

                                        <!-- ================= GROOM ================= -->
                                        <h6 class="section-title">Groom Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="small fw-bold mb-1">Given Name</label>
                                                <input type="text" name="groom_given_name" id="groom_given_name"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small fw-bold mb-1">Surname</label>
                                                <input type="text" name="groom_surname" id="groom_surname"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="small fw-bold mb-1">NIN</label>
                                                <input type="text" name="groomNIN" id="groomNIN" class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label class="small fw-bold mb-1">DOB Day</label>
                                                <input type="number" name="groom_day_date_of_birth"
                                                    id="groom_day_date_of_birth" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="small fw-bold mb-1">DOB Month</label>
                                                <input type="number" name="groom_month_date_of_birth"
                                                    id="groom_month_date_of_birth" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="small fw-bold mb-1">DOB Year</label>
                                                <input type="number" name="groom_year_date_of_birth"
                                                    id="groom_year_date_of_birth" class="form-control">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="small fw-bold mb-1">Country</label>
                                                <input type="text" name="groom_country" id="groom_country"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="small fw-bold mb-1">Telephone</label>
                                                <input type="text" name="groom_telephone" id="groom_telephone"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="small fw-bold mb-1">Email</label>
                                                <input type="email" name="groom_email" id="groom_email"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-3">
                                                <label class="small fw-bold mb-1">Tribe</label>
                                                <input type="text" name="groom_tribe" id="groom_tribe" class="form-control">
                                            </div>

                                            <div class="col-md-3"><label class="small fw-bold mb-1">District</label><input type="text"
                                                    name="groom_district" id="groom_district" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">County</label><input type="text"
                                                    name="groom_county" id="groom_county" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Sub County</label><input type="text"
                                                    name="groom_sub_county" id="groom_sub_county" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Parish</label><input type="text"
                                                    name="groom_parish" id="groom_parish" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Village</label><input type="text"
                                                    name="groom_village" id="groom_village" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Plot</label><input type="text" name="groom_plot"
                                                    id="groom_plot" class="form-control"></div>
                                        </div>

                                        <hr>

                                        <!-- ================= BRIDE ================= -->
                                        <h6 class="section-title">Bride Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label class="small fw-bold mb-1">Given Name</label><input type="text"
                                                    name="bride_given_name" id="bride_given_name" class="form-control">
                                            </div>
                                            <div class="col-md-4"><label class="small fw-bold mb-1">Surname</label><input type="text"
                                                    name="bride_surname" id="bride_surname" class="form-control"></div>
                                            <div class="col-md-4"><label class="small fw-bold mb-1">NIN</label><input type="text" name="brideNIN"
                                                    id="brideNIN" class="form-control"></div>

                                            <div class="col-md-2"><label class="small fw-bold mb-1">DOB Day</label><input type="number"
                                                    name="bride_day_date_of_birth" id="bride_day_date_of_birth"
                                                    class="form-control"></div>
                                            <div class="col-md-2"><label class="small fw-bold mb-1">DOB Month</label><input type="number"
                                                    name="bride_month_date_of_birth" id="bride_month_date_of_birth"
                                                    class="form-control"></div>
                                            <div class="col-md-2"><label class="small fw-bold mb-1">DOB Year</label><input type="number"
                                                    name="bride_year_date_of_birth" id="bride_year_date_of_birth"
                                                    class="form-control"></div>

                                            <div class="col-md-3"><label class="small fw-bold mb-1">Country</label><input type="text"
                                                    name="bride_country" id="bride_country" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Telephone</label><input type="text"
                                                    name="bride_telephone" id="bride_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Email</label><input type="email" name="bride_email"
                                                    id="bride_email" class="form-control"></div>

                                            <div class="col-md-3"><label class="small fw-bold mb-1">Tribe</label><input type="text" name="bride_tribe"
                                                    id="bride_tribe" class="form-control"></div>

                                            <div class="col-md-3"><label class="small fw-bold mb-1">District</label><input type="text"
                                                    name="bride_district" id="bride_district" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">County</label><input type="text"
                                                    name="bride_county" id="bride_county" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Sub County</label><input type="text"
                                                    name="bride_sub_county" id="bride_sub_county" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Parish</label><input type="text"
                                                    name="bride_parish" id="bride_parish" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Village</label><input type="text"
                                                    name="bride_village" id="bride_village" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Plot</label><input type="text" name="bride_plot"
                                                    id="bride_plot" class="form-control"></div>
                                        </div>

                                        <hr>

                                        <!-- ================= WITNESSES ================= -->
                                        <h6 class="section-title">Witnesses</h6>
                                        <div class="row g-3">
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Witness 1 Given</label><input type="text"
                                                    name="witness1_given_name" id="witness1_given_name"
                                                    class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Witness 1 Surname</label><input type="text"
                                                    name="witness1_surname" id="witness1_surname" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">NIN</label><input type="text" name="witness1_nin"
                                                    id="witness1_nin" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Telephone</label><input type="text"
                                                    name="witness1_telephone" id="witness1_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label class="small fw-bold mb-1">Address</label><input type="text"
                                                    name="witness1_address" id="witness1_address" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label class="small fw-bold mb-1">District</label><input type="text"
                                                    name="witness1District" id="witness1District" class="form-control">
                                            </div>

                                            <div class="col-md-3"><label class="small fw-bold mb-1">Witness 2 Given</label><input type="text"
                                                    name="witness2_given_name" id="witness2_given_name"
                                                    class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Witness 2 Surname</label><input type="text"
                                                    name="witness2_surname" id="witness2_surname" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">NIN</label><input type="text" name="witness2_nin"
                                                    id="witness2_nin" class="form-control"></div>
                                            <div class="col-md-3"><label class="small fw-bold mb-1">Telephone</label><input type="text"
                                                    name="witness2_telephone" id="witness2_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label class="small fw-bold mb-1">Address</label><input type="text"
                                                    name="witness2_address" id="witness2_address" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label class="small fw-bold mb-1">District</label><input type="text"
                                                    name="witness2District" id="witness2District" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- ================= IMAM ================= -->
                                        <h6 class="section-title">Imam</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="small fw-bold mb-1">Imam Name</label>
                                                <input type="text" name="imam_name" id="imam_name" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- FOOTER -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                            <i class="bx bx-x me-1"></i> Close
                                        </button>

                                        <button type="submit" class="btn px-4 text-white" style="background:#00580f;">
                                            <i class="bx bx-save me-1"></i> Save Changes
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


{{-- ================= VIEW MODAL ================= --}}
                    <div class="modal fade" id="viewApplicationModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px;">
                                <!-- Modal Header -->
                                <div class="modal-header text-white" style="background: #00580f; border-radius: 18px 18px 0 0;">
                                    <div>
                                        <h5 class="modal-title fw-bold text-white"><i
                                                class="fas fa-file-contract me-2"></i>Marriage
                                            Application Details</h5>
                                        <p class="small mb-0 opacity-75">Complete application information</p>
                                    </div>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body p-4">
                                    <!-- Application Info Card -->
                                    <div class="info-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="section-title mb-0">Application Information</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application ID</label>
                                                    <div class="value" id="view_application_id"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application Date</label>
                                                    <div class="value" id="view_date"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application Status</label>
                                                    <div class="value" id="view_status"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Couple Information -->
                                    <h6 class="section-title mt-4">Couple Information</h6>
                                    <div class="row">
                                        <!-- Groom Card -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="info-card person-card">
                                                <div class="d-flex align-items-start">
                                                    <div class="photo-container me-3">
                                                        <img id="view_groom_photo" src="" alt="Groom Photo"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2" style="color:#00580f;">
                                                            <i class="fas fa-user-tie me-2"></i>Groom
                                                        </h6>
                                                        <h5 class="mb-3" id="view_groom"></h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <label>NIN</label>
                                                                <div class="value" id="view_groomNIN"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Date of Birth</label>
                                                                <div class="value" id="view_groom_dob"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Contact</label>
                                                                <div class="value" id="view_groom_contact"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Tribe & Country</label>
                                                                <div class="value" id="view_groom_tribe_country"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="text-muted small">Address</label>
                                                            <p class="mb-0" id="view_groom_address"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride Card -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="info-card person-card bride-card">
                                                <div class="d-flex align-items-start">
                                                    <div class="photo-container me-3">
                                                        <img id="view_bride_photo" src="" alt="Bride Photo"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2" style="color:#be185d;">
                                                            <i class="fas fa-user-dress me-2"></i>Bride
                                                        </h6>
                                                        <h5 class="mb-3" id="view_bride"></h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <label>NIN</label>
                                                                <div class="value" id="view_brideNIN"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Date of Birth</label>
                                                                <div class="value" id="view_bride_dob"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Contact</label>
                                                                <div class="value" id="view_bride_contact"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Tribe & Country</label>
                                                                <div class="value" id="view_bride_tribe_country"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="text-muted small">Address</label>
                                                            <p class="mb-0" id="view_bride_address"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Parents Information -->
                                    <h6 class="section-title mt-4">Parents Information</h6>
                                    <div class="row">
                                        <!-- Groom's Parents -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="parent-card">
                                                <h6 class="fw-bold mb-3" style="color:#00580f;">
                                                    <i class="fas fa-people-roof me-2"></i>Groom's Parents
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Father</label>
                                                            <p class="fw-bold mb-1" id="view_groom_father"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_groomFatherStatus"></span>
                                                                NIN: <span id="view_groom_father_nin"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_groomFatherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Tribe: <span id="view_groomFatherTribe"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Mother</label>
                                                            <p class="fw-bold mb-1" id="view_groom_mother"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_groomMotherStatus"></span>
                                                                NIN: <span id="view_groomMotherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_groomMotherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Maiden Name: <span id="view_groomMotherMaidenName"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's Parents -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="parent-card">
                                                <h6 class="fw-bold mb-3" style="color:#00580f;">
                                                    <i class="fas fa-people-roof me-2"></i>Bride's Parents
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Father</label>
                                                            <p class="fw-bold mb-1" id="view_bride_father"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_brideFatherStatus"></span>
                                                                NIN: <span id="view_brideFatherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_brideFatherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Tribe: <span id="view_brideFatherTribe"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Mother</label>
                                                            <p class="fw-bold mb-1" id="view_bride_mother"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_brideMotherStatus"></span>
                                                                NIN: <span id="view_brideMotherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_brideMotherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Maiden Name: <span id="view_brideMotherMaidenName"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Witnesses -->
                                    <h6 class="section-title mt-4">Witnesses</h6>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="witness-card">
                                                <h6 class="fw-bold mb-3" style="color:#b45309;">
                                                    <i class="fas fa-user-check me-2"></i>Witness 1
                                                </h6>
                                                <p class="fw-bold mb-2" id="view_witness1_name"></p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-id-card me-2"></i>
                                                            NIN: <span id="view_witness1_nin"></span>
                                                        </p>
                                                        <p class="small mb-1">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Phone: <span id="view_witness1_phone"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-map-marker-alt me-2"></i>
                                                            District: <span id="view_witness1_district"></span>
                                                        </p>
                                                        <p class="small mb-0">
                                                            <i class="fas fa-home me-2"></i>
                                                            Address: <span id="view_witness1_address"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="witness-card">
                                                <h6 class="fw-bold mb-3" style="color:#b45309;">
                                                    <i class="fas fa-user-check me-2"></i>Witness 2
                                                </h6>
                                                <p class="fw-bold mb-2" id="view_witness2_name"></p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-id-card me-2"></i>
                                                            NIN: <span id="view_witness2_nin"></span>
                                                        </p>
                                                        <p class="small mb-1">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Phone: <span id="view_witness2_phone"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-map-marker-alt me-2"></i>
                                                            District: <span id="view_witness2_district"></span>
                                                        </p>
                                                        <p class="small mb-0">
                                                            <i class="fas fa-home me-2"></i>
                                                            Address: <span id="view_witness2_address"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Imam Assignment -->
                                    <div class="info-card mt-4">
                                        <h6 class="section-title mb-0">Wedding Imam</h6>
                                        <div class="d-flex align-items-center mt-3">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1" id="view_imam_name"></h5>
                                                <p class="small text-muted mb-0">Imam assigned to conduct the marriage
                                                    ceremony</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-user-circle fa-3x" style="color:#00580f;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer bg-light">
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

{{-- ================= VIEW ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('viewApplicationModal');

    document.querySelectorAll('.view-application').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;

            fetch(`/nikah/applications/${id}`, { headers: { 'Accept': 'application/json' } })
                .then(res => {
                    if (!res.ok) throw new Error('Request failed (' + res.status + ')');
                    return res.json();
                })
                .then(data => {
                    clearModalData();

                    document.getElementById('view_application_id').textContent = data.application_id;

                    const statusKey = data.status === 'submitted' ? 'pending' : data.status;
                    const statusLabel = statusKey.charAt(0).toUpperCase() + statusKey.slice(1);
                    document.getElementById('view_status').innerHTML =
                        `<span class="status-badge status-${statusKey}">${statusLabel}</span>`;

                    document.getElementById('view_date').textContent =
                        new Date(data.created_at).toLocaleDateString('en-US', {
                            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
                            hour: '2-digit', minute: '2-digit'
                        });

                    populatePersonCard('groom', data, true);
                    populatePersonCard('bride', data, false);
                    populateParentCard('groom', data, true);
                    populateParentCard('bride', data, false);
                    populateWitnessCard('witness1', data);
                    populateWitnessCard('witness2', data);

                    const imamEl = document.getElementById('view_imam_name');
                    imamEl.textContent = data.imam_name || 'Not Assigned Yet';
                    imamEl.className = data.imam_name ? 'imam-assigned' : 'imam-not-assigned';

                    bootstrap.Modal.getOrCreateInstance(modalEl).show();
                })
                .catch(err => {
                    console.error('Fetch Error:', err);
                    Swal.fire('Error', 'Could not load the application details.', 'error');
                });
        });
    });

    function clearModalData() {
                // Clear all image sources to prevent showing old images
                document.getElementById('view_groom_photo').src = '';
                document.getElementById('view_bride_photo').src = '';
            }

            function populatePersonCard(type, data, isGroom) {
                const prefix = isGroom ? 'groom' : 'bride';
                const title = isGroom ? 'Groom' : 'Bride';

                // Update photo
                const photoElement = document.getElementById(`view_${prefix}_photo`);
                if (data[`${prefix}_photo_path`]) {
                    photoElement.src = `/storage/${data[`${prefix}_photo_path`]}`;
                    photoElement.style.display = 'block';
                } else {
                    photoElement.style.display = 'none';
                }

                // Update details
                document.getElementById(`view_${prefix}`).textContent =
                    `${data[`${prefix}_given_name`]} ${data[`${prefix}_surname`]}`;
                document.getElementById(`view_${prefix}NIN`).textContent = data[`${prefix}NIN`] || 'Not provided';
                document.getElementById(`view_${prefix}_dob`).textContent = formatDOB(data, prefix);
                document.getElementById(`view_${prefix}_contact`).innerHTML = formatContact(data[
                    `${prefix}_telephone`], data[`${prefix}_email`]);
                document.getElementById(`view_${prefix}_address`).textContent = formatAddress(data, prefix);
                document.getElementById(`view_${prefix}_tribe_country`).textContent =
                    `${data[`${prefix}_tribe`] || 'Not specified'}, ${data[`${prefix}_country`] || 'Not specified'}`;
            }

            function populateParentCard(type, data, isGroom) {
                const prefix = isGroom ? 'groom' : 'bride';

                // Father
                document.getElementById(`view_${prefix}_father`).textContent = data[
                    `${prefix}_father_given_name`] && data[`${prefix}_father_surname`] ?
                    `${data[`${prefix}_father_given_name`]} ${data[`${prefix}_father_surname`]}` :
                    'Not provided';
                document.getElementById(`view_${prefix}FatherStatus`).textContent = data[`${prefix}FatherStatus`] ||
                    'Not specified';
                document.getElementById(`view_${prefix}FatherDistrict`).textContent = data[
                    `${prefix}FatherDistrict`] || 'Not specified';
                document.getElementById(`view_${prefix}FatherTribe`).textContent = data[`${prefix}FatherTribe`] ||
                    'Not specified';

                // Mother
                document.getElementById(`view_${prefix}_mother`).textContent = data[
                    `${prefix}_mother_given_name`] && data[`${prefix}_mother_surname`] ?
                    `${data[`${prefix}_mother_given_name`]} ${data[`${prefix}_mother_surname`]}` :
                    'Not provided';
                document.getElementById(`view_${prefix}MotherStatus`).textContent = data[`${prefix}MotherStatus`] ||
                    'Not specified';
                document.getElementById(`view_${prefix}MotherDistrict`).textContent = data[
                    `${prefix}MotherDistrict`] || 'Not specified';
                document.getElementById(`view_${prefix}MotherMaidenName`).textContent = data[
                    `${prefix}MotherMaidenName`] || 'Not specified';
            }

            function populateWitnessCard(witnessNum, data) {
                const name = `${data[`${witnessNum}_given_name`] || ''} ${data[`${witnessNum}_surname`] || ''}`
                    .trim();
                document.getElementById(`view_${witnessNum}_name`).textContent = name || 'Not provided';
                document.getElementById(`view_${witnessNum}_nin`).textContent = data[`${witnessNum}_nin`] ||
                    'Not provided';
                document.getElementById(`view_${witnessNum}_phone`).textContent = data[`${witnessNum}_telephone`] ||
                    'Not provided';
                document.getElementById(`view_${witnessNum}_address`).textContent = data[`${witnessNum}_address`] ||
                    'Not provided';
                document.getElementById(`view_${witnessNum}_district`).textContent = data[
                    `${witnessNum}District`] || 'Not specified';
            }

            function formatDOB(data, prefix) {
                const day = data[`${prefix}_day_date_of_birth`];
                const month = data[`${prefix}_month_date_of_birth`];
                const year = data[`${prefix}_year_date_of_birth`];

                if (day && month && year) {
                    const date = new Date(year, month - 1, day);
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }
                return 'Not specified';
            }

            function formatContact(phone, email) {
                let html = '';
                if (phone) {
                    html += `<span class="contact-item"><i class="fas fa-phone me-2"></i>${phone}</span>`;
                }
                if (email) {
                    if (phone) html += '<br>';
                    html += `<span class="contact-item"><i class="fas fa-envelope me-2"></i>${email}</span>`;
                }
                return html || 'Not provided';
            }

            function formatAddress(data, prefix) {
                const parts = [
                    data[`${prefix}_village`],
                    data[`${prefix}_parish`],
                    data[`${prefix}_sub_county`],
                    data[`${prefix}_county`],
                    data[`${prefix}_district`]
                ].filter(part => part && part.trim() !== '');

                return parts.length > 0 ? parts.join(', ') : 'Not provided';
            }

            function showError(message) {
                // You can replace this with a toast notification
                alert(message);
            }
});
</script>

{{-- ================= EDIT ================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const editModalEl = document.getElementById('editApplicationModal');
    const editForm = document.getElementById('editApplicationForm');

    document.querySelectorAll('.edit-application').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            fetch(`/nikah/${id}/edit`, { headers: { 'Accept': 'application/json' } })
                .then(res => {
                    if (!res.ok) throw new Error('Request failed (' + res.status + ')');
                    return res.json();
                })
                .then(res => {
                    if (!res.success) {
                        Swal.fire('Error', 'Failed to load application', 'error');
                        return;
                    }
                    const data = res.data;

                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('editModalAppId').textContent = '#' + data.application_id;

                    // Field IDs match column names
                    Object.keys(data).forEach(key => {
                        const field = editForm.querySelector('#' + CSS.escape(key));
                        if (field && field.id !== 'edit_id') field.value = data[key] ?? '';
                    });

                    bootstrap.Modal.getOrCreateInstance(editModalEl).show();
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', 'Could not load the application for editing.', 'error');
                });
        });
    });

    if (editForm) {
        editForm.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Confirm Update',
                text: 'Are you sure you want to save these changes?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                confirmButtonColor: '#00580f',
                cancelButtonColor: '#6b7280'
            }).then(result => {
                if (!result.isConfirmed) return;

                const id = document.getElementById('edit_id').value;

                fetch(`/nikah/${id}/update`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: new FormData(editForm)
                })
                    .then(res => res.json())
                    .then(resp => {
                        bootstrap.Modal.getInstance(editModalEl)?.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated',
                            text: resp.message ?? 'Application updated successfully',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        setTimeout(() => location.reload(), 1500);
                    })
                    .catch(err => {
                        console.error(err);
                        Swal.fire('Error', 'Update failed. Please try again.', 'error');
                    });
            });
        });
    }
});
</script>

{{-- ================= DELETE ================= --}}
<script>
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.delete-application');
    if (!btn) return;

    e.preventDefault();
    e.stopPropagation();
    e.stopImmediatePropagation();

    const id = btn.dataset.id;
    const row = btn.closest('tr');

    Swal.fire({
        title: 'Delete Application?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280'
    }).then(result => {
        if (!result.isConfirmed) return;

        fetch(`/nikah/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
            .then(res => {
                if (!res.ok) throw new Error('Request failed (' + res.status + ')');
                return res.json().catch(() => ({}));
            })
            .then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted Successfully',
                    text: 'The nikah application has been deleted.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#16a34a'
                }).then(() => {
                    if (row) {
                        row.remove();
                    } else {
                        location.reload();
                    }
                });
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Could not delete the application.', 'error');
            });
    });
}, true);
</script>
