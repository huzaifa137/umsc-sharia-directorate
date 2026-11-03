@extends('layouts.auth')

@section('title', 'Choose a new password')
@section('aside_title', 'Almost done')
@section('aside_text', 'Choose a new password for your account. Once saved, the reset link stops working.')

@section('content')
    <h1>Choose a new password</h1>
    <p class="a-sub">Make it something you do not use anywhere else.</p>

    @if (session('success'))
        <div class="a-alert a-alert--ok" role="status">{{ session('success') }}</div>
    @endif
    @if (session('fail'))
        <div class="a-alert a-alert--error" role="alert">{{ session('fail') }}</div>
    @endif

    <form id="resetForm" action="{{ url('user-store-new-password') }}" method="POST" novalidate>
        @csrf
        <input type="hidden" name="generated_id" value="{{ $generated_id }}">

        <div class="a-field">
            <label for="password">New password</label>
            <div class="a-pass">
                <input class="a-input @error('password') is-invalid @enderror" type="password" id="password"
                    name="password" autocomplete="new-password" autofocus>
                <button type="button" data-toggle="#password" data-show="Show" data-hide="Hide"
                    aria-pressed="false">Show</button>
            </div>
            <span class="a-hint" data-caps-for="#password">Caps Lock is on.</span>
            <span class="a-error" id="password-error">@error('password'){{ $message }}@enderror</span>
        </div>

        <div class="a-field">
            <label for="password_confirmation">Confirm new password</label>
            <div class="a-pass">
                <input class="a-input @error('password_confirmation') is-invalid @enderror" type="password"
                    id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                <button type="button" data-toggle="#password_confirmation" data-show="Show" data-hide="Hide"
                    aria-pressed="false">Show</button>
            </div>
            <span class="a-error" id="password_confirmation-error">@error('password_confirmation'){{ $message }}@enderror</span>
        </div>

        <ul class="a-rules" data-for="#password" data-confirm="#password_confirmation">
            <li data-rule="min6">At least 6 characters</li>
            <li data-rule="upper">An uppercase letter</li>
            <li data-rule="lower">A lowercase letter</li>
            <li data-rule="digit">A number</li>
            <li data-rule="special">One of @ $ ! % * ? &amp; #</li>
            <li data-rule="match">Both entries match</li>
        </ul>

        <button type="submit" class="u-btn u-btn--solid a-submit" id="resetBtn">Save new password</button>
    </form>

    <p class="a-links"><a href="{{ url('/users/login') }}">&larr; Back to sign in</a></p>
@endsection

@push('scripts')
    <script>
        (function() {
            var form = document.getElementById('resetForm');
            var btn = document.getElementById('resetBtn');
            var auth = window.umscAuth;
            form.addEventListener('submit', function(e) {
                var p = form.password.value;
                var c = form.password_confirmation.value;
                auth.setError('password', '');
                auth.setError('password_confirmation', '');
                var bad = false;
                if (p.length < 6 || !/[A-Z]/.test(p) || !/[a-z]/.test(p) || !/[0-9]/.test(p) || !/[@$!%*?&#]/.test(p)) {
                    auth.setError('password', 'The password does not meet all the requirements below.');
                    bad = true;
                }
                if (p !== c) {
                    auth.setError('password_confirmation', 'The two passwords do not match.');
                    bad = true;
                }
                if (bad) {
                    e.preventDefault();
                    (form.querySelector('.is-invalid') || form.password).focus();
                    return;
                }
                btn.disabled = true;
                btn.textContent = 'Saving…';
            });
        })();
    </script>
@endpush
