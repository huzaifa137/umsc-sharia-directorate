@extends('layouts.auth')

@section('title', 'Set a new password')
@section('aside_title', 'Secure your account')
@section('aside_text', 'The password you were given is temporary. Choose your own before you continue.')

@section('content')
    <h1>Set a new password</h1>
    <p class="a-sub">Welcome, {{ $user->firstname }}. This replaces the password issued to you.</p>

    <div class="a-alert a-alert--error" id="forceAlert" role="alert" hidden></div>

    <form id="forceChangeForm" novalidate>
        <div class="a-field">
            <label for="newPassword">New password</label>
            <div class="a-pass">
                <input class="a-input" type="password" id="newPassword" name="newPassword"
                    autocomplete="new-password" autofocus>
                <button type="button" data-toggle="#newPassword" data-show="Show" data-hide="Hide"
                    aria-pressed="false">Show</button>
            </div>
            <span class="a-hint" data-caps-for="#newPassword">Caps Lock is on.</span>
            <span class="a-error" id="newPassword-error"></span>
        </div>

        <div class="a-field">
            <label for="confirmPassword">Confirm new password</label>
            <div class="a-pass">
                <input class="a-input" type="password" id="confirmPassword" name="confirmPassword"
                    autocomplete="new-password">
                <button type="button" data-toggle="#confirmPassword" data-show="Show" data-hide="Hide"
                    aria-pressed="false">Show</button>
            </div>
            <span class="a-error" id="confirmPassword-error"></span>
        </div>

        <ul class="a-rules" data-for="#newPassword" data-confirm="#confirmPassword">
            <li data-rule="min8">At least 8 characters</li>
            <li data-rule="upper">An uppercase letter</li>
            <li data-rule="symbol">A symbol (such as ! # @)</li>
            <li data-rule="match">Both entries match</li>
        </ul>

        <button type="submit" class="u-btn u-btn--solid a-submit" id="submitBtn">Save and continue</button>
    </form>

    <p class="a-links"><a href="{{ route('user.logout') }}">Sign out instead</a></p>
@endsection

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById('forceChangeForm');
            var btn = document.getElementById('submitBtn');
            var box = document.getElementById('forceAlert');
            var auth = window.umscAuth;

            function busy(on) {
                btn.disabled = on;
                btn.textContent = on ? 'Saving…' : 'Save and continue';
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                box.hidden = true;
                auth.setError('newPassword', '');
                auth.setError('confirmPassword', '');

                var p = form.newPassword.value;
                var c = form.confirmPassword.value;
                var bad = false;
                if (p.length < 8 || !/[A-Z]/.test(p) || !/[^a-zA-Z0-9]/.test(p)) {
                    auth.setError('newPassword', 'The password does not meet all the requirements below.');
                    bad = true;
                }
                if (p !== c) {
                    auth.setError('confirmPassword', 'The two passwords do not match.');
                    bad = true;
                }
                if (bad) {
                    (form.querySelector('.is-invalid') || form.newPassword).focus();
                    return;
                }

                busy(true);
                auth.post(@json(route('admin.change.password')), {
                    newPassword: p,
                    confirmPassword: c
                }).then(function(res) {
                    var b = res.body || {};
                    if (res.ok) {
                        btn.textContent = 'Password updated. Redirecting…';
                        window.location.href = b.redirect_url || '/users/dashboard';
                        return;
                    }
                    if (res.status === 422 && b.errors) {
                        Object.keys(b.errors).forEach(function(k) { auth.setError(k, b.errors[k][0]); });
                    } else {
                        box.textContent = b.message || 'Something went wrong. Please try again.';
                        box.hidden = false;
                    }
                    busy(false);
                }).catch(function() {
                    box.textContent = 'Could not reach the server. Check your connection and try again.';
                    box.hidden = false;
                    busy(false);
                });
            });
        })();
    </script>
@endpush
