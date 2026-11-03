@extends('layouts.app')

@section('content')
    @php
        $sum = fn (string $key) => collect($roleStats)->sum(fn ($r) => $r['stats'][$key]);
        $active = $sum('active');
        $inactive = $sum('pending');
        $restricted = $sum('suspended');
        $statusOf = fn ($u) => match ((int) $u->account_status) {
            10 => 'active',
            9, 8 => 'suspended',
            0 => 'banned',
            default => 'pending',
        };
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Users" subtitle="Accounts, roles and access across the Directorate."
            :crumbs="['Dashboard' => route('user.dashboard'), 'Users' => null]">
            @can_permission('users.create')
                <a href="{{ route('add.users') }}" class="ui-btn ui-btn--primary"><i class="bx bx-user-plus"></i> Add user</a>
            @endcan_permission
            @can_permission('users.view')
                <a href="{{ route('manage.users') }}" class="ui-btn"><i class="bx bx-list-ul"></i> All accounts</a>
            @endcan_permission
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Accounts" :value="$totalUsers" note="In your scope" icon="bx-group"
                :href="route('manage.users')" />
            <x-ui.stat label="Active" :value="$active" note="Can sign in" icon="bx-check-circle"
                :href="route('manage.users', ['status' => 'active'])" />
            <x-ui.stat label="Not yet active" :value="$inactive" note="Awaiting first sign-in" icon="bx-time-five"
                :tone="$inactive ? 'warn' : null" :href="route('manage.users', ['status' => 'pending'])" />
            <x-ui.stat label="Restricted" :value="$restricted" note="Suspended, locked or banned" icon="bx-lock-alt"
                :tone="$restricted ? 'bad' : null" :href="route('manage.users', ['status' => 'suspended'])" />
        </x-ui.stats>

        <div class="adm-cols">
            <div class="ui-stack">
                {{-- Accounts by role --}}
                <section class="card">
                    <div class="card-header d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2 class="h5 mb-0">Accounts by role</h2>
                            <p class="text-muted small mb-0 mt-1">Select a role to open its accounts.</p>
                        </div>
                        @can_permission('roles.view')
                            <a href="{{ route('roles.index') }}" class="ui-link">Roles &amp; privileges <i
                                    class="bx bx-right-arrow-alt rtl-flip" aria-hidden="true"></i></a>
                        @endcan_permission
                    </div>

                    @if (count($roleStats))
                        <div class="table-responsive">
                            <table class="table table-hover adm-table">
                                <thead>
                                    <tr>
                                        <th>Role</th>
                                        <th class="is-num">Accounts</th>
                                        <th class="is-num">Active</th>
                                        <th class="is-num">Not yet active</th>
                                        <th class="is-num">Restricted</th>
                                        <th>Share</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roleStats as $role)
                                        @php $share = $totalUsers ? round($role['stats']['users'] / $totalUsers * 100) : 0; @endphp
                                        <tr style="--role: {{ $role['color'] }}">
                                            <td>
                                                <a href="{{ route('manage.users', ['role' => $role['slug']]) }}" class="adm-role">{{ $role['title'] }}</a>
                                                <span class="ui-sub" style="margin-inline-start:12px">{{ $role['scope'] }}</span>
                                            </td>
                                            <td class="is-num"><strong>{{ number_format($role['stats']['users']) }}</strong></td>
                                            <td class="is-num">{{ number_format($role['stats']['active']) }}</td>
                                            <td class="is-num">{{ number_format($role['stats']['pending']) }}</td>
                                            <td class="is-num">{{ number_format($role['stats']['suspended']) }}</td>
                                            <td>
                                                <div class="adm-share">
                                                    <div class="ui-bar"><span style="width: {{ $share }}%"></span></div>
                                                    <em>{{ $share }}%</em>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <x-ui.empty-state icon="bx-user-x" title="No roles in your scope"
                            text="You do not manage any accounts below your own rank." />
                    @endif
                </section>

                {{-- Recently added --}}
                <section class="card">
                    <div class="card-header d-flex justify-content-between align-items-start gap-3">
                        <div>
                            <h2 class="h5 mb-0">Recently added</h2>
                            <p class="text-muted small mb-0 mt-1">The latest accounts created in your scope.</p>
                        </div>
                        @can_permission('users.view')
                            <a href="{{ route('manage.users') }}" class="ui-link">View all <i
                                    class="bx bx-right-arrow-alt rtl-flip" aria-hidden="true"></i></a>
                        @endcan_permission
                    </div>

                    @if ($recentUsers->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-hover adm-table">
                                <thead>
                                    <tr>
                                        <th>Person</th>
                                        <th>Role</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>Added</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recentUsers as $u)
                                        @php
                                            $name = trim($u->firstname . ' ' . $u->lastname) ?: $u->username;
                                            $initials = mb_strtoupper(mb_substr($u->firstname ?? '', 0, 1) . mb_substr($u->lastname ?? '', 0, 1)) ?: '?';
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="adm-person">
                                                    <span class="adm-avatar">{{ $initials }}</span>
                                                    <div><strong>{{ $name }}</strong><span>{{ '@' . $u->username }}</span></div>
                                                </div>
                                            </td>
                                            <td><span class="adm-role" style="--role: {{ $u->role_color }}">{{ $u->role_name ?? 'No role' }}</span></td>
                                            <td class="adm-num">{{ $u->phonenumber ?: '—' }}</td>
                                            <td><x-ui.status-badge :status="$statusOf($u)" /></td>
                                            <td class="adm-muted">{{ optional($u->created_at)->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <x-ui.empty-state icon="bx-user-plus" title="No accounts yet"
                            text="Accounts you create will appear here." />
                    @endif
                </section>
            </div>

            {{-- Administration shortcuts --}}
            <aside class="ui-stack">
                <section class="card">
                    <div class="card-header"><h2 class="h5 mb-0">Administration</h2></div>
                    <ul class="adm-links">
                        @can_permission('users.create')
                            <li><a href="{{ route('add.users') }}"><i class="bx bx-user-plus lead"></i>
                                    <span><strong>Add a user</strong><small>Create an account and assign a role</small></span>
                                    <i class="bx bx-chevron-right go"></i></a></li>
                        @endcan_permission
                        @can_permission('users.view')
                            <li><a href="{{ route('manage.users') }}"><i class="bx bx-group lead"></i>
                                    <span><strong>Manage users</strong><small>Edit, suspend or remove accounts</small></span>
                                    <i class="bx bx-chevron-right go"></i></a></li>
                        @endcan_permission
                        @can_permission('roles.view')
                            <li><a href="{{ route('roles.index') }}"><i class="bx bx-customize lead"></i>
                                    <span><strong>Roles &amp; privileges</strong><small>What each role can see and do</small></span>
                                    <i class="bx bx-chevron-right go"></i></a></li>
                        @endcan_permission
                        @can_permission('bulk_import.view')
                            <li><a href="{{ route('bulk-import.index') }}"><i class="bx bx-cloud-upload lead"></i>
                                    <span><strong>Bulk import</strong><small>Mosque directory and officer accounts</small></span>
                                    <i class="bx bx-chevron-right go"></i></a></li>
                        @endcan_permission
                        @can_permission('activity_logs.view')
                            <li><a href="{{ route('activity-logs.index') }}"><i class="bx bx-history lead"></i>
                                    <span><strong>Activity log</strong><small>Who did what, and when</small></span>
                                    <i class="bx bx-chevron-right go"></i></a></li>
                        @endcan_permission
                    </ul>
                </section>
            </aside>
        </div>
    </div>
@endsection
