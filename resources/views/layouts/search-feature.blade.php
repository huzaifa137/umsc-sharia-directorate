<div class="row mt-4 mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-lg text-white"
            style="border-radius: 18px; background: linear-gradient(135deg, #0c5f45 0%, #43f5c0 100%);">

            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold mb-0 text-white">Smart Search</h5>
                    <span class="badge bg-white bg-opacity-20 text-white px-3 py-2 small">
                        <i class="bx bx-chip me-1 text-secondary"></i>
                        <span class="text-success">Smart Search</span>
                    </span>
                </div>

                <div class="row g-3 align-items-end">
                    <!-- Search Input -->
                    <div class="col-md-8">
                        <div class="input-group input-group-merge">
                            <span class="input-group-text bg-white border-0">
                                <i class="bx bx-search" style="color: #059568;"></i>
                            </span>
                            <input type="text" class="form-control border-0 ps-0 py-2" id="smartSearch"
                                placeholder="Search by Application ID, name, keyword..." style="box-shadow: none;">
                        </div>
                    </div>

                    <!-- Scope -->
                    <div class="col-md-3">
                        <select class="form-select border-0 py-2" id="searchScope">
                            <option value="">--- Select Category ---</option>
                            <option value="nikah">Nikah Records</option>
                            <option value="divorce">Divorce Cases</option>
                            <option value="inheritance">Inheritance</option>
                            <option value="guardianship">Guardianship</option>
                            <option value="convert">Convert</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-1">
                        <button type="button" class="btn btn-white w-100 py-2 shadow-sm" id="smartSearchBtn">
                            <i class="bx bx-search-alt-2" style="color: #059568; font-size: 1.2rem;"></i>
                        </button>
                    </div>
                </div>

                <!-- Advanced -->
                <div class="mt-3">
                    <a class="text-decoration-none small text-white opacity-75 fw-light" data-bs-toggle="collapse"
                        href="#advancedOptions">
                        <i class="bx bx-chevron-down me-1"></i> Advanced Search Options
                    </a>

                    <div class="collapse mt-2" id="advancedOptions">
                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.1);">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-white-50">Date From</label>
                                    <input type="date" class="form-control bg-white border-0" id="dateFrom">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-white-50">Date To</label>
                                    <input type="date" class="form-control bg-white border-0" id="dateTo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results -->
                <div class="mt-4" id="searchResults"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('#smartSearchBtn').on('click', function () {
            const keyword = $('#smartSearch').val().trim();

            if (!keyword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops!',
                    text: 'Please enter a search keyword',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return;
            }

            $.ajax({
                url: '/smart-search',
                method: 'POST',
                data: {
                    keyword: keyword,
                    scope: $('#searchScope').val(),
                    date_from: $('#dateFrom').val(),
                    date_to: $('#dateTo').val(),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (results) {
                    renderSearchResults(results);
                },
                error: function () {
                    alert('Search failed. Please try again.');
                }
            });
        });

    });

    /* ===============================
       Render Results
    ================================ */
    function renderSearchResults(results) {
        let html = '';

        if (!results.length) {
            html = `
            <div class="alert alert-warning">
                No results found.
            </div>
        `;
        } else {
            html = '<ul class="list-group">';

            results.forEach(item => {
                html += `
               <li class="list-group-item bg-dark text-white d-flex justify-content-between align-items-center">
                    <div>
                        <strong>${item.application_id}</strong><br>
                        <small class="text-white">${item.title}</small>
                    </div>
                   <button class="btn btn-sm btn-success"
                        onclick='openResult(${JSON.stringify(item)})'>
                        <i class="bi bi-eye me-1"></i> View
                    </button>
                </li>
            `;
            });

            html += '</ul>';
        }
        $('#searchResults').html(html);
    }


    function openResult(item) {

        const routes = {
            nikah: '/nikah/view/',
            divorce: '/divorce/view/',
            inheritance: '/inheritance/view/',
            guardianship: '/guardianship/view/',
            convert: '/convert/view/'
        };

        if (!routes[item.module]) {
            Swal.fire({
                icon: 'error',
                title: 'Route Not Found',
                html: `<pre style="text-align:left;">${JSON.stringify(item, null, 2)}</pre>`,
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
            return;
        }
        window.location.href = routes[item.module] + item.reference_id;
    }
</script>