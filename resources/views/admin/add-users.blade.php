@extends('layouts.app')

@section('content')
    @php
        $me = \App\Services\AccessControl::user();
        $lockJurisdiction = !\App\Services\AccessControl::hasFullAccess();
        $myScope = $me?->role?->data_scope;
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Add user" subtitle="Create an account and set the role and jurisdiction it works under."
            :crumbs="['Users' => route('users.dashboard'), 'Add user' => null]">
            <a href="{{ route('manage.users') }}" class="ui-btn"><i class="bx bx-list-ul"></i> All accounts</a>
        </x-ui.page-header>

        <form id="createUserForm" action="{{ route('save.new.user') }}" method="POST" enctype="multipart/form-data" class="ui-sheet adm-form" novalidate>
            @csrf

            <fieldset class="ui-fieldset">
                <legend><span class="ui-fieldset__n">1</span><span><strong>Sign-in details</strong><small>The officer uses these to log in</small></span></legend>
                <div class="ui-grid">
                    <div class="ui-field">
                        <label for="username">Username <span class="ui-req">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" autocomplete="off" required>
                        <div class="invalid-feedback">Enter a username.</div>
                    </div>
                    <div class="ui-field">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" autocomplete="off">
                        <div class="invalid-feedback">Enter a valid email address.</div>
                    </div>
                    <div class="ui-field ui-field--full">
                        <label for="password">Temporary password <span class="ui-req">*</span></label>
                        <div class="adm-inline">
                            <input type="password" name="password" id="password" class="form-control" autocomplete="new-password" minlength="6" required>
                            <button type="button" class="ui-btn" id="eye-icon" aria-label="Show password"><i class="bx bx-show"></i></button>
                            <button type="button" class="ui-btn" id="genPassword"><i class="bx bx-refresh"></i> Generate</button>
                        </div>
                        <div class="invalid-feedback">Use at least 6 characters.</div>
                        <p class="ui-hint">The officer is asked to choose their own password the first time they sign in.</p>
                    </div>
                </div>
            </fieldset>

            <fieldset class="ui-fieldset">
                <legend><span class="ui-fieldset__n">2</span><span><strong>Personal details</strong><small>Who this account belongs to</small></span></legend>
                <div class="ui-grid">
                    <div class="ui-field">
                        <label for="firstname">First name <span class="ui-req">*</span></label>
                        <input type="text" name="firstname" id="firstname" class="form-control" required>
                        <div class="invalid-feedback">Enter a first name.</div>
                    </div>
                    <div class="ui-field">
                        <label for="lastname">Last name</label>
                        <input type="text" name="lastname" id="lastname" class="form-control">
                    </div>
                    <div class="ui-field">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-select">
                            <option value="">Not specified</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="ui-field">
                        <label for="phonenumber">Phone number</label>
                        <input type="text" name="phonenumber" id="phonenumber" class="form-control" inputmode="tel" placeholder="+256 …">
                    </div>
                    <div class="ui-field">
                        <label for="country">Country</label>
                        <input type="text" name="country" id="country" class="form-control" value="Uganda">
                    </div>
                    <div class="ui-field">
                        <label for="profile_photo">Profile photo</label>
                        <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*">
                        <p class="ui-hint">JPEG, PNG or GIF, up to 2 MB.</p>
                        <div class="invalid-feedback">Choose an image under 2 MB.</div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="ui-fieldset">
                <legend><span class="ui-fieldset__n">3</span><span><strong>Role and jurisdiction</strong><small>What this account can see and where</small></span></legend>
                <div class="ui-grid">
                    <div class="ui-field ui-field--full">
                        <label for="role_id">Role <span class="ui-req">*</span></label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <option value="">Select a role</option>
                            @forelse ($assignableRoles as $role)
                                <option value="{{ $role->id }}" data-scope="{{ $role->data_scope }}">{{ $role->name }}: {{ $role->visibilityLabel() }}</option>
                            @empty
                                <option value="" disabled>No roles are available for you to assign</option>
                            @endforelse
                        </select>
                        <div class="invalid-feedback">Choose a role.</div>
                        <p class="adm-roledesc" id="role_description"></p>
                    </div>

                    <div class="ui-field jurisdiction-field" data-needs="county,district,global">
                        <label for="region">Region</label>
                        <input type="text" name="region" id="region" class="form-control" list="regionList" placeholder="e.g. Busoga Muslim Region"
                            value="{{ $lockJurisdiction ? $me?->region : '' }}" {{ $lockJurisdiction ? 'readonly' : '' }}>
                        <datalist id="regionList"></datalist>
                        <div class="invalid-feedback">Region is required for this role.</div>
                    </div>
                    <div class="ui-field jurisdiction-field" data-needs="county,district">
                        <label for="district">District</label>
                        @php $lockD = $lockJurisdiction && in_array($myScope, ['district', 'county'], true); @endphp
                        <input type="text" name="district" id="district" class="form-control" list="districtList" placeholder="e.g. Bugweri M D"
                            value="{{ $lockD ? $me?->district : '' }}" {{ $lockD ? 'readonly' : '' }}>
                        <datalist id="districtList"></datalist>
                        <div class="invalid-feedback">District is required for this role.</div>
                    </div>
                    <div class="ui-field jurisdiction-field" data-needs="county">
                        <label for="county">County</label>
                        <input type="text" name="county" id="county" class="form-control" list="countyList" placeholder="e.g. Namalemba County"
                            value="{{ ($lockJurisdiction && $myScope === 'county') ? $me?->county : '' }}">
                        <datalist id="countyList"></datalist>
                        <div class="invalid-feedback">County is required for this role.</div>
                    </div>
                    <div class="ui-field jurisdiction-field" data-needs="">
                        <label for="mosque_name">Mosque</label>
                        <input type="text" name="mosque_name" id="mosque_name" class="form-control" list="mosqueList" placeholder="e.g. Ar-Rahmah Mosque">
                        <datalist id="mosqueList"></datalist>
                        <div class="invalid-feedback">Mosque is required for this role.</div>
                    </div>
                    <p class="ui-hint ui-field--full" style="margin:0">The fields above change with the role: a Director needs none, a Regional Assistant a region, a District Khadhi a district, a County Sheikh a county, and an Imaam a mosque as well.</p>
                </div>
            </fieldset>

            <div class="ui-sheet__foot">
                <a href="{{ route('manage.users') }}" class="ui-btn">Cancel</a>
                <button type="submit" class="ui-btn ui-btn--primary" id="createUserBtn"><i class="bx bx-user-plus"></i> Create account</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('createUserForm');
            var roleSelect = document.getElementById('role_id');
            var roleDesc = document.getElementById('role_description');
            var fields = form.querySelectorAll('.jurisdiction-field');
            var pw = document.getElementById('password');
            var btn = document.getElementById('createUserBtn');

            var needs = { self: ['region', 'district', 'county', 'mosque'], county: ['region', 'district', 'county'], district: ['region', 'district'], region: ['region'], global: [] };
            var blurbs = {
                self: 'Registers cases and sees only the records this person creates.',
                county: 'Sees their own records and everything registered by Imaams in their county.',
                district: 'Sees their own records and everything registered in their district.',
                region: 'Sees their own records and everything registered across their region.',
                global: 'Full access to every record and account on the system.'
            };

            function applyScope(scope) {
                var list = needs[scope] || [];
                fields.forEach(function (f) {
                    var input = f.querySelector('input');
                    var key = input.id === 'mosque_name' ? 'mosque' : input.id;
                    var show = list.indexOf(key) !== -1;
                    f.hidden = !show;
                    input.required = show;
                    if (!show) input.classList.remove('is-invalid');
                });
            }
            roleSelect.addEventListener('change', function () {
                var scope = (this.options[this.selectedIndex] || {}).dataset ? this.options[this.selectedIndex].dataset.scope : '';
                roleDesc.textContent = blurbs[scope] || '';
                applyScope(scope || '');
            });
            applyScope('');
            if (roleSelect.value) roleSelect.dispatchEvent(new Event('change'));

            // Password helpers
            document.getElementById('eye-icon').addEventListener('click', function () {
                var show = pw.type === 'password';
                pw.type = show ? 'text' : 'password';
                this.querySelector('i').className = show ? 'bx bx-hide' : 'bx bx-show';
                this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            });
            document.getElementById('genPassword').addEventListener('click', function () {
                var chars = 'ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789', out = '', a = new Uint32Array(10);
                (window.crypto || window.msCrypto).getRandomValues(a);
                for (var i = 0; i < a.length; i++) out += chars[a[i] % chars.length];
                pw.value = out + '#7';
                pw.type = 'text';
                document.querySelector('#eye-icon i').className = 'bx bx-hide';
                pw.classList.remove('is-invalid');
            });

            // Location suggestions
            function fill(id, items, key) {
                var dl = document.getElementById(id); dl.innerHTML = '';
                (items || []).forEach(function (it) { var o = document.createElement('option'); o.value = key ? it[key] : it; dl.appendChild(o); });
            }
            var district = document.getElementById('district'), county = document.getElementById('county');
            fetch('{{ route('locations.regions') }}').then(function (r) { return r.json(); }).then(function (l) { fill('regionList', l); }).catch(function () {});
            fetch('{{ route('locations.districts') }}').then(function (r) { return r.json(); }).then(function (l) { fill('districtList', l); }).catch(function () {});
            function loadCounties() {
                if (!district.value) return;
                fetch('{{ route('locations.counties') }}?district=' + encodeURIComponent(district.value)).then(function (r) { return r.json(); }).then(function (l) { fill('countyList', l); }).catch(function () {});
            }
            function loadMosques() {
                if (!district.value || !county.value) return;
                fetch('{{ route('locations.mosques') }}?district=' + encodeURIComponent(district.value) + '&county=' + encodeURIComponent(county.value)).then(function (r) { return r.json(); }).then(function (l) { fill('mosqueList', l, 'name'); }).catch(function () {});
            }
            district.addEventListener('change', loadCounties);
            county.addEventListener('change', loadMosques);
            loadCounties(); loadMosques();

            // Validation
            function setErr(el, msg) {
                el.classList.add('is-invalid');
                var fb = el.closest('.ui-field').querySelector('.invalid-feedback');
                if (fb && msg) fb.textContent = msg;
            }
            form.querySelectorAll('input, select').forEach(function (el) {
                el.addEventListener('input', function () { el.classList.remove('is-invalid'); });
            });
            function validate() {
                var bad = [];
                form.querySelectorAll('[required]').forEach(function (el) {
                    if (el.closest('[hidden]')) return;
                    if (!el.value.trim() || (el.type === 'password' && el.value.length < 6)) { setErr(el); bad.push(el); }
                });
                var email = document.getElementById('email');
                if (email.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) { setErr(email); bad.push(email); }
                var photo = document.getElementById('profile_photo');
                if (photo.files[0] && photo.files[0].size > 2 * 1024 * 1024) { setErr(photo); bad.push(photo); }
                return bad;
            }

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                var bad = validate();
                if (bad.length) { bad[0].scrollIntoView({ behavior: 'smooth', block: 'center' }); bad[0].focus(); UMSC.toast('error', 'Check the highlighted fields.'); return; }

                UMSC.confirm({ title: 'Create this account?', text: 'The officer will be able to sign in with the details above.', confirmText: 'Create account' }).then(function (ok) {
                    if (!ok) return;
                    UMSC.busy(btn, true, 'Creating…');
                    fetch(form.action, {
                        method: 'POST',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                        body: new FormData(form)
                    }).then(function (res) {
                        return res.json().catch(function () { return {}; }).then(function (data) { return { res: res, data: data }; });
                    }).then(function (o) {
                        if (o.res.ok && o.data.status === 'success') {
                            UMSC.toast('success', o.data.message || 'Account created.');
                            setTimeout(function () { window.location.href = '{{ route('users.dashboard') }}'; }, 900);
                            return;
                        }
                        UMSC.busy(btn, false);
                        var errs = o.data.errors || {}, first = null;
                        Object.keys(errs).forEach(function (name) {
                            var el = form.querySelector('[name="' + name + '"]');
                            if (el) { setErr(el, errs[name][0]); first = first || el; }
                        });
                        if (first) { first.scrollIntoView({ behavior: 'smooth', block: 'center' }); first.focus(); }
                        UMSC.toast('error', o.data.message || (o.res.status === 419 ? 'Your session expired. Reload the page and try again.' : 'The account could not be created.'));
                    }).catch(function () {
                        UMSC.busy(btn, false);
                        UMSC.toast('error', 'Network problem. Please try again.');
                    });
                });
            });
        });
    </script>
@endsection
