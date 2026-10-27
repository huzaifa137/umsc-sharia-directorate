@php
    $canManage = \App\Services\AccessControl::canManageUser($user);
    $canEdit = $canManage && \App\Services\AccessControl::can('users.edit');
    $canDelete = $canManage && \App\Services\AccessControl::can('users.delete');
    $canSuspend = $canManage && \App\Services\AccessControl::can('users.suspend');
    $canBan = $canManage && \App\Services\AccessControl::can('users.ban');
    $isSelf = \App\Services\AccessControl::user()?->id === $user->id;
    $isDirector = \App\Services\AccessControl::hasFullAccess();
@endphp

<div class="btn-group shadow-sm action-group" role="group"
    style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">

    <!-- View -->
    <button type="button" class="btn btn-white btn-sm px-2 border-end view-user"
        data-id="{{ $user->id }}" title="View Profile">
        <i class="bx bx-show-alt fs-5" style="color:#2563eb;"></i>
    </button>

    <!-- Edit -->
    @if ($canEdit)
        <button type="button" class="btn btn-white btn-sm px-2 border-end edit-user"
            data-id="{{ $user->id }}" title="Edit User">
            <i class="bx bx-edit-alt fs-5" style="color:#16a34a;"></i>
        </button>
    @endif

    <!-- Status Actions -->
    @if (($canSuspend || $canBan) && !$isSelf)
        @if ($user->account_status == 10)
            <button type="button" class="btn btn-white btn-sm px-2 border-end status-action"
                data-id="{{ $user->id }}" data-status="9" title="Suspend Account">
                <i class="bx bx-pause-circle fs-5" style="color:#f59e0b;"></i>
            </button>
        @elseif ($user->account_status == 9 || $user->account_status == 0)
            <button type="button" class="btn btn-white btn-sm px-2 border-end status-action"
                data-id="{{ $user->id }}" data-status="10" title="Activate Account">
                <i class="bx bx-play-circle fs-5" style="color:#22c55e;"></i>
            </button>
        @endif
    @endif

    <!-- Delete -->
    @if ($canDelete && !$isSelf)
        <button type="button" class="btn btn-white btn-sm px-2 border-end delete-user"
            data-id="{{ $user->id }}" title="Delete Account">
            <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
        </button>
    @endif

    <!-- Dropdown for additional actions -->
    <div class="dropdown">
        <button class="btn btn-white btn-sm px-2 dropdown-toggle" type="button"
            data-bs-toggle="dropdown" aria-expanded="false" style="border: none;">
            <i class="bx bx-dots-vertical-rounded fs-5" style="color:#6b7280;"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
                <a class="dropdown-item view-user" href="#" data-id="{{ $user->id }}">
                    <i class="bx bx-show me-2 text-primary"></i>View Profile
                </a>
            </li>

            @if ($canEdit)
                <li>
                    <a class="dropdown-item edit-user" href="#" data-id="{{ $user->id }}">
                        <i class="bx bx-edit me-2" style="color: #00580f;"></i>Edit Details
                    </a>
                </li>
            @endif

            @if (($canSuspend || $canBan) && !$isSelf)
                <li><hr class="dropdown-divider"></li>

                @if ($user->account_status != 10 && $canSuspend)
                    <li>
                        <a class="dropdown-item status-action text-success" href="#" data-id="{{ $user->id }}" data-status="10">
                            <i class="bx bx-check-circle me-2"></i>Activate Account
                        </a>
                    </li>
                @endif
                @if ($user->account_status != 9 && $canSuspend)
                    <li>
                        <a class="dropdown-item status-action text-warning" href="#" data-id="{{ $user->id }}" data-status="9">
                            <i class="bx bx-pause-circle me-2"></i>Suspend Account
                        </a>
                    </li>
                @endif
                @if ($user->account_status != 0 && $canBan)
                    <li>
                        <a class="dropdown-item status-action text-danger" href="#" data-id="{{ $user->id }}" data-status="0">
                            <i class="bx bx-block me-2"></i>Ban Account
                        </a>
                    </li>
                @endif
            @endif

            @if ($canDelete && !$isSelf)
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item delete-user text-danger" href="#" data-id="{{ $user->id }}">
                        <i class="bx bx-trash me-2"></i>Delete Account
                    </a>
                </li>
            @endif
        </ul>
    </div>

</div>

<style>
    .action-group .btn {
        background: #ffffff;
        padding-top: 6px;
        padding-bottom: 6px;
        transition: all 0.2s;
        border: none;
    }

    .action-group .btn:hover {
        background: #f8fafc;
        color: #059568 !important;
    }

    .action-group .btn-white i {
        vertical-align: middle;
    }

    .action-group .btn-white.dropdown-toggle {
        padding-left: 8px;
        padding-right: 8px;
    }

    .action-group .btn-white.dropdown-toggle::after {
        display: none;
    }

    .action-group .dropdown-menu {
        border: none;
        border-radius: 10px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        padding: 0.4rem 0;
        min-width: 180px;
        animation: dropdownFade 0.15s ease;
    }

    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-6px) scale(0.96); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .action-group .dropdown-item {
        padding: 0.5rem 1.2rem;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.15s ease;
        color: var(--gray-700);
    }

    .action-group .dropdown-item:hover {
        background: var(--gray-50);
    }

    .action-group .dropdown-item i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }

    .action-group .dropdown-item.text-danger { color: #dc2626; }
    .action-group .dropdown-item.text-danger i { color: #dc2626; }
    .action-group .dropdown-item.text-danger:hover { background: #fef2f2; }
    .action-group .dropdown-item.text-warning { color: #d97706; }
    .action-group .dropdown-item.text-warning i { color: #d97706; }
    .action-group .dropdown-item.text-warning:hover { background: #fffbeb; }
    .action-group .dropdown-item.text-success { color: #16a34a; }
    .action-group .dropdown-item.text-success i { color: #16a34a; }
    .action-group .dropdown-item.text-success:hover { background: #f0fdf4; }

    .action-group .dropdown-divider {
        margin: 0.2rem 0;
        border-color: var(--gray-100);
    }
</style>