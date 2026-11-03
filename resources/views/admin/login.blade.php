@extends('layouts.auth')

@section('title', 'Sign in')
@section('aside_title', 'Staff portal')

@section('content')
    <h1>Sign in</h1>
    <p class="a-sub">Use the email or username issued to you by the Directorate.</p>

    @if (session('success'))
        <div class="a-alert a-alert--ok" role="status">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="a-alert a-alert--error" role="alert">{{ session('fail') }}</div>
    @endif
    <div class="a-alert a-alert--error" id="loginAlert" role="alert" hidden></div>

    <form id="loginForm" action="{{ route('auth-user-check') }}" method="POST" novalidate>
        @csrf
        <div class="a-field">
            <label for="email">Email or username</label>
            <input class="a-input" type="text" id="email" name="email" value="{{ old('email') }}"
                autocomplete="username" autocapitalize="none" spellcheck="false" autofocus>
            <span class="a-error" id="email-error"></span>
        </div>

        <div class="a-field">
            <label for="password">Password <a href="{{ route('forgot-password') }}">Forgot password?</a></label>
            <div class="a-pass">
                <input class="a-input" type="password" id="password" name="password" autocomplete="current-password">
                <button type="button" data-toggle="#password" data-show="Show" data-hide="Hide"
                    aria-pressed="false">Show</button>
            </div>
            <span class="a-hint" data-caps-for="#password">Caps Lock is on.</span>
            <span class="a-error" id="password-error"></span>
        </div>

        <button type="submit" class="u-btn u-btn--solid a-submit" id="loginBtn">Sign in</button>
    </form>

    <p class="a-links">Not an officer? <a href="{{ url('/') }}">Return to the homepage</a></p>
@endsection

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById('loginForm');
            var btn = document.getElementById('loginBtn');
            var alertBox = document.getElementById('loginAlert');
            var auth = window.umscAuth;

            function busy(on) {
                btn.disabled = on;
                btn.textContent = on ? 'Signing in…' : 'Sign in';
            }

            function showAlert(msg) {
                alertBox.textContent = msg;
                alertBox.hidden = !msg;
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                showAlert('');
                auth.setError('email', '');
                auth.setError('password', '');

                var email = form.email.value.trim();
                var password = form.password.value;
                var bad = false;

                if (!email) {
                    auth.setError('email', 'Enter your email or username.');
                    bad = true;
                } else if (email.indexOf('@') > -1 && !/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                    auth.setError('email', 'That email address does not look right.');
                    bad = true;
                }
                if (!password) {
                    auth.setError('password', 'Enter your password.');
                    bad = true;
                }
                if (bad) {
                    (form.querySelector('.is-invalid') || form.email).focus();
                    return;
                }

                busy(true);
                auth.post(@json(route('auth-user-check')), {
                    email: email,
                    password: password
                }).then(function(res) {
                    var b = res.body || {};
                    if (res.ok && b.status) {
                        btn.textContent = 'Redirecting…';
                        window.location.href = b.redirect_url;
                        return;
                    }
                    if (res.status === 422 && b.errors) {
                        if (b.errors.email) auth.setError('email', b.errors.email[0]);
                        if (b.errors.password) auth.setError('password', b.errors.password[0]);
                    } else if (res.status === 419) {
                        showAlert('Your session expired. Reload the page and try again.');
                    } else {
                        showAlert(b.message || 'We could not sign you in. Please try again.');
                    }
                    busy(false);
                }).catch(function() {
                    showAlert('Could not reach the server. Check your connection and try again.');
                    busy(false);
                });
            });
        })();
    </script>
@endpush
