@extends('layouts.app')

@section('content')
    @php
        use App\Services\AccessControl as AC;

        $viewerRole = AC::role();
        $canSeeCredentials = AC::hasFullAccess() || ($viewerRole && in_array($viewerRole->data_scope, ['district', 'region'], true));
        $me = AC::user();
        $totalAll = collect($userCounts)->sum();
        $roleParam = $activeRole?->slug;
        $statusKey = fn ($s) => match ((int) $s) { 10 => 'active', 9 => 'suspended', 8 => 'locked', 0 => 'banned', default => 'pending' };
        $keep = fn (array $extra) => array_filter(array_merge(['role' => $roleParam, 'q' => $filters['q'], 'status' => $filters['status']], $extra), fn ($v) => $v !== null && $v !== '');
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Manage users" subtitle="Accounts in your scope, with their role, jurisdiction and status."
            :crumbs="['Users' => route('users.dashboard'), 'Manage users' => null]">
            @can_permission('users.create')
                <a href="{{ route('add.users') }}" class="ui-btn ui-btn--primary"><i class="bx bx-user-plus"></i> Add user</a>
            @endcan_permission
        </x-ui.page-header>

        <section class="card">
            <div class="px-3 pt-2">
                <ul class="adm-tabs mb-0" style="border-bottom:0">
                    <li><a class="adm-tab {{ $activeRole ? '' : 'is-active' }}" href="{{ route('manage.users', $keep(['role' => null])) }}">All <b>{{ number_format($totalAll) }}</b></a></li>
                    @foreach ($visibleRoles as $role)
                        <li><a class="adm-tab {{ $activeRole?->id === $role->id ? 'is-active' : '' }}"
                                href="{{ route('manage.users', $keep(['role' => $role->slug])) }}">{{ $role->name }} <b>{{ number_format($userCounts[$role->id] ?? 0) }}</b></a></li>
                    @endforeach
                </ul>
            </div>

            <form method="GET" action="{{ route('manage.users') }}" class="ui-toolbar" role="search">
                @if ($roleParam)<input type="hidden" name="role" value="{{ $roleParam }}">@endif
                <input type="search" name="q" value="{{ $filters['q'] }}" class="ui-field ui-grow"
                    placeholder="Search name, username, email, phone, mosque or district" aria-label="Search users">
                <select name="status" class="ui-field" style="width:auto" aria-label="Status" onchange="this.form.submit()">
                    <option value="">Any status</option>
                    @foreach (['active' => 'Active', 'pending' => 'Not yet active', 'suspended' => 'Suspended', 'locked' => 'Locked', 'banned' => 'Banned'] as $v => $l)
                        <option value="{{ $v }}" @selected($filters['status'] === $v)>{{ $l }}</option>
                    @endforeach
                </select>
                <button class="ui-btn" type="submit"><i class="bx bx-search"></i> Search</button>
                @if ($filters['q'] !== '' || $filters['status'] !== '')
                    <a class="ui-btn" href="{{ route('manage.users', array_filter(['role' => $roleParam])) }}">Clear</a>
                @endif
            </form>

            @if ($users->count())
                <div class="table-responsive">
                    <table class="table table-hover adm-table">
                        <thead>
                            <tr>
                                <th>Person</th>
                                <th>Role</th>
                                <th>Jurisdiction</th>
                                <th>Contact</th>
                                <th>Status</th>
                                @if ($canSeeCredentials)<th>Temporary password</th>@endif
                                <th class="adm-actions"><span class="visually-hidden">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                @php
                                    $fullName = trim($user->firstname . ' ' . $user->lastname) ?: $user->username;
                                    $initials = mb_strtoupper(mb_substr($user->firstname ?? '', 0, 1) . mb_substr($user->lastname ?? '', 0, 1)) ?: '?';
                                    $canManage = AC::canManageUser($user);
                                    $canEditThis = $canManage && AC::can('users.edit');
                                    $canDeleteThis = $canManage && AC::can('users.delete');
                                    $canSuspendThis = $canManage && AC::can('users.suspend');
                                    $canBanThis = $canManage && AC::can('users.ban');
                                    $isSelf = $me?->id === $user->id;
                                    $st = $statusKey($user->account_status);
                                @endphp
                                <tr class="{{ $isSelf ? 'is-self' : '' }}">
                                    <td>
                                        <div class="adm-person">
                                            <span class="adm-avatar">
                                                @if ($user->profile_photo)<img src="{{ asset('storage/' . $user->profile_photo) }}" alt="">@else{{ $initials }}@endif
                                            </span>
                                            <div>
                                                <strong title="{{ $fullName }}">{{ $fullName }}@if ($isSelf) <span class="adm-chip">You</span>@endif</strong>
                                                <span>{{ '@' . $user->username }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="adm-role" style="--role: {{ $user->role_color }}">{{ $user->role_name ?? 'No role' }}</span></td>
                                    <td class="adm-place">
                                        {{ $user->mosque_name ?: ($user->county ?: ($user->district ?: ($user->region ?: '—'))) }}
                                        @php $trail = collect([$user->mosque_name ? $user->county : null, $user->district, $user->region])->filter()->unique()->implode(' · '); @endphp
                                        @if ($trail)<small>{{ $trail }}</small>@endif
                                    </td>
                                    <td class="adm-place">
                                        <span class="adm-num">{{ $user->phonenumber ?: '—' }}</span>
                                        @if ($user->email)<small>{{ $user->email }}</small>@endif
                                    </td>
                                    <td><x-ui.status-badge :status="$st" :label="$user->account_status_text" /></td>
                                    @if ($canSeeCredentials)
                                        <td>
                                            @if ($user->credentials_status === 'pending' && $user->generated_password)
                                                <span class="adm-secret" data-secret="{{ $user->generated_password }}">
                                                    <span class="adm-secret-text">••••••••</span>
                                                    <button type="button" class="adm-icon-btn js-reveal" aria-label="Show password"><i class="bx bx-show"></i></button>
                                                    <button type="button" class="adm-icon-btn copy-btn" data-password="{{ $user->generated_password }}" aria-label="Copy password"><i class="bx bx-copy"></i></button>
                                                </span>
                                                <span class="adm-secret-note">Not yet changed</span>
                                            @elseif ($user->credentials_status === 'updated')
                                                <span class="adm-muted">Changed by user</span>
                                            @else
                                                <span class="adm-muted">—</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td class="adm-actions">
                                        <button type="button" class="adm-icon-btn view-user" data-id="{{ $user->id }}" aria-label="View {{ $fullName }}" title="View"><i class="bx bx-show-alt"></i></button>
                                        @if ($canEditThis)
                                            <button type="button" class="adm-icon-btn edit-user" data-id="{{ $user->id }}" aria-label="Edit {{ $fullName }}" title="Edit"><i class="bx bx-edit-alt"></i></button>
                                        @endif
                                        @if ((($canSuspendThis || $canBanThis) || $canDeleteThis) && !$isSelf)
                                            <div class="dropdown d-inline-block">
                                                <button type="button" class="adm-icon-btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More actions"><i class="bx bx-dots-vertical-rounded"></i></button>
                                                <ul class="dropdown-menu dropdown-menu-end adm-menu">
                                                    @if ($canSuspendThis && (int) $user->account_status !== 10)
                                                        <li><button type="button" class="dropdown-item status-action" data-id="{{ $user->id }}" data-status="10"><i class="bx bx-play-circle"></i> Activate</button></li>
                                                    @endif
                                                    @if ($canSuspendThis && (int) $user->account_status !== 9)
                                                        <li><button type="button" class="dropdown-item status-action" data-id="{{ $user->id }}" data-status="9"><i class="bx bx-pause-circle"></i> Suspend</button></li>
                                                    @endif
                                                    @if ($canBanThis && (int) $user->account_status !== 0)
                                                        <li><button type="button" class="dropdown-item status-action is-danger" data-id="{{ $user->id }}" data-status="0"><i class="bx bx-block"></i> Ban</button></li>
                                                    @endif
                                                    @if ($canDeleteThis)
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li><button type="button" class="dropdown-item delete-user is-danger" data-id="{{ $user->id }}"><i class="bx bx-trash-alt"></i> Delete account</button></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="adm-foot">
                    <span>Showing {{ number_format($users->firstItem()) }}–{{ number_format($users->lastItem()) }} of {{ number_format($users->total()) }}</span>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @else
                <x-ui.empty-state icon="bx-user-x" title="No users found"
                    text="Try a different search, or clear the filters.">
                    <a class="ui-btn" href="{{ route('manage.users') }}">Clear filters</a>
                </x-ui.empty-state>
            @endif
        </section>

        {{-- View / edit modals and their JS. Included once, after the table. --}}
        @include('layouts.views.users-action-modals')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function copy(text, btn) {
                var done = function () { var i = btn.querySelector('i'), c = i.className; i.className = 'bx bx-check'; setTimeout(function () { i.className = c; }, 1200); };
                if (navigator.clipboard && navigator.clipboard.writeText) { navigator.clipboard.writeText(text).then(done); return; }
                var ta = document.createElement('textarea'); ta.value = text; ta.style.cssText = 'position:fixed;opacity:0';
                document.body.appendChild(ta); ta.select();
                try { document.execCommand('copy'); done(); } catch (e) {}
                document.body.removeChild(ta);
            }
            document.querySelectorAll('.copy-btn').forEach(function (b) {
                b.addEventListener('click', function () { copy(b.getAttribute('data-password'), b); });
            });
            document.querySelectorAll('.js-reveal').forEach(function (b) {
                b.addEventListener('click', function () {
                    var wrap = b.closest('.adm-secret'), txt = wrap.querySelector('.adm-secret-text'), shown = b.getAttribute('data-on') === '1';
                    txt.textContent = shown ? '••••••••' : wrap.getAttribute('data-secret');
                    b.setAttribute('data-on', shown ? '0' : '1');
                    b.querySelector('i').className = shown ? 'bx bx-show' : 'bx bx-hide';
                    b.setAttribute('aria-label', shown ? 'Show password' : 'Hide password');
                });
            });
        });
    </script>
@endsection
