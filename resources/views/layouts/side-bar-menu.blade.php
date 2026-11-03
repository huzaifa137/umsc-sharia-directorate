@php
    // Group visibility: a heading only renders when the officer can see at least one item under it.
    $showServices = \App\Services\AccessControl::canAny([
        'nikah.view', 'divorce.view', 'inheritance.view', 'guardianship.view', 'convert.view', 'consultancy.view',
    ]);
    $showReports = \App\Services\AccessControl::canAny([
        'nikah.view', 'divorce.view', 'inheritance.view', 'guardianship.view', 'convert.view',
    ]);
    $showRecords = $showReports || \App\Services\AccessControl::canAny(['certificates.view', 'fatwa.view', 'bulk_import.view']);
    $showAdmin = \App\Services\AccessControl::canAny(['users.view', 'roles.view', 'activity_logs.view']);
    $showComms = \App\Services\AccessControl::can('chat.view');
@endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme" aria-label="Main navigation">

    <div class="app-brand demo">
        <div class="s-brand">
            <a href="{{ route('user.dashboard') }}" class="s-brand-badge" aria-label="Directorate of Sharia, dashboard">
                <img src="{{ asset('asset/images/logo.png') }}" alt="">
            </a>
            <div class="s-brand-text">
                <strong data-shell="brand_name">Directorate of Sharia</strong>
                <span data-shell="brand_sub">Uganda Muslim Supreme Council</span>
            </div>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link s-brand-toggle" aria-label="Toggle menu">
                <i class="bx menu-toggle-icon fs-4 d-none d-xl-block align-middle"></i>
                <i class="bx bx-x bx-sm d-xl-none d-block align-middle"></i>
            </a>
        </div>
        <hr class="s-brand-rule">
    </div>

    <ul class="menu-inner py-1">

        {{-- ============ OVERVIEW ============ --}}
        <li class="menu-header small text-uppercase"><span class="menu-header-text" data-shell="g_overview">Overview</span></li>
        <li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-shell="dashboard">Dashboard</div>
            </a>
        </li>

        {{-- ============ SERVICES ============ --}}
        @if ($showServices)
            <li class="menu-header small text-uppercase"><span class="menu-header-text" data-shell="g_services">Services</span></li>
        @endif

        @can_permission('nikah.view')
        <li class="menu-item {{ request()->routeIs('nikah.*') || request()->routeIs('landing.nikah') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-heart-circle"></i>
                <div data-shell="nikah">Nikah</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('nikah.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('nikah.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('nikah.create')
                <li class="menu-item {{ request()->routeIs('landing.nikah') ? 'active' : '' }}">
                    <a href="{{ route('landing.nikah') }}" class="menu-link"><div data-shell="application">Application</div></a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        @can_permission('divorce.view')
        <li class="menu-item {{ request()->routeIs('divorce.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-unlink"></i>
                <div data-shell="divorce">Divorce</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('divorce.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('divorce.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('divorce.create')
                <li class="menu-item {{ request()->routeIs('divorce.application') ? 'active' : '' }}">
                    <a href="{{ route('divorce.application') }}" class="menu-link"><div data-shell="application">Application</div></a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        @can_permission('inheritance.view')
        <li class="menu-item {{ request()->routeIs('inheritance.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div data-shell="inheritance">Inheritance</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('inheritance.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('inheritance.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('inheritance.create')
                <li class="menu-item {{ request()->routeIs('inheritance.application') ? 'active' : '' }}">
                    <a href="{{ route('inheritance.application') }}" class="menu-link"><div data-shell="application">Application</div></a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        @can_permission('guardianship.view')
        <li class="menu-item {{ request()->routeIs('guardianship.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div data-shell="guardianship">Guardianship</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('guardianship.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('guardianship.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('guardianship.create')
                <li class="menu-item {{ request()->routeIs('guardianship.application') ? 'active' : '' }}">
                    <a href="{{ route('guardianship.application') }}" class="menu-link"><div data-shell="application">Application</div></a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        @can_permission('convert.view')
        <li class="menu-item {{ request()->routeIs('convert.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-shell="converts">Converts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('convert.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('convert.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('convert.create')
                <li class="menu-item {{ request()->routeIs('convert.application') ? 'active' : '' }}">
                    <a href="{{ route('convert.application') }}" class="menu-link"><div data-shell="application">Application</div></a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        @can_permission('consultancy.view')
        <li class="menu-item {{ request()->routeIs('consultancy.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-message-square-detail"></i>
                <div data-shell="consultancy">Consultancy</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('consultancy.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('consultancy.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('consultancy.create')
                <li class="menu-item {{ request()->routeIs('consultancy.create') ? 'active' : '' }}">
                    <a href="{{ route('consultancy.create') }}" class="menu-link"><div data-shell="new_consultation">New Consultation</div></a>
                </li>
                @endcan_permission
                <li class="menu-item {{ request()->routeIs('consultancy.index') ? 'active' : '' }}">
                    <a href="{{ route('consultancy.index') }}" class="menu-link"><div data-shell="all_consultations">All Consultations</div></a>
                </li>
            </ul>
        </li>
        @endcan_permission

        {{-- ============ RECORDS & PUBLISHING ============ --}}
        @if ($showRecords)
            <li class="menu-header small text-uppercase"><span class="menu-header-text" data-shell="g_records">Records &amp; publishing</span></li>
        @endif

        @can_permission('certificates.view')
        <li class="menu-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
            <a href="{{ route('certificates.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-certification"></i>
                <div data-shell="certificates">Certificates</div>
            </a>
        </li>
        @endcan_permission

        @can_permission('fatwa.view')
        <li class="menu-item {{ request()->routeIs('fatwa.admin.*') ? 'active' : '' }}">
            <a href="{{ route('fatwa.admin.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div data-shell="fatwa">Fatwa</div>
            </a>
        </li>
        @endcan_permission

        @if ($showReports)
        <li class="menu-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <a href="{{ route('reports.hub') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-shell="reports">Reports</div>
            </a>
        </li>
        @endif

        @can_permission('bulk_import.view')
        <li class="menu-item {{ request()->routeIs('bulk-import.*') ? 'active' : '' }}">
            <a href="{{ route('bulk-import.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cloud-upload"></i>
                <div data-shell="bulk_import">Bulk Import</div>
            </a>
        </li>
        @endcan_permission

        {{-- ============ ADMINISTRATION ============ --}}
        @if ($showAdmin)
            <li class="menu-header small text-uppercase"><span class="menu-header-text" data-shell="g_admin">Administration</span></li>
        @endif

        @can_permission('users.view')
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-shell="users">Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('users.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('users.dashboard') }}" class="menu-link"><div data-shell="dashboard">Dashboard</div></a>
                </li>
                @can_permission('users.create')
                <li class="menu-item {{ request()->routeIs('add.users') ? 'active' : '' }}">
                    <a href="{{ url('add-users') }}" class="menu-link"><div data-shell="add_users">Add Users</div></a>
                </li>
                @endcan_permission
                <li class="menu-item {{ request()->routeIs('manage.users') ? 'active' : '' }}">
                    <a href="{{ url('manage-users') }}" class="menu-link"><div data-shell="manage_users">Manage Users</div></a>
                </li>
            </ul>
        </li>
        @endcan_permission

        @can_permission('roles.view')
        <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a href="{{ route('roles.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-customize"></i>
                <div data-shell="roles_privileges">Roles &amp; Privileges</div>
            </a>
        </li>
        @endcan_permission

        @can_permission('activity_logs.view')
        <li class="menu-item {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
            <a href="{{ route('activity-logs.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-history"></i>
                <div data-shell="activity_logs">Activity Log</div>
            </a>
        </li>
        @endcan_permission

        {{-- ============ COMMUNICATION ============ --}}
        @if ($showComms)
            <li class="menu-header small text-uppercase"><span class="menu-header-text" data-shell="g_comms">Communication</span></li>
        @endif

        @can_permission('chat.view')
        <li class="menu-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
            <a href="{{ route('chat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div data-shell="chat">Chat</div>
                <span id="sidebar-chat-badge" class="badge bg-danger rounded-pill ms-auto d-none"></span>
            </a>
        </li>
        @endcan_permission

        <li class="s-side-foot">
            <span class="s-motto">وَاعْتَصِمُوا بِحَبْلِ اللَّهِ جَمِيعًا</span>
            <span data-shell="side_foot">Authorised officers only. Activity is logged.</span>
        </li>

    </ul>
</aside>
