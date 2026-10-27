@extends('layouts.app')

@section('content')
<style>
    /* ================================================================
       PREMIUM CARD DESIGN
    ================================================================ */
    :root {
        --primary: #00580f;
        --primary-light: #059568;
        --primary-dark: #003d0a;
        --primary-gradient: linear-gradient(135deg, #00580f 0%, #059568 100%);
        --primary-bg: #f0fdf4;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
        --shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.08);
        --shadow-lg: 0 8px 30px rgba(0, 0, 0, 0.10);
        --shadow-xl: 0 20px 60px rgba(0, 0, 0, 0.12);
        --radius: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .page-container { padding: 1.5rem 0; max-width: 1400px; margin: 0 auto; }

    .page-header {
        display: flex; justify-content: space-between; align-items: center;
        flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;
    }
    .page-header-left h1 { font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin: 0; }
    .page-header-left p { color: var(--gray-500); margin: 0.1rem 0 0 0; font-size: 0.85rem; }
    .header-actions { display: flex; gap: 0.75rem; align-items: center; }

    .btn-primary {
        background: var(--primary-gradient); color: white; border: none;
        padding: 0.55rem 1.2rem; border-radius: var(--radius); font-weight: 600;
        font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;
        transition: var(--transition); text-decoration: none;
        box-shadow: 0 2px 12px rgba(5, 149, 104, 0.25);
    }
    .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 20px rgba(5, 149, 104, 0.35); color: white; }

    .btn-outline {
        background: transparent; color: var(--gray-600); border: 1.5px solid var(--gray-200);
        padding: 0.55rem 1rem; border-radius: var(--radius); font-weight: 600; font-size: 0.85rem;
        display: inline-flex; align-items: center; gap: 0.4rem; transition: var(--transition);
        text-decoration: none; cursor: pointer;
    }
    .btn-outline:hover { border-color: var(--primary-light); color: var(--primary-light); background: var(--primary-bg); }

    .search-section {
        background: white; border-radius: var(--radius-lg); padding: 1rem 1.5rem;
        margin-bottom: 1.5rem; border: 1px solid var(--gray-200); box-shadow: var(--shadow-sm);
        display: flex; flex-wrap: wrap; align-items: center; gap: 1rem;
    }
    .search-box { flex: 1; min-width: 200px; position: relative; }
    .search-box input {
        width: 100%; padding: 0.55rem 1rem 0.55rem 2.6rem; border: 1.5px solid var(--gray-200);
        border-radius: var(--radius); font-size: 0.9rem; transition: var(--transition); background: var(--gray-50);
    }
    .search-box input:focus {
        border-color: var(--primary-light); outline: none;
        box-shadow: 0 0 0 4px rgba(5, 149, 104, 0.08); background: white;
    }
    .search-box .icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--gray-400); font-size: 1.1rem; }
    .search-box .clear-btn {
        position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
        background: none; border: none; color: var(--gray-400); cursor: pointer;
        display: none; font-size: 1.1rem; padding: 4px;
    }
    .search-box .clear-btn.visible { display: block; }
    .search-box .clear-btn:hover { color: var(--gray-600); }
    .results-count { font-size: 0.8rem; color: var(--gray-500); font-weight: 500; white-space: nowrap; }
    .results-count strong { color: var(--gray-700); }

    .filter-section { margin-bottom: 1.5rem; }
    .filter-tabs { display: flex; flex-wrap: wrap; gap: 0.4rem; }
    .filter-tab {
        padding: 0.4rem 1.2rem; border-radius: 50px; font-size: 0.8rem; font-weight: 600;
        border: 1.5px solid var(--gray-200); background: white; color: var(--gray-600);
        cursor: pointer; transition: var(--transition); text-decoration: none;
        display: inline-flex; align-items: center; gap: 0.4rem;
    }
    .filter-tab:hover { border-color: var(--primary-light); color: var(--primary-light); transform: translateY(-2px); box-shadow: var(--shadow-md); }
    .filter-tab.active { background: var(--primary-gradient); border-color: transparent; color: white; box-shadow: 0 2px 12px rgba(5, 149, 104, 0.25); }
    .filter-tab .count { background: rgba(255, 255, 255, 0.2); border-radius: 50px; padding: 0.05rem 0.5rem; font-size: 0.65rem; font-weight: 700; }
    .filter-tab.active .count { background: rgba(255, 255, 255, 0.2); }
    .filter-tab:not(.active) .count { background: var(--gray-100); color: var(--gray-500); }
    .filter-tab i { font-size: 1rem; }

    .users-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem; }

    .user-card {
        background: white; border-radius: var(--radius-lg); border: 1px solid var(--gray-200);
        overflow: hidden; transition: var(--transition); box-shadow: var(--shadow-sm);
        position: relative; display: flex; flex-direction: column;
    }
    .user-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--primary-light); }

    .user-card-header {
        padding: 1.2rem 1.25rem 0.8rem 1.25rem; display: flex; align-items: center;
        gap: 0.9rem; border-bottom: 1px solid var(--gray-100);
    }
    .user-avatar {
        width: 52px; height: 52px; border-radius: 50%; background: var(--primary-gradient);
        display: flex; align-items: center; justify-content: center; font-weight: 700;
        font-size: 1.1rem; color: white; flex-shrink: 0; position: relative;
        box-shadow: 0 2px 8px rgba(5, 149, 104, 0.2);
    }
    .user-avatar img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
    .user-avatar .status-dot { position: absolute; bottom: 0; right: 0; width: 12px; height: 12px; border-radius: 50%; border: 2px solid white; }
    .status-dot.active { background: #22c55e; }
    .status-dot.suspended { background: #f59e0b; }
    .status-dot.inactive { background: #ef4444; }
    .status-dot.banned { background: #6b7280; }

    .user-name-wrap { flex: 1; min-width: 0; overflow: hidden; }
    .user-name { font-weight: 700; color: var(--gray-900); font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-username { font-size: 0.75rem; color: var(--gray-400); display: flex; align-items: center; gap: 0.2rem; }
    .user-username i { font-size: 0.8rem; }
    .user-role-badge {
        padding: 0.2rem 0.7rem; border-radius: 50px; font-size: 0.65rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.04em; flex-shrink: 0; white-space: nowrap;
    }

    .user-card-body { padding: 0.8rem 1.25rem 1rem 1.25rem; display: grid; grid-template-columns: 1fr 1fr; gap: 0.4rem 0.8rem; flex: 1; }
    .user-detail { display: flex; flex-direction: column; gap: 0.05rem; }
    .user-detail .label { font-size: 0.6rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: var(--gray-400); }
    .user-detail .value { font-size: 0.82rem; color: var(--gray-700); font-weight: 500; display: flex; align-items: center; gap: 0.3rem; word-break: break-word; }
    .user-detail .value i { color: var(--primary-light); font-size: 0.85rem; flex-shrink: 0; }
    .user-full-name { font-weight: 600; color: var(--gray-800); font-size: 0.85rem; }

    .password-chip {
        display: inline-flex; align-items: center; gap: 0.3rem; padding: 0.1rem 0.4rem 0.1rem 0.6rem;
        background: #fffbeb; border: 1px solid #fcd34d; border-radius: 4px; font-family: monospace;
        font-size: 0.75rem; color: #92400e;
    }
    .password-chip .copy-btn { background: none; border: none; color: #92400e; cursor: pointer; padding: 2px; font-size: 0.75rem; transition: var(--transition); }
    .password-chip .copy-btn:hover { transform: scale(1.1); }
    .password-status { font-size: 0.6rem; font-weight: 600; color: #92400e; }
    .password-updated-text { font-size: 0.7rem; color: #22c55e; font-weight: 600; display: flex; align-items: center; gap: 0.2rem; }

    .user-card-footer {
        padding: 0.6rem 1.25rem 1rem 1.25rem; border-top: 1px solid var(--gray-100);
        display: flex; gap: 0.5rem; flex-wrap: wrap; align-items: center;
    }
    .btn-action {
        flex: 1; min-width: 50px; padding: 0.35rem 0.6rem; border-radius: 8px;
        border: 1px solid var(--gray-200); background: white; font-size: 0.72rem; font-weight: 600;
        color: var(--gray-600); display: inline-flex; align-items: center; justify-content: center;
        gap: 0.3rem; transition: var(--transition); text-decoration: none; cursor: pointer;
    }
    .btn-action:hover { border-color: var(--primary-light); color: var(--primary-light); background: var(--primary-bg); transform: translateY(-1px); }
    .btn-action.primary { background: var(--primary-gradient); border-color: transparent; color: white; }
    .btn-action.primary:hover { box-shadow: 0 2px 12px rgba(5, 149, 104, 0.3); color: white; }
    .btn-action.warning { border-color: #fcd34d; color: #92400e; background: #fffbeb; }
    .btn-action.warning:hover { background: #fef3c7; border-color: #f59e0b; }
    .btn-action.danger { border-color: #fca5a5; color: #dc2626; background: #fef2f2; }
    .btn-action.danger:hover { background: #fee2e2; border-color: #ef4444; }
    .btn-action.success { border-color: #86efac; color: #16a34a; background: #f0fdf4; }
    .btn-action.success:hover { background: #dcfce7; border-color: #22c55e; }
    .btn-action i { font-size: 0.9rem; }
    .btn-action span { font-size: 0.7rem; }

    .card-dropdown { position: relative; flex-shrink: 0; }
    .card-dropdown .dropdown-toggle { background: none; border: none; padding: 0.2rem 0.4rem; color: var(--gray-400); border-radius: 6px; transition: var(--transition); cursor: pointer; }
    .card-dropdown .dropdown-toggle:hover { background: var(--gray-100); color: var(--gray-700); }
    .card-dropdown .dropdown-toggle i { font-size: 1.2rem; }
    .card-dropdown .dropdown-toggle::after { display: none; }
    .card-dropdown .dropdown-menu { border: none; border-radius: var(--radius); box-shadow: var(--shadow-xl); padding: 0.3rem 0; min-width: 170px; border: 1px solid var(--gray-100); z-index: 1050; }
    .card-dropdown .dropdown-item { padding: 0.4rem 1rem; font-size: 0.8rem; display: flex; align-items: center; gap: 0.5rem; color: var(--gray-700); transition: var(--transition); cursor: pointer; }
    .card-dropdown .dropdown-item:hover { background: var(--gray-50); }
    .card-dropdown .dropdown-item i { font-size: 0.95rem; width: 16px; text-align: center; color: var(--gray-400); }
    .card-dropdown .dropdown-item.text-danger { color: #dc2626; }
    .card-dropdown .dropdown-item.text-danger i { color: #dc2626; }
    .card-dropdown .dropdown-item.text-danger:hover { background: #fef2f2; }
    .card-dropdown .dropdown-item.text-warning { color: #d97706; }
    .card-dropdown .dropdown-item.text-warning i { color: #d97706; }
    .card-dropdown .dropdown-item.text-warning:hover { background: #fffbeb; }
    .card-dropdown .dropdown-item.text-success { color: #16a34a; }
    .card-dropdown .dropdown-item.text-success i { color: #16a34a; }
    .card-dropdown .dropdown-item.text-success:hover { background: #f0fdf4; }
    .card-dropdown .dropdown-divider { margin: 0.2rem 0; border-color: var(--gray-100); }

    @media (max-width: 1200px) { .users-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .users-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; align-items: stretch; gap: 0.75rem; }
        .header-actions { width: 100%; }
        .header-actions .btn-primary, .header-actions .btn-outline { flex: 1; justify-content: center; }
        .search-section { flex-direction: column; align-items: stretch; padding: 1rem; }
        .search-box { min-width: unset; }
        .results-count { text-align: center; }
        .filter-tabs { gap: 0.3rem; }
        .filter-tab { font-size: 0.7rem; padding: 0.3rem 0.8rem; }
        .pagination-wrap { flex-direction: column; text-align: center; }
        .user-card-footer { flex-wrap: wrap; }
        .btn-action { flex: 1; min-width: 45px; font-size: 0.65rem; padding: 0.3rem 0.4rem; }
        .btn-action span { display: none; }
        .btn-action i { font-size: 1rem; }
    }
    @media (max-width: 480px) {
        .user-card-body { grid-template-columns: 1fr; }
        .user-card-header { flex-wrap: wrap; }
        .user-role-badge { margin-left: auto; }
        .user-name { font-size: 0.85rem; }
    }

    .empty-state { text-align: center; padding: 4rem 2rem; grid-column: 1 / -1; }
    .empty-state .icon { font-size: 3.5rem; color: var(--gray-300); margin-bottom: 1rem; }
    .empty-state h5 { color: var(--gray-700); font-weight: 600; margin: 0 0 0.25rem 0; }
    .empty-state p { color: var(--gray-400); margin: 0; font-size: 0.9rem; }

    .pagination-wrap { margin-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding: 1rem 0; }
    .pagination-info { font-size: 0.8rem; color: var(--gray-500); }
</style>

<div class="page-container">

    <!-- HEADER -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>👥 Manage Users</h1>
            <p>Manage user accounts, roles, and permissions across the system</p>
        </div>
        <div class="header-actions">
            @if (\App\Services\AccessControl::can('users.create'))
                <a href="{{ url('add-users') }}" class="btn-primary">
                    <i class="bx bx-user-plus"></i> Add User
                </a>
            @endif
            <button class="btn-outline" onclick="location.reload()">
                <i class="bx bx-refresh"></i>
            </button>
        </div>
    </div>

    <!-- SEARCH -->
    <div class="search-section">
        <div class="search-box">
            <i class="bx bx-search icon"></i>
            <input type="text" id="userSearch" placeholder="Search by name, username, email, phone, or role…">
            <button class="clear-btn" id="clearSearch"><i class="bx bx-x"></i></button>
        </div>
        <div class="results-count">
            Showing <strong id="visibleCount">{{ $users->count() }}</strong> of <strong id="totalCount">{{ $users->total() }}</strong> users
        </div>
    </div>

    <!-- FILTER TABS -->
    @if (isset($visibleRoles) && $visibleRoles->count() > 0)
        <div class="filter-section">
            <div class="filter-tabs">
                <a href="{{ url('manage-users') }}"
                    class="filter-tab {{ !isset($activeRole) || !$activeRole ? 'active' : '' }}">
                    <i class="bx bx-grid-alt"></i> All
                    <span class="count">{{ $users->total() }}</span>
                </a>

                @foreach ($visibleRoles as $role)
                    @php
                        $isActive = isset($activeRole) && $activeRole && $activeRole->id === $role->id;
                        $roleColor = $role->color ?? '#059568';
                    @endphp
                    <a href="{{ url('manage-users') }}?role={{ $role->slug }}"
                        class="filter-tab {{ $isActive ? 'active' : '' }}"
                        style="{{ $isActive ? 'background:' . $roleColor . ';border-color:' . $roleColor . ';' : '' }}">
                        <i class="bx {{ $role->icon ?? 'bx-shield' }}"></i>
                        {{ $role->name }}
                        <span class="count">{{ $userCounts[$role->id] ?? 0 }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- USERS CARDS GRID -->
    @php
        $__viewerRole = \App\Services\AccessControl::role();
        $canSeeCredentials = \App\Services\AccessControl::hasFullAccess()
            || ($__viewerRole && in_array($__viewerRole->data_scope, ['district', 'region'], true));
    @endphp

    <div class="users-grid" id="usersGrid">
        @forelse ($users as $user)
            @php
                $statusConfig = [
                    10 => ['label' => 'Active', 'color' => '#22c55e', 'bg' => 'rgba(34,197,94,0.12)', 'dot' => 'active', 'icon' => 'bx-check-circle'],
                    0 => ['label' => 'Inactive', 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.12)', 'dot' => 'inactive', 'icon' => 'bx-block'],
                    9 => ['label' => 'Suspended', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.12)', 'dot' => 'suspended', 'icon' => 'bx-pause-circle'],
                    8 => ['label' => 'Banned', 'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.12)', 'dot' => 'banned', 'icon' => 'bx-lock-alt'],
                ];
                $status = $statusConfig[$user->account_status] ?? ['label' => 'Unknown', 'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.12)', 'dot' => 'inactive', 'icon' => 'bx-time'];
                $roleColor = $user->role?->color ?? '#059568';
                $initials = strtoupper(($user->firstname[0] ?? '') . ($user->lastname[0] ?? '') ?: '?');
                $jurisdiction = collect([$user->mosque_name, $user->county, $user->district, $user->region])->filter()->implode(' • ');
                $fullName = trim($user->firstname . ' ' . $user->lastname);

                // Same permission gating as the working list-view partial
                // (layouts.views.users-action) — ports over identically so
                // Suspend/Ban/Delete behave exactly the same way here.
                $canManage = \App\Services\AccessControl::canManageUser($user);
                $canEditThis = $canManage && \App\Services\AccessControl::can('users.edit');
                $canDeleteThis = $canManage && \App\Services\AccessControl::can('users.delete');
                $canSuspendThis = $canManage && \App\Services\AccessControl::can('users.suspend');
                $canBanThis = $canManage && \App\Services\AccessControl::can('users.ban');
                $isSelf = \App\Services\AccessControl::user()?->id === $user->id;
            @endphp

            <div class="user-card" data-search="
                {{ strtolower($user->username ?? '') }}
                {{ strtolower($user->firstname ?? '') }}
                {{ strtolower($user->lastname ?? '') }}
                {{ strtolower($user->email ?? '') }}
                {{ strtolower($user->phonenumber ?? '') }}
                {{ strtolower($user->role_name ?? '') }}
                {{ strtolower($user->district ?? '') }}
                {{ strtolower($user->county ?? '') }}
                {{ strtolower($user->region ?? '') }}
            ">
                <!-- Card Header -->
                <div class="user-card-header">
                    <div class="user-avatar">
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $fullName }}">
                        @else
                            {{ $initials }}
                        @endif
                        <span class="status-dot {{ $status['dot'] }}"></span>
                    </div>
                    <div class="user-name-wrap">
                        <div class="user-name" title="{{ $fullName }}">{{ $fullName }}</div>
                        <div class="user-username">
                            <i class="bx bx-at"></i> {{ $user->username }}
                        </div>
                    </div>
                    <span class="user-role-badge" style="background:{{ $roleColor }}12;color:{{ $roleColor }};">
                        <i class="bx {{ $user->role?->icon ?? 'bx-shield' }}"></i>
                        {{ $user->role_name ?? 'No Role' }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="user-card-body">
                    <div class="user-detail" style="grid-column: 1 / -1;">
                        <span class="label">Full Name</span>
                        <span class="value user-full-name">{{ $fullName }}</span>
                    </div>

                    <div class="user-detail">
                        <span class="label">Contact</span>
                        <span class="value">
                            <i class="bx bx-phone"></i>
                            {{ $user->phonenumber ?? '—' }}
                        </span>
                        @if ($user->email)
                            <span class="value" style="font-size:0.75rem;color:var(--gray-500);">
                                <i class="bx bx-envelope"></i>
                                {{ $user->email }}
                            </span>
                        @endif
                    </div>

                    <div class="user-detail">
                        <span class="label">Status</span>
                        <span class="value">
                            <span style="display:inline-flex;align-items:center;gap:0.3rem;padding:0.15rem 0.6rem;border-radius:50px;background:{{ $status['bg'] }};color:{{ $status['color'] }};font-size:0.7rem;font-weight:600;">
                                <i class="bx {{ $status['icon'] }}"></i>
                                {{ $status['label'] }}
                            </span>
                        </span>
                    </div>

                    @if ($jurisdiction)
                        <div class="user-detail" style="grid-column: 1 / -1;">
                            <span class="label">Jurisdiction</span>
                            <span class="value">
                                <i class="bx bx-map-pin"></i>
                                {{ $jurisdiction }}
                            </span>
                        </div>
                    @endif

                    @if ($canSeeCredentials)
                        <div class="user-detail" style="grid-column: 1 / -1;">
                            <span class="label">Credentials</span>
                            <span class="value">
                                @if ($user->credentials_status === 'pending' && $user->generated_password)
                                    <span class="password-chip">
                                        <span>{{ $user->generated_password }}</span>
                                        <button class="copy-btn" data-password="{{ $user->generated_password }}" title="Copy">
                                            <i class="bx bx-copy"></i>
                                        </button>
                                    </span>
                                    <span class="password-status">Not yet changed</span>
                                @elseif ($user->credentials_status === 'updated')
                                    <span class="password-updated-text">
                                        <i class="bx bx-check-circle"></i> Password updated
                                    </span>
                                @else
                                    <span style="font-size:0.75rem;color:var(--gray-400);">—</span>
                                @endif
                            </span>
                        </div>
                    @endif
                </div>

                <!-- ================================================================
                CARD FOOTER — Actions
                Uses the SAME classes (view-user / edit-user / status-action /
                delete-user) and data-status values (10/9/0) that the proven
                JS in layouts.views.users-action-modals already listens for
                via event delegation, so no new JS is needed here at all.
                ================================================================ -->
                <div class="user-card-footer">
                    <button class="btn-action primary view-user" data-id="{{ $user->id }}">
                        <i class="bx bx-show-alt"></i> <span>View</span>
                    </button>

                    @if ($canEditThis)
                        <button class="btn-action edit-user" data-id="{{ $user->id }}">
                            <i class="bx bx-edit-alt"></i> <span>Edit</span>
                        </button>
                    @endif

                    @if ($canSuspendThis && !$isSelf)
                        @if ($user->account_status == 10)
                            <button class="btn-action warning status-action" data-id="{{ $user->id }}" data-status="9">
                                <i class="bx bx-pause-circle"></i> <span>Suspend</span>
                            </button>
                        @elseif ($user->account_status == 9 || $user->account_status == 0)
                            <button class="btn-action success status-action" data-id="{{ $user->id }}" data-status="10">
                                <i class="bx bx-play-circle"></i> <span>Activate</span>
                            </button>
                        @endif
                    @endif

                    <div class="card-dropdown">
                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <button class="dropdown-item view-user" data-id="{{ $user->id }}">
                                    <i class="bx bx-show-alt"></i> View Profile
                                </button>
                            </li>
                            @if ($canEditThis)
                                <li>
                                    <button class="dropdown-item edit-user" data-id="{{ $user->id }}">
                                        <i class="bx bx-edit-alt"></i> Edit User
                                    </button>
                                </li>
                            @endif

                            @if (($canSuspendThis || $canBanThis) && !$isSelf)
                                <li><hr class="dropdown-divider"></li>

                                @if ($user->account_status != 10 && $canSuspendThis)
                                    <li>
                                        <button class="dropdown-item text-success status-action" data-id="{{ $user->id }}" data-status="10">
                                            <i class="bx bx-play-circle"></i> Activate
                                        </button>
                                    </li>
                                @endif
                                @if ($user->account_status != 9 && $canSuspendThis)
                                    <li>
                                        <button class="dropdown-item text-warning status-action" data-id="{{ $user->id }}" data-status="9">
                                            <i class="bx bx-pause-circle"></i> Suspend
                                        </button>
                                    </li>
                                @endif
                                @if ($user->account_status != 0 && $canBanThis)
                                    <li>
                                        <button class="dropdown-item text-danger status-action" data-id="{{ $user->id }}" data-status="0">
                                            <i class="bx bx-block"></i> Ban
                                        </button>
                                    </li>
                                @endif
                            @endif

                            @if ($canDeleteThis && !$isSelf)
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item delete-user text-danger" data-id="{{ $user->id }}">
                                        <i class="bx bx-trash-alt"></i> Delete
                                    </button>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="icon"><i class="bx bx-user-x"></i></div>
                <h5>No users found</h5>
                <p>Try adjusting your search or filter criteria</p>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    @if ($users->hasPages())
        <div class="pagination-wrap">
            <div class="pagination-info">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
            </div>
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif

    {{--
        This ONE include provides both the View and Edit modals AND all their
        JS (view/edit/suspend/activate/ban/delete via event delegation on
        .view-user / .edit-user / .status-action / .delete-user), using the
        real API fields and the endpoints already proven to work on the
        classic list view. Must be included exactly once, after the grid —
        never inside the @forelse loop, or duplicate IDs break everything.
    --}}
    @include('layouts.views.users-action-modals')

</div>

<!-- SweetAlert (used by the included modals' JS) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    // ================================================================
    // SEARCH (unchanged from the card design — unrelated to the fix)
    // ================================================================
    const searchInput = document.getElementById('userSearch');
    const clearBtn = document.getElementById('clearSearch');
    const cards = document.querySelectorAll('.user-card');
    const visibleCount = document.getElementById('visibleCount');

    function filterUsers() {
        const query = searchInput.value.toLowerCase().trim();
        let visible = 0;

        cards.forEach(card => {
            const data = card.getAttribute('data-search') || '';
            if (data.includes(query)) {
                card.style.display = '';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        clearBtn.classList.toggle('visible', query.length > 0);
        if (visibleCount) visibleCount.textContent = visible;
    }

    searchInput.addEventListener('input', filterUsers);
    clearBtn.addEventListener('click', function() {
        searchInput.value = '';
        filterUsers();
        searchInput.focus();
    });

    // ================================================================
    // COPY PASSWORD (unchanged — unrelated to the fix)
    // ================================================================
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const password = this.dataset.password;
            if (!password) return;

            if (navigator.clipboard?.writeText) {
                navigator.clipboard.writeText(password).then(() => showCopyFeedback(this));
            } else {
                fallbackCopy(password, this);
            }
        });
    });

    function fallbackCopy(text, el) {
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.style.cssText = 'position:fixed;opacity:0;';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); showCopyFeedback(el); } catch(e) {}
        document.body.removeChild(ta);
    }

    function showCopyFeedback(el) {
        const icon = el.querySelector('i');
        const orig = icon.className;
        icon.className = 'bx bx-check';
        icon.style.color = '#22c55e';
        setTimeout(() => { icon.className = orig; icon.style.color = ''; }, 1200);
    }

    // ================================================================
    // Close Bootstrap dropdown after picking an item (card's own 3-dot
    // menu — separate from, and does not conflict with, the modals'
    // click-delegation handlers included above).
    // ================================================================
    document.querySelectorAll('.card-dropdown .dropdown-item').forEach(item => {
        item.addEventListener('click', function() {
            const dropdown = this.closest('.dropdown, .card-dropdown');
            const toggle = dropdown?.querySelector('.dropdown-toggle');
            if (toggle) {
                const bsDropdown = bootstrap.Dropdown.getInstance(toggle);
                if (bsDropdown) bsDropdown.hide();
            }
        });
    });

});
</script>
@endsection