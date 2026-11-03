@php
    $__u = \App\Services\AccessControl::user();
    $__name = $__u ? ($__u->full_name ?: $__u->username) : (Helper::logged_username() ?: 'User');
    $__role = $__u?->role?->name ?: Helper::activerUSerRole();
    $__initial = mb_strtoupper(mb_substr($__name, 0, 1));
    $__canChat = \App\Services\AccessControl::can('chat.view');
@endphp

<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">

        {{-- Mobile: open the sidebar --}}
        <div class="layout-menu-toggle navbar-nav d-xl-none align-items-xl-center me-1 me-xl-0">
            <a class="nav-item nav-link px-0" href="javascript:void(0)" aria-label="Open menu">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        {{-- Global search trigger (opens the command palette) --}}
        <button type="button" class="s-search" data-open-search aria-label="Search records">
            <i class="bx bx-search"></i>
            <span data-shell-placeholder="search_hint">Search applications, names, IDs…</span>
            <kbd>Ctrl K</kbd>
        </button>
        <button type="button" class="s-iconbtn s-search-icon" data-open-search aria-label="Search records">
            <i class="bx bx-search"></i>
        </button>

        <div class="s-actions">

            {{-- Notifications (chat unread today; later patches feed this slot) --}}
            <div class="dropdown">
                <button type="button" class="s-iconbtn" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-label="Notifications" aria-expanded="false">
                    <i class="bx bx-bell"></i>
                    <span id="topbar-chat-badge" class="s-dot d-none"></span>
                </button>
                <div class="dropdown-menu dropdown-menu-end s-notes">
                    <div class="s-notes-head">
                        <span data-shell="notifications">Notifications</span>
                    </div>
                    <div class="s-notes-body" data-notifications-slot>
                        <div class="s-notes-empty" id="notes-empty">
                            <i class="bx bx-check-circle"></i>
                            <span data-shell="all_caught_up">You're all caught up.</span>
                        </div>
                        @if ($__canChat)
                            <a href="{{ route('chat.index') }}" class="dropdown-item d-none" id="notes-chat">
                                <i class="bx bx-chat"></i>
                                <span><strong id="notes-chat-count">0</strong> <span data-shell="unread_messages">unread chat messages</span></span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Language --}}
            <div class="dropdown">
                <button type="button" class="s-langbtn" data-bs-toggle="dropdown" aria-label="Language" aria-expanded="false">
                    <i class="bx bx-globe"></i>
                    <span class="s-lang-label" id="shell-lang-label">EN</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" id="shell-lang-menu">
                    <li><a class="dropdown-item" href="javascript:void(0);" data-lang="en">English</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" data-lang="sw">Kiswahili</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0);" data-lang="ar" lang="ar">العربية</a></li>
                </ul>
            </div>

            {{-- User --}}
            <div class="dropdown">
                <button type="button" class="s-user" data-bs-toggle="dropdown" aria-label="Account menu" aria-expanded="false">
                    <span class="s-avatar">{{ $__initial }}</span>
                    <span class="s-user-meta d-none d-sm-block">
                        <strong>{{ $__name }}</strong>
                        <span>{{ $__role }}</span>
                    </span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="s-menu-head">
                            <span class="s-avatar">{{ $__initial }}</span>
                            <div>
                                <strong>{{ $__name }}</strong>
                                <span>{{ $__role }}</span>
                            </div>
                        </div>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('user.profile') }}">
                            <i class="bx bx-user"></i><span>{{ __('ui.my_profile') }}</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ url('/') }}" target="_blank" rel="noopener">
                            <i class="bx bx-link-external"></i><span data-shell="public_site">Public website</span>
                        </a>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" id="logout-btn">
                            <i class="bx bx-power-off"></i><span>{{ __('ui.log_out') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

{{-- ====================== Command palette ====================== --}}
<div class="s-pal" id="shell-palette" role="dialog" aria-modal="true" aria-label="Search" hidden>
    <div class="s-pal-box">
        <div class="s-pal-input">
            <i class="bx bx-search"></i>
            <input type="text" id="shell-pal-input" autocomplete="off" spellcheck="false"
                data-shell-placeholder="search_hint" placeholder="Search applications, names, IDs…"
                aria-label="Search">
            <kbd>Esc</kbd>
        </div>
        <div class="s-pal-scopes" id="shell-pal-scopes">
            <button type="button" class="s-chip is-on" data-scope="" data-shell="scope_all">All</button>
            @can_permission('nikah.view')<button type="button" class="s-chip" data-scope="nikah" data-shell="nikah">Nikah</button>@endcan_permission
            @can_permission('divorce.view')<button type="button" class="s-chip" data-scope="divorce" data-shell="divorce">Divorce</button>@endcan_permission
            @can_permission('inheritance.view')<button type="button" class="s-chip" data-scope="inheritance" data-shell="inheritance">Inheritance</button>@endcan_permission
            @can_permission('guardianship.view')<button type="button" class="s-chip" data-scope="guardianship" data-shell="guardianship">Guardianship</button>@endcan_permission
            @can_permission('convert.view')<button type="button" class="s-chip" data-scope="convert" data-shell="converts">Converts</button>@endcan_permission
        </div>
        <ul class="s-pal-list" id="shell-pal-list" role="listbox"></ul>
        <div class="s-pal-foot">
            <span><kbd>&uarr;</kbd> <kbd>&darr;</kbd> <span data-shell="pal_navigate">navigate</span></span>
            <span><kbd>Enter</kbd> <span data-shell="pal_open">open</span></span>
            <span><kbd>Esc</kbd> <span data-shell="pal_close">close</span></span>
        </div>
    </div>
</div>

{{-- Runtime config for public/js/umsc-app.js (no inline logic, so the CSP can stay strict later) --}}
<div id="umsc-shell-config" hidden
    data-base="{{ url('/') }}"
    data-search-url="{{ url('/smart-search') }}"
    data-lang-url="{{ url('/lang') }}"
    data-logout-url="{{ route('user.logout') }}"
    data-chat-unread-url="{{ $__canChat ? route('chat.unread') : '' }}"
    data-server-locale="{{ app()->getLocale() }}"></div>
