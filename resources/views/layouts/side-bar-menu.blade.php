<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo d-flex flex-column align-items-center justify-content-center" style="padding: 16px 20px;">
        <div class="d-flex align-items-center justify-content-center w-100" style="height: 110px; position: relative;">
            <a href="{{ url('/') }}" class="app-brand-link">
                <img src="{{ asset('assets/img/branding/logo-png.png') }}" alt="Logo"
                    style="width: 100px; height: auto; object-fit: contain;">
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto"
                style="position: absolute; right: 10px; top: 10px;">
                <i class="bx menu-toggle-icon fs-4 d-none d-xl-block align-middle"></i>
                <i class="bx bx-x bx-sm d-xl-none d-block align-middle"></i>
            </a>
        </div>

        <!-- Language Switcher — sitewide, drives every data-i18n element on
             whatever page is currently loaded (menu included), via
             layouts/i18n-engine.blade.php -->
        <div class="app-lang-switcher d-flex gap-1 mt-2">
            <button type="button" class="app-lang-btn active" data-lang="en">EN</button>
            <button type="button" class="app-lang-btn" data-lang="ar">AR</button>
            <button type="button" class="app-lang-btn" data-lang="sw">SW</button>
        </div>
    </div>

    <div class="menu-divider mt-0"></div>

    <ul class="menu-inner py-1 mt-3">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home"></i>
                <div data-i18n="dashboard">Dashboard</div>
            </a>
        </li>

        <!-- Nikah -->
        @can_permission('nikah.view')
        <li
            class="menu-item {{ request()->routeIs('nikah.*') || request()->routeIs('landing.nikah') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-heart-circle"></i>
                <div data-i18n="nikah">Nikah</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('nikah.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('nikah.dashboard') }}" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                @can_permission('nikah.create')
                <li class="menu-item {{ request()->routeIs('landing.nikah') ? 'active' : '' }}">
                    <a href="{{ route('landing.nikah') }}" class="menu-link">
                        <div data-i18n="application">Application</div>
                    </a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        <!-- Divorce -->
        @can_permission('divorce.view')
        <li class="menu-item {{ request()->routeIs('divorce.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-unlink"></i>
                <div data-i18n="divorce">Divorce</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('divorce.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('divorce.dashboard') }}" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                @can_permission('divorce.create')
                <li class="menu-item {{ request()->routeIs('divorce.application') ? 'active' : '' }}">
                    <a href="{{ route('divorce.application') }}" class="menu-link">
                        <div data-i18n="application">Application</div>
                    </a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        <!-- Inheritance -->
        @can_permission('inheritance.view')
        <li class="menu-item {{ request()->routeIs('inheritance.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div data-i18n="inheritance">Inheritance</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('inheritance.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('inheritance.dashboard') }}" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                @can_permission('inheritance.create')
                <li class="menu-item {{ request()->routeIs('inheritance.application') ? 'active' : '' }}">
                    <a href="{{ route('inheritance.application') }}" class="menu-link">
                        <div data-i18n="application">Application</div>
                    </a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        <!-- Guardianship -->
        @can_permission('guardianship.view')
        <li class="menu-item {{ request()->routeIs('guardianship.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                <div data-i18n="guardianship">Guardianship</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('guardianship.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('guardianship.dashboard') }}" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                @can_permission('guardianship.create')
                <li class="menu-item {{ request()->routeIs('guardianship.application') ? 'active' : '' }}">
                    <a href="{{ route('guardianship.application') }}" class="menu-link">
                        <div data-i18n="application">Application</div>
                    </a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        <!-- Converts -->
        @can_permission('convert.view')
        <li class="menu-item {{ request()->routeIs('convert.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-plus"></i>
                <div data-i18n="converts">Converts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('convert.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('convert.dashboard') }}" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                @can_permission('convert.create')
                <li class="menu-item {{ request()->routeIs('convert.application') ? 'active' : '' }}">
                    <a href="{{ route('convert.application') }}" class="menu-link">
                        <div data-i18n="application">Application</div>
                    </a>
                </li>
                @endcan_permission
            </ul>
        </li>
        @endcan_permission

        <!-- ============================================================ -->
        <!-- CONSULTANCY — NEW MODULE                                       -->
        <!-- ============================================================ -->
        @can_permission('consultancy.view')
        <li class="menu-item {{ request()->routeIs('consultancy.*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-message-square-detail"></i>
                <div data-i18n="consultancy">Consultancy</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('consultancy.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('consultancy.dashboard') }}" class="menu-link">
                        <div data-i18n="dashboard">Dashboard</div>
                    </a>
                </li>
                @can_permission('consultancy.create')
                <li class="menu-item {{ request()->routeIs('consultancy.create') ? 'active' : '' }}">
                    <a href="{{ route('consultancy.create') }}" class="menu-link">
                        <div data-i18n="new_consultation">New Consultation</div>
                    </a>
                </li>
                @endcan_permission
                <li class="menu-item {{ request()->routeIs('consultancy.index') ? 'active' : '' }}">
                    <a href="{{ route('consultancy.index') }}" class="menu-link">
                        <div data-i18n="all_consultations">All Consultations</div>
                    </a>
                </li>
            </ul>
        </li>
        @endcan_permission
        <!-- ============================================================ -->

        <!-- Users -->
        @can_permission('users.view')
            <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="users">Users</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ request()->routeIs('users.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('users.dashboard') }}" class="menu-link">
                            <div data-i18n="dashboard">Dashboard</div>
                        </a>
                    </li>
                    @can_permission('users.create')
                        <li class="menu-item {{ request()->routeIs('add.users') ? 'active' : '' }}">
                            <a href="{{ url('add-users') }}" class="menu-link">
                                <div data-i18n="add_users">Add Users</div>
                            </a>
                        </li>
                    @endcan_permission
                    <li class="menu-item {{ request()->routeIs('manage.users') ? 'active' : '' }}">
                        <a href="{{ url('manage-users') }}" class="menu-link">
                            <div data-i18n="manage_users">Manage Users</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan_permission

        <!-- Chat -->
        @can_permission('chat.view')
        <li class="menu-item {{ request()->routeIs('chat.*') ? 'active' : '' }}">
            <a href="{{ route('chat.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chat"></i>
                <div data-i18n="chat">Chat</div>
                <span id="sidebar-chat-badge" class="badge bg-danger rounded-pill ms-auto d-none"></span>
            </a>
        </li>
        @endcan_permission

        <!-- Roles & Privileges -->
        @can_permission('roles.view')
            <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <a href="{{ route('roles.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-customize"></i>
                    <div data-i18n="roles_privileges">Roles & Privileges</div>
                </a>
            </li>
        @endcan_permission

        <!-- Fatwa Management (Director only, in practice) -->
        @can_permission('fatwa.view')
        <li class="menu-item {{ request()->routeIs('fatwa.admin.*') ? 'active' : '' }}">
            <a href="{{ route('fatwa.admin.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-book-open"></i>
                <div data-i18n="fatwa">Fatwa</div>
            </a>
        </li>
        @endcan_permission

        <!-- Bulk Import -->
        @can_permission('bulk_import.view')
            <li class="menu-item {{ request()->routeIs('bulk-import.*') ? 'active' : '' }}">
                <a href="{{ route('bulk-import.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-cloud-upload"></i>
                    <div data-i18n="bulk_import">Bulk Import</div>
                </a>
            </li>
        @endcan_permission

        <!-- Certificates -->
        @can_permission('certificates.view')
            <li class="menu-item {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                <a href="{{ route('certificates.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-certification"></i>
                    <div data-i18n="certificates">Certificates</div>
                </a>
            </li>
        @endcan_permission

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

        .app-lang-switcher { justify-content: center; }
        .app-lang-btn {
            border: 1px solid rgba(255,255,255,0.25);
            background: transparent;
            color: rgba(255,255,255,0.75);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .03em;
            padding: 3px 9px;
            border-radius: 5px;
            cursor: pointer;
            transition: all .15s ease;
        }
        .app-lang-btn:hover { border-color: #ffffff; color: #ffffff; }
        .app-lang-btn.active { background: #008F4C; border-color: #008F4C; color: #ffffff; }

        /* If your theme's sidebar is on a light background instead of dark,
           these overrides keep the buttons readable either way. */
        .bg-menu-theme .app-lang-btn {
            border-color: rgba(0,0,0,0.15);
            color: rgba(0,0,0,0.6);
        }
        .bg-menu-theme .app-lang-btn:hover {
            border-color: #008F4C;
            color: #008F4C;
        }
    </style>

    <script>
        (function () {
            function refreshChatBadge() {
                fetch("{{ route('chat.unread') }}")
                    .then(r => r.json())
                    .then(d => {
                        const el = document.getElementById('sidebar-chat-badge');
                        if (!el) return;
                        if (d.status && d.count > 0) {
                            el.textContent = d.count > 99 ? '99+' : d.count;
                            el.classList.remove('d-none');
                        } else {
                            el.classList.add('d-none');
                        }
                    })
                    .catch(() => {});
            }
            if (document.getElementById('sidebar-chat-badge')) {
                refreshChatBadge();
                setInterval(refreshChatBadge, 15000);
            }
        })();
    </script>
</aside>