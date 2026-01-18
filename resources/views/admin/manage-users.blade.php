@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4 gap-3">
            <!-- LEFT -->
            <div>
                <div class="fw-bold" style="color: #00580f; font-size: 1.5rem;">Manage Users</div>
                <small class="text-muted">Edit user roles & permissions</small>
            </div>

            <!-- CENTER SEARCH -->
            <div class="flex-grow-1 d-flex justify-content-center">
                <div class="position-relative w-100" style="max-width: 420px;">
                    <input type="text" id="userSearch" class="form-control ps-5"
                        placeholder="Search users by name, username, email…"
                        style="border-radius: 12px; border: 1px solid rgba(5, 88, 15, 0.2);">

                    <i class="bx bx-search position-absolute"
                        style="left: 15px; top: 50%; transform: translateY(-50%); color: #00580f;"></i>
                </div>
            </div>

            <!-- RIGHT -->
            <a href="{{ url('add-users') }}" class="btn px-4 py-2 fw-bold"
                style="background: linear-gradient(135deg, #00580f 0%, #059580 100%); color: white; border-radius: 12px;">
                <i class="bx bx-user-plus me-2"></i> Add New User
            </a>
        </div>


        <div class="rounded-4 overflow-hidden border" style="border-color: rgba(5, 88, 15, 0.1) !important;">
            <div class="p-4"
                style="background: linear-gradient(135deg, rgba(5, 88, 15, 0.08) 0%, rgba(5, 149, 128, 0.08) 100%); border-bottom: 1px solid rgba(5, 88, 15, 0.1);">
                <div class="row fw-bold" style="color: #00580f;">
                    <div class="col-md-3">User Information</div>
                    <div class="col-md-2">Contact Details</div>
                    <div class="col-md-2">Account Status</div>
                    <div class="col-md-3">Role & Registration</div>
                    <div class="col-md-2 text-center">Actions</div>
                </div>
            </div>

            <div class="bg-white">
    @foreach ($users as $user)
        <div class="p-4 border-bottom user-row"
            data-search="
                {{ strtolower($user->username) }}
                {{ strtolower($user->firstname) }}
                {{ strtolower($user->lastname) }}
                {{ strtolower($user->email) }}
                {{ strtolower($user->phonenumber) }}
            "
            style="border-color: rgba(5, 88, 15, 0.05) !important;">

            <div class="row align-items-center">
                <!-- User Info -->
                <div class="col-md-3">
                    <div class="d-flex align-items-center">
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}"
                                class="rounded-circle me-3" width="40" height="40"
                                alt="{{ $user->firstname }}">
                        @else
                            <div class="rounded-circle me-3 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; background: linear-gradient(135deg, rgba(5, 88, 15, 0.1) 0%, rgba(5, 149, 128, 0.1) 100%);">
                                <i class="bx bx-user" style="color: #00580f;"></i>
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold" style="color: #00580f;">
                                {{ $user->firstname }} {{ $user->lastname }}
                            </div>
                            <small class="text-muted">{{ $user->username }}</small>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-md-2">
                    <div class="d-flex flex-column">
                        <span class="d-flex align-items-center mb-1">
                            <i class="bx bx-envelope me-1" style="color: #00580f;"></i>
                            <small>{{ $user->email }}</small>
                        </span>
                        <span class="d-flex align-items-center">
                            <i class="bx bx-phone me-1" style="color: #00580f;"></i>
                            <small>{{ $user->phonenumber }}</small>
                        </span>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-2">
                    <span class="badge px-3 py-2 rounded-pill d-inline-flex align-items-center"
                        style="{{ $user->account_status == 10
                            ? 'background: rgba(5, 88, 15, 0.15); color: #00580f;'
                            : ($user->account_status == 0
                                ? 'background: rgba(220, 53, 69, 0.15); color: #dc3545;'
                                : 'background: rgba(255, 193, 7, 0.15); color: #ffc107;') }}">
                        <i class="bx {{ $user->account_status == 10 ? 'bx-check-circle' : ($user->account_status == 0 ? 'bx-x-circle' : 'bx-time') }} me-1"></i>
                        {{ $user->account_status == 10 ? 'Active' : ($user->account_status == 0 ? 'Banned' : 'Pending') }}
                    </span>
                </div>

                <!-- Role & Registration -->
                <div class="col-md-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center">
                            <i class="bx bx-shield me-2" style="color: #00580f;"></i>
                            <span class="fw-bold" style="color: #00580f;">
                                {{ Helper::getUserRole($user->user_role) }}
                            </span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-clipboard me-2" style="color: #00580f;"></i>
                            <span class="{{ $user->registration_status == 1 ? 'text-success' : 'text-warning' }}">
                                {{ $user->registration_status == 1 ? 'Registration Complete' : 'Registration Incomplete' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="col-md-2">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-sm px-3"
                            style="background: rgba(5, 88, 15, 0.1); color: #00580f;">
                            <i class="bx bx-edit"></i>
                        </a>
                        <button class="btn btn-sm px-3"
                            style="background: rgba(220, 53, 69, 0.1); color: #dc3545;">
                            <i class="bx bx-trash"></i>
                        </button>
                        <a href="#" class="btn btn-sm px-3"
                            style="background: rgba(13, 110, 253, 0.1); color: #0d6efd;">
                            <i class="bx bx-show"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

            <!-- Pagination -->
            <div class="mt-4 me-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchInput = document.getElementById('userSearch');
                    const userRows = document.querySelectorAll('.user-row');

                    searchInput.addEventListener('input', function() {
                        const query = this.value.toLowerCase().trim();

                        userRows.forEach(row => {
                            const searchData = row.getAttribute('data-search');

                            if (searchData.includes(query)) {
                                row.style.display = '';
                            } else {
                                row.style.display = 'none';
                            }
                        });
                    });
                });
            </script>

        </div>
    </div>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
