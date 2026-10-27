@extends('layouts.app')

@section('content')
    <div class="card border-0 shadow-sm" style="border-radius: 20px; background: white;">
        <div class="card-header bg-white border-0 pt-4 pb-3">
            <div class="d-flex align-items-center justify-content-between">
                <!-- Title -->
                <div>
                    <h5 class="fw-bold mb-0" style="color: #111827;">
                        Create New User Account
                    </h5>
                    <p class="text-muted mb-0 small">
                        Fill in the details to add a new user to the system
                    </p>
                </div>

                <!-- Button -->
                <a href="{{ route('users.dashboard') }}" class="btn fw-bold d-flex align-items-center" style="
                    background: #f0fdf4;
                    color: #00580f;
                    border: 1px solid rgba(5, 88, 15, 0.2);
                    border-radius: 12px;
                    padding: 10px 18px;
               ">
                    <i class="bx bx-home me-2 fs-5"></i>
                    Users Dashboard
                </a>
            </div>
        </div>

        @include('layouts.page-loader')
        <div class="card-body p-4">
            <!-- Add this form ID -->
            <form id="createUserForm" action="{{ route('save.new.user') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Login Credentials Section -->
                    <div class="col-12">
                        <div class="p-4 rounded-4"
                            style="background: rgba(5, 88, 15, 0.08); border: 1px solid rgba(5, 88, 15, 0.1);">
                            <div class="d-flex align-items-center mb-4">
                                <div class="p-3 rounded-circle me-3"
                                    style="background: #00580f;">
                                    <i class="bx bx-lock-alt text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1" style="color: #00580f;">Login Credentials</h6>
                                    <p class="text-muted mb-0 small">Required for account access</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="username" class="form-label fw-bold" style="color: #00580f;">Username
                                        *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-user" style="color: #00580f;"></i>
                                        </span>
                                        <input type="text" name="username" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            placeholder="Enter username" required>
                                        <div class="invalid-feedback">
                                            Please provide a username.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label fw-bold" style="color: #00580f;">Email Address
                                        *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-envelope" style="color: #00580f;"></i>
                                        </span>
                                        <input type="email" name="email" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            placeholder="Enter email" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid email address.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="password" class="form-label fw-bold" style="color: #00580f;">Password
                                        *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-key" style="color: #00580f;"></i>
                                        </span>
                                        <input type="password" name="password" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            id="password" placeholder="Enter password" required>
                                        <span class="input-group-text bg-white border-start-0" id="eye-icon"
                                            style="cursor: pointer;">
                                            <i class="bx bx-hide" style="color: #00580f;"></i>
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide a password.
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Profile Information -->
                    <div class="col-12">
                        <div class="p-4 rounded-4"
                            style="background: rgba(5, 88, 15, 0.08); border: 1px solid rgba(5, 88, 15, 0.1);">
                            <div class="d-flex align-items-center mb-4">
                                <div class="p-3 rounded-circle me-3"
                                    style="background: #00580f;">
                                    <i class="bx bx-user-circle text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1" style="color: #00580f;">Profile Information</h6>
                                    <p class="text-muted mb-0 small">Personal details for the user</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="firstname" class="form-label fw-bold" style="color: #00580f;">First
                                        Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-user" style="color: #00580f;"></i>
                                        </span>
                                        <input type="text" name="firstname" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            placeholder="Enter first name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="lastname" class="form-label fw-bold" style="color: #00580f;">Last
                                        Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-user" style="color: #00580f;"></i>
                                        </span>
                                        <input type="text" name="lastname" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            placeholder="Enter last name" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-bold" style="color: #00580f;">Gender</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-male-female" style="color: #00580f;"></i>
                                        </span>
                                        <select name="gender" class="form-select border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            required>
                                            <option value="">Select gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="phonenumber" class="form-label fw-bold" style="color: #00580f;">Phone
                                        Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-phone" style="color: #00580f;"></i>
                                        </span>
                                        <input type="text" name="phonenumber" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            placeholder="Enter phone number" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="country" class="form-label fw-bold" style="color: #00580f;">Country</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-globe" style="color: #00580f;"></i>
                                        </span>
                                        <input type="text" name="country" class="form-control border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            placeholder="Enter country" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label for="profile_photo" class="form-label fw-bold" style="color: #00580f;">Profile
                                        Photo</label>
                                    <div class="border rounded-3 p-3"
                                        style="border-color: rgba(5, 88, 15, 0.2); border-style: dashed !important;">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3">
                                                <div class="p-3 rounded-circle" style="background: rgba(5, 88, 15, 0.1);">
                                                    <i class="bx bx-camera" style="color: #00580f;"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <input type="file" name="profile_photo" class="form-control border-0"
                                                    id="profile_photo">
                                                <small class="text-muted">JPEG, PNG or GIF (Max 2MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Role & Jurisdiction -->
                    <div class="col-12">
                        <div class="p-4 rounded-4"
                            style="background: rgba(5, 88, 15, 0.08); border: 1px solid rgba(5, 88, 15, 0.1);">
                            <div class="d-flex align-items-center mb-4">
                                <div class="p-3 rounded-circle me-3"
                                    style="background: #00580f;">
                                    <i class="bx bx-shield text-white fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1" style="color: #00580f;">Role & Jurisdiction</h6>
                                    <p class="text-muted mb-0 small">Choose what this account is responsible for on the system</p>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label for="role_id" class="form-label fw-bold" style="color: #00580f;">User Role *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0"
                                            style="border-color: rgba(5, 88, 15, 0.2);">
                                            <i class="bx bx-id-card" style="color: #00580f;"></i>
                                        </span>
                                        <select name="role_id" id="role_id" class="form-select border-start-0"
                                            style="border-color: rgba(5, 88, 15, 0.2); border-radius: 0 10px 10px 0;"
                                            required>
                                            <option value="">Select a role</option>
                                            @forelse ($assignableRoles as $role)
                                                <option value="{{ $role->id }}" data-scope="{{ $role->data_scope }}">
                                                    {{ $role->name }} — {{ $role->visibilityLabel() }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No roles available for you to assign</option>
                                            @endforelse
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a user role.
                                        </div>
                                    </div>
                                    <small class="text-muted d-block mt-1" id="role_description"></small>
                                </div>

                                @php($me = \App\Services\AccessControl::user())
                                @php($lockJurisdiction = !\App\Services\AccessControl::hasFullAccess())
                                @php($myScope = $me?->role?->data_scope)

                                <div class="col-md-3 jurisdiction-field" data-needs="county,district,global">
                                    <label class="form-label fw-bold" style="color: #00580f;">Region</label>
                                    <input type="text" name="region" id="region" class="form-control"
                                        style="border-color: rgba(5, 88, 15, 0.2);"
                                        value="{{ $lockJurisdiction ? $me?->region : '' }}"
                                        {{ $lockJurisdiction ? 'readonly' : '' }}
                                        placeholder="e.g. Busoga Muslim Region" list="regionList">
                                    <datalist id="regionList"></datalist>
                                </div>

                                <div class="col-md-3 jurisdiction-field" data-needs="county,district">
                                    <label class="form-label fw-bold" style="color: #00580f;">District</label>
                                    <input type="text" name="district" id="district" class="form-control"
                                        style="border-color: rgba(5, 88, 15, 0.2);"
                                        value="{{ ($lockJurisdiction && in_array($myScope, ['district', 'county'], true)) ? $me?->district : '' }}"
                                        {{ ($lockJurisdiction && in_array($myScope, ['district', 'county'], true)) ? 'readonly' : '' }}
                                        placeholder="e.g. Bugweri M D" list="districtList">
                                    <datalist id="districtList"></datalist>
                                </div>

                                <div class="col-md-3 jurisdiction-field" data-needs="county">
                                    <label class="form-label fw-bold" style="color: #00580f;">County</label>
                                    <input type="text" name="county" id="county" class="form-control"
                                        style="border-color: rgba(5, 88, 15, 0.2);"
                                        value="{{ ($lockJurisdiction && $myScope === 'county') ? $me?->county : '' }}"
                                        placeholder="e.g. Namalemba County" list="countyList">
                                    <datalist id="countyList"></datalist>
                                </div>

                                <div class="col-md-3 jurisdiction-field" data-needs="">
                                    <label class="form-label fw-bold" style="color: #00580f;">Mosque</label>
                                    <input type="text" name="mosque_name" id="mosque_name" class="form-control"
                                        style="border-color: rgba(5, 88, 15, 0.2);"
                                        placeholder="e.g. Ar-Rahmah Mosque" list="mosqueList">
                                    <datalist id="mosqueList"></datalist>
                                </div>

                                <div class="col-12">
                                    <small class="text-muted">
                                        <i class="bx bx-info-circle me-1" style="color: #00580f;"></i>
                                        The jurisdiction fields shown above change automatically based on the role
                                        selected — a Director needs none, a Regional Assistant only needs a Region, a
                                        District Khadhi only needs a District, a County Sheikh needs a District and
                                        County, and an Imaam needs all four.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 pt-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">
                                    <i class="bx bx-info-circle me-1" style="color: #00580f;"></i>
                                    All fields marked with * are required
                                </small>
                            </div>
                            <button type="submit" class="btn px-4 py-3 fw-bold"
                                style="background: #00580f; color: white; border-radius: 12px;">
                                <i class="bx bx-user-plus me-2"></i> Create User Account
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- SweetAlert JS -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                /* ============== ROLE / JURISDICTION DYNAMIC FIELDS ============== */
                document.addEventListener('DOMContentLoaded', function () {
                    const roleSelect = document.getElementById('role_id');
                    const roleDescription = document.getElementById('role_description');
                    const fields = document.querySelectorAll('.jurisdiction-field');
                    const districtInput = document.getElementById('district');
                    const countyInput = document.getElementById('county');
                    const mosqueInput = document.getElementById('mosque_name');

                    const scopeNeeds = {
                        self: ['region', 'district', 'county', 'mosque'],
                        county: ['region', 'district', 'county'],
                        district: ['region', 'district'],
                        region: ['region'],
                        global: [],
                    };

                    function applyScope(scope) {
                        const needs = scopeNeeds[scope] || [];

                        fields.forEach(field => {
                            const key = field.querySelector('input').id === 'mosque_name' ? 'mosque' : field.querySelector('input').id;
                            const shouldShow = needs.includes(key);
                            field.style.display = shouldShow ? '' : 'none';
                            // Region is required whenever shown (i.e. for every role except
                            // a global/Director one) — it's what every scope below Director
                            // rolls up into, so a blank region silently breaks the Regional
                            // Assistant's and Director's visibility into this account's records.
                            field.querySelector('input').required = shouldShow;
                        });
                    }

                    roleSelect?.addEventListener('change', function () {
                        const opt = this.options[this.selectedIndex];
                        const scope = opt?.dataset?.scope || '';
                        const descriptions = {
                            self: 'Sees and registers cases only for records they personally create.',
                            county: 'Sees their own records plus everything registered by Imaams in their county.',
                            district: 'Sees their own records plus everything registered in their entire district.',
                            region: 'Sees their own records plus everything registered by District Khadhis, County Sheikhs, and Imaams across their region.',
                            global: 'Full, unrestricted access to every record and account on the system.',
                        };
                        roleDescription.textContent = descriptions[scope] || '';
                        applyScope(scope);
                    });

                    // Trigger once on load in case a role is pre-selected
                    if (roleSelect && roleSelect.value) {
                        roleSelect.dispatchEvent(new Event('change'));
                    } else {
                        applyScope('');
                    }

                    /* ============== CASCADING LOCATION SUGGESTIONS ============== */
                    fetch('{{ route("locations.regions") }}')
                        .then(r => r.json())
                        .then(list => {
                            document.getElementById('regionList').innerHTML =
                                list.map(r => `<option value="${r}">`).join('');
                        });

                    fetch('{{ route("locations.districts") }}')
                        .then(r => r.json())
                        .then(list => {
                            document.getElementById('districtList').innerHTML =
                                list.map(d => `<option value="${d}">`).join('');
                        }).catch(() => {});

                    function loadCounties(district) {
                        if (!district) return;
                        fetch(`{{ route('locations.counties') }}?district=${encodeURIComponent(district)}`)
                            .then(r => r.json())
                            .then(list => {
                                document.getElementById('countyList').innerHTML =
                                    list.map(c => `<option value="${c}">`).join('');
                            }).catch(() => {});
                    }

                    function loadMosques(district, county) {
                        if (!district || !county) return;
                        fetch(`{{ route('locations.mosques') }}?district=${encodeURIComponent(district)}&county=${encodeURIComponent(county)}`)
                            .then(r => r.json())
                            .then(list => {
                                document.getElementById('mosqueList').innerHTML =
                                    list.map(m => `<option value="${m.name}">`).join('');
                            }).catch(() => {});
                    }

                    districtInput?.addEventListener('change', () => loadCounties(districtInput.value));
                    countyInput?.addEventListener('change', () => loadMosques(districtInput.value, countyInput.value));

                    if (districtInput?.value) loadCounties(districtInput.value);
                    if (districtInput?.value && countyInput?.value) loadMosques(districtInput.value, countyInput.value);
                });
            </script>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.getElementById('createUserForm');
                    // Jurisdiction inputs become required dynamically once a role is chosen,
                    // so we listen on them too even before they're marked required.
                    const watchedFields = form.querySelectorAll('[required], .jurisdiction-field input');

                    // Input validation on blur and input events
                    watchedFields.forEach(field => {
                        field.addEventListener('blur', function () {
                            if (this.required && !this.value) {
                                this.classList.add('is-invalid');
                                this.classList.remove('is-valid');
                            } else if (this.value) {
                                this.classList.remove('is-invalid');
                                this.classList.add('is-valid');
                            }
                        });

                        field.addEventListener('input', function () {
                            if (this.value) {
                                this.classList.remove('is-invalid');
                                this.classList.add('is-valid');
                            }
                        });
                    });

                    form.addEventListener('submit', function (e) {
                        e.preventDefault();

                        let isValid = true;
                        const invalidFields = [];

                        // Re-check required fields fresh — the jurisdiction fields'
                        // required state changes based on the role selected above.
                        const requiredFields = form.querySelectorAll('[required]');

                        requiredFields.forEach(field => {
                            if (field.offsetParent === null) return; // skip hidden fields

                            if (!field.value.trim()) {
                                field.classList.add('is-invalid');
                                isValid = false;
                                invalidFields.push(field.name);
                            } else {
                                field.classList.remove('is-invalid');
                            }
                        });

                        // Validation error alert
                        if (!isValid) {
                            const firstInvalidField = document.querySelector('.is-invalid');
                            if (firstInvalidField) {
                                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                firstInvalidField.focus();
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Missing Required Fields',
                                text: 'Please fill in all required fields marked with *',
                                confirmButtonColor: '#00580f'
                            });
                            return;
                        }

                        // Confirm creation
                        Swal.fire({
                            title: 'Confirm User Creation',
                            text: 'Are you sure you want to create this user account?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#00580f',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, create user!',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true
                        }).then((result) => {

                            if (!result.isConfirmed) return;

                            const submitBtn = form.querySelector('button[type="submit"]');

                            // Button loading state
                            submitBtn.innerHTML = '<i class="bx bx-loader bx-spin me-2"></i> Creating...';
                            submitBtn.disabled = true;

                            // Show page loader
                            document.getElementById('pageLoader').classList.remove('d-none');

                            const formData = new FormData(form);

                            fetch(form.action, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                },
                                body: formData
                            })
                                .then(async response => {

                                    // ❌ SERVER / VALIDATION / 500 ERROR
                                    if (!response.ok) {
                                        const html = await response.text();
                                        document.body.innerHTML = html; // 👈 SAME AS $.ajax error dump
                                        throw new Error('Server error');
                                    }

                                    return response.json();
                                })
                                .then(data => {

                                    document.getElementById('pageLoader').classList.add('d-none');

                                    if (data.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success 🎉',
                                            text: data.message,
                                            confirmButtonColor: '#00580f'
                                        }).then(() => {
                                            window.location.href = "{{ route('users.dashboard') }}";
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: data.message || 'Something went wrong.',
                                            confirmButtonColor: '#dc3545'
                                        });

                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = 'Create User';
                                    }
                                })
                                .catch(() => {
                                    // Loader already hidden or page replaced
                                    document.getElementById('pageLoader')?.classList.add('d-none');
                                });

                        });
                    });

                    // Email field validation (example for email format)
                    const emailField = form.querySelector('input[type="email"]');
                    if (emailField) {
                        emailField.addEventListener('blur', function () {
                            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (this.value && !emailPattern.test(this.value)) {
                                this.classList.add('is-invalid');
                                const feedback = this.nextElementSibling;
                                if (feedback && feedback.classList.contains('invalid-feedback')) {
                                    feedback.textContent = 'Please enter a valid email address.';
                                }
                            }
                        });
                    }
                });

                const style = document.createElement('style');
                style.textContent = `
        .is-valid {
            border-color: #00580f !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2300580f' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        .is-invalid:focus {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25) !important;
        }

        .is-valid:focus {
            border-color: #00580f !important;
            box-shadow: 0 0 0 0.25rem rgba(5, 88, 15, 0.25) !important;
        }

        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }

        .is-invalid ~ .invalid-feedback {
            display: block;
        }
    `;
                document.head.appendChild(style);
            </script>

            <script>
                // JavaScript to toggle password visibility
                document.getElementById('eye-icon').addEventListener('click', function () {
                    var passwordField = document.getElementById('password');
                    var eyeIcon = this.querySelector('i');

                    // Toggle password visibility
                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        eyeIcon.classList.remove('bx-hide');
                        eyeIcon.classList.add('bx-show');
                    } else {
                        passwordField.type = 'password';
                        eyeIcon.classList.remove('bx-show');
                        eyeIcon.classList.add('bx-hide');
                    }
                });
            </script>
        </div>
    </div>

    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #00580f !important;
            box-shadow: 0 0 0 0.25rem rgba(5, 88, 15, 0.1) !important;
        }
    </style>

    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection