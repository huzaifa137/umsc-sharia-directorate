@extends('layouts.auth')

@section('title', 'Forgot password')
@section('aside_title', 'Locked out?')
@section('aside_text', 'We will email a reset link to the address registered on your account. The link can be used once.')

@section('content')
    <h1>Reset your password</h1>
    <p class="a-sub">Enter the email address registered on your account and we will send you a link.</p>

    @if (session('success'))
        <div class="a-alert a-alert--ok" role="status">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="a-alert a-alert--error" role="alert">{{ session('fail') }}</div>
    @endif

    <form id="forgotForm" action="{{ url('user-generate-forgot-password-link') }}" method="POST" novalidate>
        @csrf
        <div class="a-field">
            <label for="email">Email address</label>
            <input class="a-input @error('email') is-invalid @enderror" type="email" id="email" name="email"
                value="{{ old('email') }}" autocomplete="email" autofocus>
            <span class="a-error" id="email-error">@error('email'){{ $message }}@enderror</span>
        </div>

        <button type="submit" class="u-btn u-btn--solid a-submit" id="forgotBtn">Send reset link</button>
    </form>

    <p class="a-links"><a href="{{ url('/users/login') }}">&larr; Back to sign in</a></p>
@endsection

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById('forgotForm');
            var btn = document.getElementById('forgotBtn');
            form.addEventListener('submit', function(e) {
                var v = form.email.value.trim();
                window.umscAuth.setError('email', '');
                if (!v) {
                    e.preventDefault();
                    window.umscAuth.setError('email', 'Enter your email address.');
                    form.email.focus();
                    return;
                }
                btn.disabled = true;
                btn.textContent = 'Sending…';
            });
        })();
    </script>
@endpush
