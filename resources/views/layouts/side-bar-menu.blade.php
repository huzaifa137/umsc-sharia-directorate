<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex align-items-center justify-content-center" style="height: 150px; padding: 20px;">
        <a href="{{ url('/') }}" class="app-brand-link">
            <img src="{{ asset('assets/img/branding/logo-png.png') }}" alt="Logo"
                style="width: 110px; height: auto; object-fit: contain;">
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto"
            style="position: absolute; right: 10px; top: 10px;">
            <i class="bx menu-toggle-icon fs-4 d-none d-xl-block align-middle"></i>
            <i class="bx bx-x bx-sm d-xl-none d-block align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <ul class="menu-inner py-1 mt-3">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div>Dashboard</div>
            </a>
        </li>

        <!-- Nikah -->
        <li
            class="menu-item {{ request()->routeIs('nikah.*') || request()->routeIs('landing.nikah') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-heart-circle"></i>
                <div>Nikah</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('nikah.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('nikah.dashboard') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('landing.nikah') ? 'active' : '' }}">
                    <a href="{{ route('landing.nikah') }}" class="menu-link">
                        <div>Application</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Divorce -->
        <li class="menu-item {{ request()->routeIs('divorce.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-unlink"></i>
                <div>Divorce</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('divorce.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('divorce.dashboard') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('divorce.application') ? 'active' : '' }}">
                    <a href="{{ route('divorce.application') }}" class="menu-link">
                        <div>Application</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Inheritance -->
        <li class="menu-item {{ request()->routeIs('inheritance.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div>Inheritance</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('inheritance.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('inheritance.dashboard') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('inheritance.application') ? 'active' : '' }}">
                    <a href="{{ route('inheritance.application') }}" class="menu-link">
                        <div>Application</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Guardianship -->
        <li class="menu-item {{ request()->routeIs('guardianship.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div>Guardianship</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('guardianship.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('guardianship.dashboard') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('guardianship.application') ? 'active' : '' }}">
                    <a href="{{ route('guardianship.application') }}" class="menu-link">
                        <div>Application</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Converts -->
        <li class="menu-item {{ request()->routeIs('convert.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div>Converts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('convert.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('convert.dashboard') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('convert.application') ? 'active' : '' }}">
                    <a href="{{ route('convert.application') }}" class="menu-link">
                        <div>Application</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Users -->
        <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div>Users</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('users.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('users.dashboard') }}" class="menu-link">
                        <div>Dashboard</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('add.users') ? 'active' : '' }}">
                    <a href="{{ url('add-users') }}" class="menu-link">
                        <div>Add Users</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('manage.users') ? 'active' : '' }}">
                    <a href="{{ url('manage-users') }}" class="menu-link">
                        <div>Manage Users</div>
                    </a>
                </li></style>
            </ul>
        </li>
    </ul>

    <style>
        .menu-item.active>.menu-link {
            background-color: rgba(0, 143, 76, 0.12);
            color: #008F4C;
            font-weight: 600;
        }

        .menu-sub .menu-item.active>.menu-link {
            background-color: rgba(0, 143, 76, 0.18);
            color: #008F4C;
            font-weight: 600;
        }

        .menu-item.active>.menu-link .menu-icon {
            color: #008F4C;
        }
    </style>

</aside>
