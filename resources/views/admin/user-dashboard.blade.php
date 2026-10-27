@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Elegant Header with Soft Background -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="p-4 rounded-3 mb-4"
                    style="background: rgba(181, 227, 209, 0.2);">
                    <div class="d-flex align-items-center">
                        <div class="p-3 rounded-circle me-3" style="background: #00580f;">
                            <i class="bx bx-shield text-white fs-3"></i>
                        </div>
                        <div>
                            <h1 class="fw-bold mb-2" style="color: #111827;">User Rights Management</h1>
                            <p class="text-gray-600 mb-0">Manage permissions and access for Imaams, District Qadh, and
                                Directorate Sharias</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Beautiful Role Dashboard Cards -->
        <div class="row g-4 mb-5">
            @foreach ($roleStats as $role)
                <div class="col-xl-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100"
                        style="border-radius: 20px; background: white; overflow: hidden;">
                        <div class="card-body p-0">
                            <!-- Card Header -->
                            <div class="p-4" style="background: {{ $role['bg'] }};">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-3 rounded-circle me-3" style="background: {{ $role['color'] }};">
                                        <i class="bx {{ $role['icon'] }} text-white fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h4 class="fw-bold mb-0" style="color: {{ $role['color'] }};">{{ $role['title'] }}
                                        </h4>
                                        <p class="text-muted mb-0 small">Role Management</p>
                                    </div>
                                    <span class="badge"
                                        style="background: rgba(5, 149, 128, 0.1); color: {{ $role['color'] }}; font-weight: 600;">
                                        {{ $role['stats']['users'] }} Users
                                    </span>
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="p-4">
                                <!-- Mini Stats -->
                                <div class="row g-2 mb-4">
                                    <div class="col-4">
                                        <div class="text-center p-2 rounded" style="background: {{ $role['bg'] }};">
                                            <div class="fw-bold fs-5" style="color: {{ $role['color'] }};">
                                                {{ $role['stats']['active'] }}</div>
                                            <small class="text-muted">Active</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center p-2 rounded" style="background: {{ $role['bg'] }};">
                                            <div class="fw-bold fs-5" style="color: {{ $role['color'] }};">
                                                {{ $role['stats']['pending'] }}</div>
                                            <small class="text-muted">Not Active</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center p-2 rounded" style="background: {{ $role['bg'] }};">
                                            <div class="fw-bold fs-5" style="color: {{ $role['color'] }}">{{ $role['stats']['suspended']  }}</div>
                                            <small class="text-muted">Suspended</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Progress -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Activity</small>
                                        <small style="color: {{ $role['color'] }};">
                                            <i class="bx bx-check-double fs-4"></i>
                                        </small>
                                    </div>
                                    <div class="progress" style="height: 4px; background: #E5E7EB;">
                                        <div class="progress-bar" style="width: 100%; background: {{ $role['color'] }};">
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-grid gap-2">
                                    <a href="{{ url('manage-users') }}?role={{ $role['slug'] }}" class="btn" style="background: {{ $role['color'] }}; color: white;">
                                        <i class="bx bx-group me-2"></i> Manage Users
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Privilege Matrix -->
        <div class="row g-4 mb-5">
            <div class="col-xl-8">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <!-- Header -->
                    <div
                        class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">

                        <!-- Search -->
                        <div class="w-100 me-4">
                            <div class="position-relative" style="max-width: 500px;">
                                <div class="input-group"
                                    style="
                            background: white;
                            border-radius: 12px;
                            border: 1px solid #e2e8f0;
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                            padding: 8px;
                        ">
                                    <span class="input-group-text border-0 bg-transparent">
                                        <i class="bx bx-search-alt-2" style="color:#059568;"></i>
                                    </span>
                                    <input type="text" id="userSearch" class="form-control border-0"
                                        placeholder="Search users..." style="background: transparent; font-weight: 600;">
                                </div>
                            </div>
                        </div>

                        <span class="fw-bold text-nowrap" style="color: #00580F">
                            {{ $users->total() }} Users
                        </span>
                    </div>

                    <!-- Table -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width:1px">No</th>
                                        <th class="ps-4 text-muted small fw-bold">USER</th>
                                        <th class="text-muted small fw-bold">Category</th>
                                        <th class="text-muted small fw-bold">PHONE</th>
                                    </tr>
                                </thead>

                                <tbody id="userTable">
                                    @forelse ($users as $count => $user)
                                        <tr class="border-bottom user-row"
                                            data-search="
                                    {{ strtolower($user->username) }}
                                    {{ strtolower($user->firstname) }}
                                    {{ strtolower($user->lastname) }}
                                ">
                                            <td style="width:1px;">{{ $count + 1 }}</td>

                                            <!-- User -->
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3 rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width: 40px; height: 40px; background:#05956820;">
                                                        <i class="bx bx-user" style="color:#059568;"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold">
                                                            {{ $user->firstname }} {{ $user->lastname }}
                                                        </div>
                                                        <small class="text-muted">{{ $user->username }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Role -->
                                            <td>
                                                <span class="badge rounded-pill px-3 py-1"
                                                    style="background: {{ $user->role_color }}1A; color: {{ $user->role_color }};">
                                                    {{ $user->role_name ?? 'No Role' }}
                                                </span>
                                            </td>

                                            <!-- Phone -->
                                            <td>
                                                {{ $user->phonenumber ?? '—' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="bx bx-user-x fs-1 mb-2"></i>
                                                <p class="mb-0">No users found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="mt-4 me-4">
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; background: white;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="fw-bold mb-0" style="color: #111827;">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            @can_permission('users.create')
                                <a href="{{ url('add-users') }}" class="btn btn-lg d-flex align-items-center p-3"
                                    style="background: #F0FDF9; border: 2px dashed #00580f;">
                                    <div class="p-2 rounded-circle me-3" style="background: #059580;">
                                        <i class="bx bx-user-plus text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-bold" style="color: #00580f;">Add New User</div>
                                        <small class="text-muted">Create new user account</small>
                                    </div>
                                    <i class="bx bx-chevron-right ms-auto" style="color: #059580;"></i>
                                </a>
                            @endcan_permission

                            @can_permission('users.view')
                                <a href="{{ url('manage-users') }}" class="btn btn-lg d-flex align-items-center p-3"
                                    style="background: #F0FDF4; border: 2px dashed #00580f;">
                                    <div class="p-2 rounded-circle me-3" style="background: #20C997;">
                                        <i class="bx bx-shield-alt text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-bold" style="color: #00580f;">Manage Users</div>
                                        <small class="text-muted">Edit user roles & permissions</small>
                                    </div>
                                    <i class="bx bx-chevron-right ms-auto" style="color: #20C997;"></i>
                                </a>
                            @endcan_permission

                            @can_permission('roles.view')
                                <a href="{{ url('roles') }}" class="btn btn-lg d-flex align-items-center p-3"
                                    style="background: #FAF5FF; border: 2px dashed #7a1fa2;">
                                    <div class="p-2 rounded-circle me-3" style="background: #7a1fa2;">
                                        <i class="bx bx-customize text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-bold" style="color: #7a1fa2;">Roles & Privileges</div>
                                        <small class="text-muted">Define roles and what they can access</small>
                                    </div>
                                    <i class="bx bx-chevron-right ms-auto" style="color: #7a1fa2;"></i>
                                </a>
                            @endcan_permission

                            @can_permission('bulk_import.view')
                                <a href="{{ url('bulk-import') }}" class="btn btn-lg d-flex align-items-center p-3"
                                    style="background: #FFF8E6; border: 2px dashed #b58900;">
                                    <div class="p-2 rounded-circle me-3" style="background: #b58900;">
                                        <i class="bx bx-cloud-upload text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <div class="fw-bold" style="color: #b58900;">Bulk Import</div>
                                        <small class="text-muted">Import the Mosque & Imaam directory</small>
                                    </div>
                                    <i class="bx bx-chevron-right ms-auto" style="color: #b58900;"></i>
                                </a>
                            @endcan_permission
                        </div>

                        <div class="mt-4 p-3 rounded"
                            style="background: rgba(5, 149, 128, 0.1);">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-info-circle me-2" style="color: #059580;"></i>
                                <small class="text-muted">Need help? Contact system administrator for privilege
                                    changes.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background: #FFFFFF;
            font-family: 'Inter', sans-serif;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(5, 149, 128, 0.08) !important;
        }

        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            padding-bottom: 20px;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #F3F4F6;
        }

        .timeline-content {
            padding-bottom: 20px;
            border-bottom: 1px solid #F3F4F6;
        }

        .timeline-item:last-child .timeline-content {
            border-bottom: none;
            padding-bottom: 0;
        }

        .badge {
            padding: 0.4em 0.8em;
            font-weight: 600;
            border-radius: 20px;
        }

        .btn-outline {
            border-width: 2px;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
        }
    </style>

    <script>
        document.getElementById('userSearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('.user-row').forEach(row => {
                row.style.display = row.dataset.search.includes(value) ? '' : 'none';
            });
        });
    </script>
@endsection
