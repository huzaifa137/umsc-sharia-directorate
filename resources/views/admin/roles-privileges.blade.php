@extends('layouts.app')

@section('content')
    @php
        $actionOrder = ['view' => 'View', 'create' => 'Create', 'edit' => 'Edit', 'approve' => 'Approve', 'delete' => 'Delete', 'suspend' => 'Suspend', 'ban' => 'Ban', 'manage' => 'Manage', 'run' => 'Run'];
        $usedActions = collect($permissions)->flatten()->pluck('action')->unique();
        $columns = collect($actionOrder)->filter(fn ($l, $k) => $usedActions->contains($k));
        $granted = function ($role, $perm) {
            return $role->full_access || $role->permissions->contains('id', $perm->id);
        };
        $first = $roles->first();
        $maxLevel = \App\Services\AccessControl::hasFullAccess() ? 99 : max(1, (\App\Services\AccessControl::role()?->level ?? 1) - 1);
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Roles & privileges" subtitle="What each role can see and do. Visibility of records is set by the role's scope."
            :crumbs="['Users' => route('users.dashboard'), 'Roles & privileges' => null]">
            @can_permission('roles.manage')
                <button type="button" class="ui-btn ui-btn--primary" id="openCreateRoleBtn"><i class="bx bx-plus"></i> New role</button>
            @endcan_permission
        </x-ui.page-header>

        @if ($roles->isEmpty())
            <section class="card"><x-ui.empty-state icon="bx-customize" title="No roles to display" text="There are no roles in your scope." /></section>
        @else
            <ul class="adm-tabs" role="tablist">
                <li><button type="button" class="adm-tab is-active" data-view="detail" role="tab">By role</button></li>
                <li><button type="button" class="adm-tab" data-view="compare" role="tab">Compare all roles</button></li>
            </ul>

            {{-- ===== By role ===== --}}
            <div class="adm-split" id="view-detail">
                <section class="card">
                    <ul class="adm-rolelist">
                        @foreach ($roles as $role)
                            <li>
                                <button type="button" class="adm-roleitem {{ $role->id === $first->id ? 'is-active' : '' }}" data-role="{{ $role->id }}" style="--role: {{ $role->color }}">
                                    <strong>{{ $role->name }} @if ($role->is_system)<span class="adm-chip">System</span>@endif</strong>
                                    <small>{{ $role->visibilityLabel() }} · {{ number_format($role->users_count) }} {{ \Illuminate\Support\Str::plural('account', $role->users_count) }}</small>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </section>

                <div>
                    @foreach ($roles as $role)
                        <section class="card adm-pane" data-pane="{{ $role->id }}" style="--role: {{ $role->color }}" @if ($role->id !== $first->id) hidden @endif>
                            <div class="adm-role-head">
                                <div>
                                    <h2>{{ $role->name }}</h2>
                                    <p>{{ $role->description ?: 'No description provided.' }}</p>
                                </div>
                                @can_permission('roles.manage')
                                    <div class="d-flex gap-2">
                                        <button type="button" class="ui-btn edit-role-btn" data-id="{{ $role->id }}"><i class="bx bx-edit-alt"></i> Edit</button>
                                        @unless ($role->is_system)
                                            <button type="button" class="ui-btn delete-role-btn" data-id="{{ $role->id }}" data-name="{{ $role->name }}" aria-label="Delete {{ $role->name }}"><i class="bx bx-trash-alt"></i></button>
                                        @endunless
                                    </div>
                                @endcan_permission
                            </div>
                            <div class="adm-role-facts">
                                <dl class="adm-kv">
                                    <div><dt>Sees</dt><dd>{{ $role->visibilityLabel() }}</dd></div>
                                    <div><dt>Rank</dt><dd class="adm-num">Level {{ $role->level }}</dd></div>
                                    <div><dt>Accounts</dt><dd class="adm-num">{{ number_format($role->users_count) }}</dd></div>
                                    <div><dt>Privileges</dt><dd class="adm-num">{{ $role->full_access ? 'All' : $role->permissions->count() . ' of ' . collect($permissions)->flatten()->count() }}</dd></div>
                                </dl>
                            </div>
                            @if ($role->full_access)
                                <p class="adm-note">This role has full, unrestricted access. Every privilege below is granted automatically.</p>
                            @elseif ($role->is_system)
                                <p class="adm-note">Built-in role. Its name, scope and rank are fixed, but its privileges can be adjusted.</p>
                            @endif
                            <div class="adm-matrix-wrap">
                                <table class="adm-matrix">
                                    <thead>
                                        <tr>
                                            <th>Area</th>
                                            @foreach ($columns as $k => $l)<th>{{ $l }}</th>@endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $module => $list)
                                            <tr>
                                                <td>{{ $module }}</td>
                                                @foreach ($columns as $k => $l)
                                                    @php $perm = $list->firstWhere('action', $k); @endphp
                                                    <td>
                                                        @if (!$perm)
                                                            <span class="adm-mark adm-mark--na" aria-label="Not applicable">·</span>
                                                        @elseif ($granted($role, $perm))
                                                            <span class="adm-mark adm-mark--on" title="{{ $perm->name }}" aria-label="Granted: {{ $perm->name }}"><i class="bx bx-check"></i></span>
                                                        @else
                                                            <span class="adm-mark adm-mark--off" title="{{ $perm->name }}" aria-label="Not granted: {{ $perm->name }}"></span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>

            {{-- ===== Compare ===== --}}
            <section class="card" id="view-compare" hidden>
                <div class="adm-matrix-wrap">
                    <table class="adm-matrix adm-compare">
                        <thead>
                            <tr>
                                <th>Privilege</th>
                                @foreach ($roles as $role)
                                    <th class="role-col" style="--role: {{ $role->color }}"><i></i>{{ $role->name }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $module => $list)
                                <tr class="adm-group"><th colspan="{{ $roles->count() + 1 }}">{{ $module }}</th></tr>
                                @foreach ($list as $perm)
                                    <tr>
                                        <td>{{ $perm->name }}</td>
                                        @foreach ($roles as $role)
                                            <td>
                                                @if ($granted($role, $perm))
                                                    <span class="adm-mark adm-mark--on" aria-label="Granted"><i class="bx bx-check"></i></span>
                                                @else
                                                    <span class="adm-mark adm-mark--off" aria-label="Not granted"></span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        @endif
    </div>

    {{-- ===== Create / edit role ===== --}}
    <div class="modal fade adm-modal" id="roleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="roleModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="roleModalTitle">New role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="roleForm" novalidate>
                    @csrf
                    <input type="hidden" id="roleId" name="role_id">
                    <div class="modal-body">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="roleName">Role name <span class="ui-req">*</span></label>
                                        <input type="text" id="roleName" name="name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="roleDataScope">Visibility scope <span class="ui-req">*</span></label>
                                        <select id="roleDataScope" name="data_scope" class="form-select" required>
                                            <option value="self">Own records only (e.g. an Imaam)</option>
                                            <option value="county">County-wide (e.g. a County Sheikh)</option>
                                            <option value="district">District-wide (e.g. a District Khadhi)</option>
                                            <option value="region">Region-wide (e.g. a Regional Assistant)</option>
                                            @full_access
                                                <option value="global" id="globalScopeOption">Entire system (Director only)</option>
                                            @endfull_access
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="roleDescription">Description</label>
                                        <input type="text" id="roleDescription" name="description" class="form-control" placeholder="What is this role responsible for?">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="roleColor">Marker colour</label>
                                        <input type="color" id="roleColor" name="color" class="form-control form-control-color w-100" value="#136a3b">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label" for="roleLevel">Rank level <span class="ui-req">*</span></label>
                                        <input type="number" id="roleLevel" name="level" class="form-control" min="1" max="{{ $maxLevel }}" value="{{ min(15, $maxLevel) }}" required>
                                        <p class="ui-hint mb-0">Higher ranks manage lower ones. Your maximum is {{ $maxLevel }}.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p id="systemRoleNotice" class="adm-hintbox d-none mb-3"><b>Built-in role.</b> Its name, scope and rank are fixed. You can still adjust its privileges below.</p>

                        <div class="card">
                            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                                <h3 class="h6 mb-0">Privileges</h3>
                                <div class="d-flex gap-2">
                                    <button type="button" class="ui-btn" id="selectAllPerms">Select all</button>
                                    <button type="button" class="ui-btn" id="deselectAllPerms">Clear</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="adm-perm-grid" id="permissionGroups">
                                    @foreach ($permissions as $module => $modulePermissions)
                                        <div class="adm-perm-group">
                                            <header>
                                                <strong>{{ $module }}</strong>
                                                <a href="#" class="select-all-link" data-module="{{ $module }}">Toggle all</a>
                                            </header>
                                            @foreach ($modulePermissions as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" value="{{ $permission->id }}"
                                                        data-module="{{ $module }}" id="perm-{{ $permission->id }}" name="permissions[]">
                                                    <label class="form-check-label" for="perm-{{ $permission->id }}">{{ $permission->name }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="ui-btn" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="ui-btn ui-btn--primary" id="roleSubmitBtn"><i class="bx bx-save"></i> Save role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var rolesData = @json($roles->keyBy('id'));
            var csrf = document.querySelector('meta[name="csrf-token"]').content;
            var $ = function (id) { return document.getElementById(id); };

            // View switch and role selection
            document.querySelectorAll('.adm-tab[data-view]').forEach(function (t) {
                t.addEventListener('click', function () {
                    document.querySelectorAll('.adm-tab[data-view]').forEach(function (x) { x.classList.toggle('is-active', x === t); });
                    var detail = t.dataset.view === 'detail';
                    var d = $('view-detail'), c = $('view-compare');
                    if (d) d.hidden = !detail;
                    if (c) c.hidden = detail;
                });
            });
            document.querySelectorAll('.adm-roleitem').forEach(function (b) {
                b.addEventListener('click', function () {
                    document.querySelectorAll('.adm-roleitem').forEach(function (x) { x.classList.toggle('is-active', x === b); });
                    document.querySelectorAll('.adm-pane').forEach(function (p) { p.hidden = p.dataset.pane !== b.dataset.role; });
                });
            });

            // Role editor
            var modalEl = $('roleModal');
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            var f = { id: $('roleId'), name: $('roleName'), scope: $('roleDataScope'), desc: $('roleDescription'), color: $('roleColor'), level: $('roleLevel') };
            var fixed = [f.name, f.scope, f.level];

            function reset() {
                $('roleForm').reset();
                f.id.value = '';
                $('roleModalTitle').textContent = 'New role';
                $('systemRoleNotice').classList.add('d-none');
                fixed.forEach(function (el) { el.disabled = false; });
                document.querySelectorAll('.permission-checkbox').forEach(function (c) { c.checked = false; });
            }
            function populate(role) {
                f.id.value = role.id; f.name.value = role.name; f.scope.value = role.data_scope;
                f.desc.value = role.description || ''; f.color.value = role.color || '#136a3b'; f.level.value = role.level;
                document.querySelectorAll('.permission-checkbox').forEach(function (c) {
                    c.checked = !!role.full_access || (role.permissions || []).some(function (p) { return p.id == c.value; });
                });
                $('systemRoleNotice').classList.toggle('d-none', !role.is_system);
                fixed.forEach(function (el) { el.disabled = !!role.is_system; });
            }
            var openBtn = $('openCreateRoleBtn');
            if (openBtn) openBtn.addEventListener('click', function () { reset(); modal.show(); });
            document.querySelectorAll('.edit-role-btn').forEach(function (b) {
                b.addEventListener('click', function () {
                    reset(); $('roleModalTitle').textContent = 'Edit role'; populate(rolesData[b.dataset.id]); modal.show();
                    setTimeout(function () { var mb = modalEl.querySelector('.modal-body'); if (mb) mb.scrollTop = 0; }, 100);
                });
            });
            $('selectAllPerms').addEventListener('click', function () { document.querySelectorAll('.permission-checkbox').forEach(function (c) { c.checked = true; }); });
            $('deselectAllPerms').addEventListener('click', function () { document.querySelectorAll('.permission-checkbox').forEach(function (c) { c.checked = false; }); });
            document.querySelectorAll('.select-all-link').forEach(function (a) {
                a.addEventListener('click', function (e) {
                    e.preventDefault();
                    var boxes = [].slice.call(document.querySelectorAll('.permission-checkbox')).filter(function (c) { return c.dataset.module === a.dataset.module; });
                    var all = boxes.every(function (c) { return c.checked; });
                    boxes.forEach(function (c) { c.checked = !all; });
                });
            });

            document.querySelectorAll('.delete-role-btn').forEach(function (b) {
                b.addEventListener('click', function () {
                    UMSC.confirm({ title: 'Delete "' + b.dataset.name + '"?', text: 'This cannot be undone. Accounts must be moved to another role first.', confirmText: 'Delete role', danger: true }).then(function (ok) {
                        if (!ok) return;
                        fetch('/roles/' + b.dataset.id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' } })
                            .then(function (r) { return r.json(); })
                            .then(function (d) {
                                if (d.status) { UMSC.toast('success', d.message); setTimeout(function () { location.reload(); }, 700); }
                                else UMSC.toast('error', d.message || 'Unable to delete role.');
                            }).catch(function () { UMSC.toast('error', 'Unable to delete role.'); });
                    });
                });
            });

            $('roleForm').addEventListener('submit', function (e) {
                e.preventDefault();
                var id = f.id.value, btn = $('roleSubmitBtn');
                var payload = {
                    name: f.name.value, description: f.desc.value, data_scope: f.scope.value,
                    level: parseInt(f.level.value, 10) || 10, color: f.color.value,
                    permissions: [].slice.call(document.querySelectorAll('.permission-checkbox:checked')).map(function (c) { return parseInt(c.value, 10); })
                };
                UMSC.busy(btn, true, 'Saving…');
                fetch(id ? '/roles/' + id : '/roles', {
                    method: id ? 'PUT' : 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify(payload)
                }).then(function (r) { return r.json().then(function (d) { return { r: r, d: d }; }); })
                  .then(function (o) {
                    UMSC.busy(btn, false);
                    if (o.d.status) { modal.hide(); UMSC.toast('success', o.d.message); setTimeout(function () { location.reload(); }, 700); return; }
                    var msg = o.d.message || 'Unable to save role.';
                    if (o.d.errors) msg = Object.values(o.d.errors)[0][0];
                    UMSC.toast('error', msg);
                  }).catch(function () { UMSC.busy(btn, false); UMSC.toast('error', 'Unable to save role.'); });
            });
        });
    </script>
@endsection
