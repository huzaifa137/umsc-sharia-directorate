@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="p-4 rounded-3" style="background: linear-gradient(135deg, rgba(122, 31, 162, 0.08) 0%, rgba(122, 31, 162, 0.02) 100%); border: 1px solid rgba(122, 31, 162, 0.1);">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 rounded-circle me-3" style="background: linear-gradient(135deg, #7a1fa2, #9b4dca);">
                                <i class="bx bx-customize text-white fs-3"></i>
                            </div>
                            <div>
                                <h1 class="fw-bold mb-1" style="color: #111827; font-size: 1.6rem;">Roles & Privileges</h1>
                                <p class="text-muted mb-0">Define what each role on the system can see and do</p>
                            </div>
                        </div>

                        @can_permission('roles.manage')
                            <button class="btn fw-bold px-4 py-2" id="openCreateRoleBtn"
                                style="background: linear-gradient(135deg, #7a1fa2, #9b4dca); color: white; border-radius: 12px; border: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(122, 31, 162, 0.3);">
                                <i class="bx bx-plus me-2"></i> Create New Role
                            </button>
                        @endcan_permission
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Cards -->
        <div class="row g-4">
            @forelse ($roles as $role)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="card border-0 h-100 role-card" style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
                        <div class="card-body p-0 d-flex flex-column">
                            <!-- Card Header -->
                            <div class="p-3 p-md-4 position-relative" style="background: {{ $role->color }}08; border-bottom: 3px solid {{ $role->color }};">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center min-w-0">
                                        <div class="p-2 rounded-circle me-2 me-md-3 flex-shrink-0" style="background: {{ $role->color }};">
                                            <i class="bx {{ $role->icon }} text-white fs-4"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <h5 class="fw-bold mb-0 text-truncate" style="color: {{ $role->color }}; max-width: 150px;">{{ $role->name }}</h5>
                                            <small class="text-muted d-block text-truncate" style="max-width: 150px;">
                                                <i class="bx bx-show me-1"></i>{{ $role->visibilityLabel() }}
                                            </small>
                                        </div>
                                    </div>

                                    @if ($role->is_system)
                                        <span class="badge rounded-pill px-2 px-md-3 py-2 flex-shrink-0" style="background: rgba(108,117,125,.12); color:#6c757d; font-weight: 500; font-size: 0.7rem;">
                                            <i class="bx bx-lock-alt me-1"></i>System
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-3 p-md-4 flex-grow-1 d-flex flex-column">
                                <p class="text-muted small mb-3" style="min-height: 38px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $role->description ?: 'No description provided.' }}
                                </p>

                                <!-- Stats Row -->
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                    <span class="badge rounded-pill px-2 px-md-3 py-2" style="background: rgba(5,88,15,.08); color:#00580f; font-weight: 500; font-size: 0.7rem;">
                                        <i class="bx bx-user me-1"></i> {{ $role->users_count }} {{ \Illuminate\Support\Str::plural('account', $role->users_count) }}
                                    </span>
                                    <span class="badge rounded-pill px-2 px-md-3 py-2" style="background: rgba(5,149,128,.08); color:#059580; font-weight: 500; font-size: 0.7rem;">
                                        <i class="bx bx-key me-1"></i>
                                        {{ $role->full_access ? 'Full Access' : $role->permissions->count() . ' perms' }}
                                    </span>
                                    <span class="badge rounded-pill px-2 px-md-3 py-2" style="background: rgba(13,110,253,.08); color:#0d6efd; font-weight: 500; font-size: 0.7rem;">
                                        <i class="bx bx-trending-up me-1"></i>Lv {{ $role->level }}
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="d-flex gap-2 flex-wrap mt-auto">
                                    <button class="btn flex-grow-1 view-role-btn" data-id="{{ $role->id }}"
                                        style="background: rgba(13,110,253,.08); color:#0d6efd; border-radius: 10px; border: none; font-weight: 500; transition: all 0.2s ease; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                        <i class="bx bx-show me-1"></i> View
                                    </button>

                                    @can_permission('roles.manage')
                                        <button class="btn flex-grow-1 edit-role-btn" data-id="{{ $role->id }}"
                                            style="background: {{ $role->color }}15; color: {{ $role->color }}; border-radius: 10px; border: none; font-weight: 500; transition: all 0.2s ease; padding: 0.4rem 0.8rem; font-size: 0.85rem;">
                                            <i class="bx bx-edit me-1"></i> Edit
                                        </button>

                                        @if (!$role->is_system)
                                            <button class="btn delete-role-btn flex-shrink-0" data-id="{{ $role->id }}" data-name="{{ $role->name }}"
                                                style="background: rgba(220,53,69,.08); color:#dc3545; border-radius: 10px; border: none; transition: all 0.2s ease; padding: 0.4rem 0.8rem;">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        @endif
                                    @endcan_permission
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="bx bx-customize fs-1 mb-2" style="color: #7a1fa2;"></i>
                        <p class="mb-0">No roles to display.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- ============== CREATE / EDIT ROLE MODAL ============== -->
    <div class="modal fade" id="roleModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); max-height: 95vh;">

                <div class="modal-header" style="border-bottom: none; padding: 1.5rem 2rem; flex-shrink: 0;">
                    <h5 class="modal-title fw-bold" id="roleModalTitle" style="color:#7a1fa2;">
                        <i class="bx bx-customize me-2"></i>Create New Role
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="roleForm">
                    @csrf
                    <input type="hidden" id="roleId" name="role_id">

                    <div class="modal-body" style="padding: 0 2rem 1.5rem 2rem; overflow-y: auto; max-height: calc(95vh - 180px);">

                        <!-- Basic Information -->
                        <div class="card mb-4" style="border-radius: 16px; border: 1px solid rgba(122, 31, 162, 0.1);">
                            <div class="card-header bg-transparent" style="border-bottom: 1px solid rgba(122, 31, 162, 0.08);">
                                <h6 class="fw-bold mb-0" style="color: #7a1fa2;">
                                    <i class="bx bx-info-circle me-2"></i>Basic Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Role Name <span class="text-danger">*</span></label>
                                        <input type="text" id="roleName" name="name" class="form-control" required
                                            style="border-radius: 10px; border: 2px solid #e9ecef; padding: 0.6rem 1rem;">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Visibility Scope <span class="text-danger">*</span></label>
                                        <select id="roleDataScope" name="data_scope" class="form-select" required
                                            style="border-radius: 10px; border: 2px solid #e9ecef; padding: 0.6rem 1rem;">
                                            <option value="self">🔒 Own records only (e.g. an Imaam)</option>
                                            <option value="county">🏛️ County-wide (e.g. a County Sheikh)</option>
                                            <option value="district">🏢 District-wide (e.g. a District Khadhi)</option>
                                            <option value="region">🌍 Region-wide (e.g. a Regional Assistant)</option>
                                            @full_access
                                                <option value="global" id="globalScopeOption">⭐ Entire system (Director only)</option>
                                            @endfull_access
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Description</label>
                                        <input type="text" id="roleDescription" name="description" class="form-control"
                                            placeholder="What is this role responsible for?"
                                            style="border-radius: 10px; border: 2px solid #e9ecef; padding: 0.6rem 1rem;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Badge Color</label>
                                        <input type="color" id="roleColor" name="color" class="form-control form-control-color w-100"
                                            value="#7a1fa2" style="border-radius: 10px; border: 2px solid #e9ecef; height: 48px;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Rank Level <span class="text-danger">*</span></label>
                                        @php($maxLevel = \App\Services\AccessControl::hasFullAccess() ? 99 : max(1, (\App\Services\AccessControl::role()?->level ?? 1) - 1))
                                        <input type="number" id="roleLevel" name="level" class="form-control"
                                            min="1" max="{{ $maxLevel }}" value="{{ min(15, $maxLevel) }}" required
                                            style="border-radius: 10px; border: 2px solid #e9ecef; padding: 0.6rem 1rem;">
                                        <small class="text-muted">Higher ranks can manage lower ones (max {{ $maxLevel }} for you)</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Role Notice -->
                        <div id="systemRoleNotice" class="alert d-none" style="background: rgba(108,117,125,.06); color:#6c757d; border-radius:12px; border-left: 4px solid #6c757d;">
                            <div class="d-flex align-items-center">
                                <i class="bx bx-info-circle fs-5 me-2"></i>
                                <div>
                                    <strong>System Role</strong> — its name, scope and rank are fixed. You can still
                                    fine-tune which privileges it carries below.
                                </div>
                            </div>
                        </div>

                        <!-- Privileges Section -->
                        <div class="card" style="border-radius: 16px; border: 1px solid rgba(122, 31, 162, 0.1);">
                            <div class="card-header bg-transparent d-flex align-items-center justify-content-between flex-wrap gap-2" style="border-bottom: 1px solid rgba(122, 31, 162, 0.08);">
                                <h6 class="fw-bold mb-0" style="color: #7a1fa2;">
                                    <i class="bx bx-key me-2"></i>Privileges
                                </h6>
                                <div class="d-flex gap-2 flex-wrap">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="selectAllPerms" style="border-radius: 8px; font-size: 0.8rem;">
                                        <i class="bx bx-check-all me-1"></i>Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAllPerms" style="border-radius: 8px; font-size: 0.8rem;">
                                        <i class="bx bx-x me-1"></i>Deselect All
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small mb-3">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Tick everything this role should be able to do. Visibility of records is controlled by the Visibility Scope above.
                                </p>

                                <div class="row g-3" id="permissionGroups">
                                    @foreach ($permissions as $module => $modulePermissions)
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="p-3 rounded-3 h-100 permission-group" style="background: rgba(122, 31, 162, 0.03); border: 1px solid rgba(122, 31, 162, 0.08); transition: all 0.2s ease;">
                                                <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                                                    <span class="fw-bold small" style="color:#7a1fa2;">
                                                        <i class="bx bx-folder-open me-1"></i>{{ $module }}
                                                    </span>
                                                    <a href="#" class="small text-decoration-none select-all-link" data-module="{{ $module }}" style="color: #7a1fa2; font-size: 0.75rem;">
                                                        <i class="bx bx-check-circle me-1"></i>Select all
                                                    </a>
                                                </div>
                                                @foreach ($modulePermissions as $permission)
                                                    <div class="form-check mb-1">
                                                        <input class="form-check-input permission-checkbox" type="checkbox"
                                                            value="{{ $permission->id }}" data-module="{{ $module }}"
                                                            id="perm-{{ $permission->id }}" name="permissions[]"
                                                            style="border-radius: 4px; border: 2px solid #ced4da; cursor: pointer; flex-shrink: 0;">
                                                        <label class="form-check-label small" for="perm-{{ $permission->id }}" style="cursor: pointer; word-break: break-word;">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer" style="border-top: 1px solid rgba(122, 31, 162, 0.08); padding: 1.5rem 2rem; flex-shrink: 0;">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem 1.5rem;">Cancel</button>
                        <button type="submit" class="btn fw-bold text-white" id="roleSubmitBtn"
                            style="background: linear-gradient(135deg, #7a1fa2, #9b4dca); border: none; border-radius: 10px; padding: 0.6rem 2rem; box-shadow: 0 4px 15px rgba(122, 31, 162, 0.3);">
                            <i class="bx bx-save me-1"></i> Save Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============== VIEW ROLE MODAL ============== -->
    <div class="modal fade" id="viewRoleModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.15); max-height: 95vh;">

                <div class="modal-header" style="border-bottom: none; padding: 1.5rem 2rem; flex-shrink: 0;">
                    <h5 class="modal-title fw-bold" style="color:#7a1fa2;">
                        <i class="bx bx-show me-2"></i>Role Details
                    </h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" style="padding: 0 2rem 1.5rem 2rem; overflow-y: auto; max-height: calc(95vh - 140px);" id="viewRoleBody">
                    <!-- populated by JS -->
                </div>

                <div class="modal-footer" style="border-top: 1px solid rgba(122, 31, 162, 0.08); padding: 1.5rem 2rem; flex-shrink: 0;">
                    <button class="btn btn-light" data-bs-dismiss="modal" style="border-radius: 10px; padding: 0.6rem 1.5rem;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert CSS/JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Role Card Hover Effect */
        .role-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.1) !important;
        }

        /* Permission Group Hover */
        .permission-group:hover {
            background: rgba(122, 31, 162, 0.06) !important;
            border-color: rgba(122, 31, 162, 0.2) !important;
        }

        /* Custom Checkbox Styling */
        .permission-checkbox:checked {
            background-color: #7a1fa2 !important;
            border-color: #7a1fa2 !important;
        }

        .permission-checkbox:focus {
            box-shadow: 0 0 0 0.25rem rgba(122, 31, 162, 0.25) !important;
        }

        /* Modal Animation */
        .modal-content {
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modal Scrolling Fix - ensure modal body scrolls */
        .modal-dialog-scrollable .modal-content {
            max-height: 95vh !important;
            overflow: hidden !important;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 0.5rem;
            }

            .modal-body {
                padding: 0 1rem 1rem 1rem !important;
                max-height: calc(90vh - 160px) !important;
            }

            .modal-header,
            .modal-footer {
                padding: 1rem !important;
            }

            .permission-group {
                padding: 1rem !important;
            }

            .role-card {
                margin-bottom: 0.5rem;
            }

            /* Fix text truncation on mobile */
            .role-card .text-truncate {
                max-width: 100px !important;
            }
        }

        @media (max-width: 576px) {
            .role-card .d-flex {
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .role-card .badge {
                font-size: 0.6rem !important;
                padding: 0.25rem 0.5rem !important;
            }

            .role-card .btn {
                font-size: 0.75rem !important;
                padding: 0.3rem 0.6rem !important;
            }

            .role-card .text-truncate {
                max-width: 80px !important;
            }

            .role-card h5 {
                font-size: 0.95rem !important;
            }

            /* Modal on very small screens */
            .modal-body {
                max-height: calc(85vh - 150px) !important;
                padding: 0 0.75rem 0.75rem 0.75rem !important;
            }

            #permissionGroups .col-sm-12 {
                padding: 0 0.25rem;
            }

            .form-check-label {
                font-size: 0.75rem !important;
            }
        }

        /* Button hover effects */
        .view-role-btn:hover {
            background: rgba(13,110,253,0.15) !important;
            transform: scale(1.02);
        }

        .edit-role-btn:hover {
            transform: scale(1.02);
        }

        .delete-role-btn:hover {
            background: rgba(220,53,69,0.15) !important;
            transform: scale(1.02);
        }

        /* Responsive stats badges */
        .badge {
            font-size: 0.7rem;
        }

        @media (max-width: 576px) {
            .badge {
                font-size: 0.6rem !important;
                padding: 0.3rem 0.6rem !important;
            }

            .modal-title {
                font-size: 1rem !important;
            }

            .card-header h6 {
                font-size: 0.9rem !important;
            }
        }

        /* Ensure text doesn't overflow on small cards */
        .min-w-0 {
            min-width: 0;
        }

        .text-truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Fix for permission checkbox labels wrapping */
        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .form-check-input {
            margin-top: 0.15rem;
            flex-shrink: 0;
        }

        .form-check-label {
            word-break: break-word;
            line-height: 1.4;
        }

        /* Fix modal scroll on all browsers */
        .modal {
            overflow-y: auto !important;
        }

        .modal-dialog {
            margin: 1.75rem auto !important;
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 0.5rem !important;
            }
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const rolesData = @json($roles->keyBy('id'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        const roleModalEl = document.getElementById('roleModal');
        const roleModal = bootstrap.Modal.getOrCreateInstance(roleModalEl);
        const viewRoleModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('viewRoleModal'));

        const roleForm = document.getElementById('roleForm');
        const roleIdInput = document.getElementById('roleId');
        const roleModalTitle = document.getElementById('roleModalTitle');
        const systemRoleNotice = document.getElementById('systemRoleNotice');
        const roleNameInput = document.getElementById('roleName');
        const roleDataScope = document.getElementById('roleDataScope');
        const roleDescription = document.getElementById('roleDescription');
        const roleColor = document.getElementById('roleColor');
        const roleLevel = document.getElementById('roleLevel');

        // Select/Deselect All Permissions
        document.getElementById('selectAllPerms')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
        });

        document.getElementById('deselectAllPerms')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        });

        function resetForm() {
            roleForm.reset();
            roleIdInput.value = '';
            roleModalTitle.innerHTML = '<i class="bx bx-customize me-2"></i>Create New Role';
            systemRoleNotice.classList.add('d-none');
            [roleNameInput, roleDataScope, roleLevel].forEach(el => el.disabled = false);
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
        }

        document.getElementById('openCreateRoleBtn')?.addEventListener('click', () => {
            resetForm();
            roleModal.show();
        });

        function populateForm(role) {
            roleIdInput.value = role.id;
            roleNameInput.value = role.name;
            roleDataScope.value = role.data_scope;
            roleDescription.value = role.description ?? '';
            roleColor.value = role.color ?? '#7a1fa2';
            roleLevel.value = role.level;

            document.querySelectorAll('.permission-checkbox').forEach(cb => {
                cb.checked = role.full_access || (role.permissions || []).some(p => p.id == cb.value);
            });

            if (role.is_system) {
                systemRoleNotice.classList.remove('d-none');
                [roleNameInput, roleDataScope, roleLevel].forEach(el => el.disabled = true);
            } else {
                systemRoleNotice.classList.add('d-none');
                [roleNameInput, roleDataScope, roleLevel].forEach(el => el.disabled = false);
            }
        }

        document.querySelectorAll('.edit-role-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const role = rolesData[btn.dataset.id];
                resetForm();
                roleModalTitle.innerHTML = '<i class="bx bx-edit me-2"></i>Edit Role';
                populateForm(role);
                roleModal.show();

                // Ensure modal body scrolls to top when opened
                setTimeout(() => {
                    const modalBody = document.querySelector('#roleModal .modal-body');
                    if (modalBody) {
                        modalBody.scrollTop = 0;
                    }
                }, 100);
            });
        });

        document.querySelectorAll('.view-role-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const role = rolesData[btn.dataset.id];
                const perms = role.full_access
                    ? '<span class="badge" style="background:rgba(122,31,162,.12); color:#7a1fa2; padding: 0.5rem 1rem; border-radius: 8px;">⭐ Full, unrestricted access</span>'
                    : (role.permissions && role.permissions.length
                        ? role.permissions.map(p => `<span class="badge me-1 mb-1" style="background:rgba(5,88,15,.08); color:#00580f; padding: 0.4rem 0.8rem; border-radius: 6px;">${p.name}</span>`).join('')
                        : '<span class="text-muted">No privileges assigned yet.</span>');

                const visibilityIcon = {
                    'self': '🔒',
                    'county': '🏛️',
                    'district': '🏢',
                    'region': '🌍',
                    'global': '⭐'
                };

                document.getElementById('viewRoleBody').innerHTML = `
                    <div class="mb-4" style="background: ${role.color}08; border-radius: 16px; padding: 1.5rem; border-left: 4px solid ${role.color};">
                        <div class="d-flex align-items-center flex-wrap gap-3">
                            <div class="p-3 rounded-circle flex-shrink-0" style="background: ${role.color};">
                                <i class="bx ${role.icon} text-white fs-4"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0" style="color:${role.color}">${role.name}</h5>
                                <p class="text-muted mb-0">${role.description ?? 'No description provided.'}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4 col-sm-6">
                            <div class="p-3 rounded-3" style="background: rgba(13,110,253,.04); border: 1px solid rgba(13,110,253,.08);">
                                <small class="text-muted d-block">Visibility Scope</small>
                                <span class="fw-bold">${visibilityIcon[role.data_scope] || ''} ${role.data_scope}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="p-3 rounded-3" style="background: rgba(13,110,253,.04); border: 1px solid rgba(13,110,253,.08);">
                                <small class="text-muted d-block">Rank Level</small>
                                <span class="fw-bold">Level ${role.level}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="p-3 rounded-3" style="background: rgba(13,110,253,.04); border: 1px solid rgba(13,110,253,.08);">
                                <small class="text-muted d-block">Users</small>
                                <span class="fw-bold">${role.users_count} ${role.users_count == 1 ? 'account' : 'accounts'}</span>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold mb-3" style="color:#7a1fa2;">
                        <i class="bx bx-key me-2"></i>Privileges
                    </h6>
                    <div class="d-flex flex-wrap gap-1">${perms}</div>

                    ${role.is_system ? `
                        <div class="mt-3 alert" style="background: rgba(108,117,125,.06); color:#6c757d; border-radius:12px; border-left: 4px solid #6c757d;">
                            <i class="bx bx-lock-alt me-1"></i>
                            This is a built-in system role — its core attributes are fixed.
                        </div>
                    ` : ''}
                `;
                viewRoleModal.show();

                // Ensure modal body scrolls to top when opened
                setTimeout(() => {
                    const modalBody = document.querySelector('#viewRoleModal .modal-body');
                    if (modalBody) {
                        modalBody.scrollTop = 0;
                    }
                }, 100);
            });
        });

        document.querySelectorAll('.delete-role-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                Swal.fire({
                    title: `Delete "${btn.dataset.name}"?`,
                    html: 'This cannot be undone.<br>Accounts must be reassigned to a new role first.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-light'
                    }
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(`/roles/${btn.dataset.id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': csrfToken }
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(() => Swal.fire('Error', 'Unable to delete role.', 'error'));
                });
            });
        });

        document.querySelectorAll('.select-all-link').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const module = link.dataset.module;
                const boxes = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
                const allChecked = [...boxes].every(b => b.checked);
                boxes.forEach(b => b.checked = !allChecked);
            });
        });

        roleForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = roleIdInput.value;
            const isEdit = !!id;

            const payload = {
                name: roleNameInput.value,
                description: roleDescription.value,
                data_scope: roleDataScope.value,
                level: parseInt(roleLevel.value) || 10,
                color: roleColor.value,
                permissions: [...document.querySelectorAll('.permission-checkbox:checked')].map(cb => parseInt(cb.value)),
            };

            const url = isEdit ? `/roles/${id}` : '/roles';
            const method = isEdit ? 'PUT' : 'POST';

            // Show loading state
            const submitBtn = document.getElementById('roleSubmitBtn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Saving...';
            submitBtn.disabled = true;

            fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(payload)
            })
                .then(res => res.json())
                .then(data => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    if (data.status) {
                        roleModal.hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message || 'Unable to save role.', 'error');
                    }
                })
                .catch(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    Swal.fire('Error', 'Unable to save role.', 'error');
                });
        });
    }); // end DOMContentLoaded
    </script>
@endsection