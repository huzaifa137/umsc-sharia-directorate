        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg text-white"
                    style="border-radius: 18px; background: linear-gradient(135deg, #0c5f45 0%, #43f5c0 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="fw-bold mb-0 text-white">Smart Search</h5>
                            <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 small"
                                style="backdrop-filter: blur(5px);">
                                <i class="bx bx-chip me-1 text-secondary"></i> <span class="text-success">Smart
                                    Search</span>
                            </span>
                        </div>

                        <div class="row g-3 align-items-end">
                            <div class="col-md-8">
                                <div class="position-relative">
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text bg-white border-0">
                                            <i class="bx bx-search" style="color: #059568;"></i>
                                        </span>
                                        <input type="text" class="form-control border-0 ps-0 py-2" id="smartSearch"
                                            placeholder="Try: 'Mohammad Ahmed marriage certificate' or 'Fatwa on inheritance'"
                                            style="box-shadow: none;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <select class="form-select border-0 py-2" id="searchScope" style="box-shadow: none;">
                                    <option value="" selected>--- Select Category ---</option>
                                    <option value="nikah">Nikah Records</option>
                                    <option value="divorce">Divorce Cases</option>
                                    <option value="inheritance">Inheritance</option>
                                    <option value="fatwa">Islamic Rulings</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <button class="btn btn-white w-100 py-2 shadow-sm"
                                    style="background: white; border: none;">
                                    <i class="bx bx-search-alt-2" style="color: #059568; font-size: 1.2rem;"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a class="text-decoration-none small text-white opacity-75 fw-light"
                                data-bs-toggle="collapse" href="#advancedOptions" role="button">
                                <i class="bx bx-chevron-down me-1"></i> Advanced Search Options
                            </a>
                            <div class="collapse mt-2" id="advancedOptions">
                                <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.1);">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small text-white-50">Date From</label>
                                            <input type="date"
                                                class="form-control form-control-md bg-white border-0">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label small text-white-50">Date To</label>
                                            <input type="date"
                                                class="form-control form-control-md bg-white border-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
