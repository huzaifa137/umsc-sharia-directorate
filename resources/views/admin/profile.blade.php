@extends('layouts.app')

@section('content')
@php
    // $admin is the raw users row (kept for backward compatibility); $profile is the prepared view data.
    [$statusLabel, $statusTone] = \App\Services\ProfileData::status($admin->account_status ?? null);
    $canLogs = \App\Services\AccessControl::can('activity_logs.view');
    $fmt = fn ($d) => $d ? $d->format('j M Y, g:i A') : null;
    $details = [
        ['Full name', trim(($admin->firstname ?? '') . ' ' . ($admin->lastname ?? '')) ?: ($profile['name'] ?? '—')],
        ['Username', $admin->username ?? '—'],
        ['Email', $admin->email ?? '—'],
        ['Phone', $admin->phonenumber ?? '—'],
        ['Gender', $admin->gender ? ucfirst($admin->gender) : 'Not specified'],
        ['Country', $admin->country ?? '—'],
    ];
@endphp

<link rel="stylesheet" href="{{ asset('css/umsc-profile.css') }}">

<div class="container-xxl flex-grow-1 container-p-y prf">

    <x-ui.page-header title="My profile"
        subtitle="Your account, the area you work in, and your sign-in security."
        :crumbs="['Dashboard' => url('/users/dashboard'), 'My profile' => null]" />

    @if (!($profile['available'] ?? false))
        <div class="card"><x-ui.empty-state icon="bx-user-x" title="Profile unavailable"
            text="We could not load your account. Sign out and sign in again." /></div>
    @else
        <div class="prf-layout">

            {{-- Identity --}}
            <aside class="prf-id card" aria-label="Account summary">
                <div class="prf-avatar" aria-hidden="true">{{ $profile['initial'] }}</div>
                <h2 class="prf-name">{{ $profile['name'] }}</h2>
                <p class="prf-role">{{ $profile['role'] }}</p>
                <span class="ui-status ui-status--{{ $statusTone }}">{{ $statusLabel }}</span>

                <dl class="prf-facts">
                    <div><dt>Sees</dt><dd>{{ $profile['scope'] }}</dd></div>
                    @if ($profile['jurisdiction'])
                        <div><dt>Jurisdiction</dt><dd>{{ $profile['jurisdiction'] }}</dd></div>
                    @endif
                    @if ($profile['mosque'])
                        <div><dt>Mosque</dt><dd>{{ $profile['mosque'] }}</dd></div>
                    @endif
                    <div><dt>Last sign-in</dt><dd>{{ $fmt($profile['last_login']) ?? 'This is your first session' }}</dd></div>
                    @if ($profile['member_since'])
                        <div><dt>Account created</dt><dd>{{ $profile['member_since']->format('j M Y') }}</dd></div>
                    @endif
                    @if ($profile['actions_30'] !== null)
                        <div><dt>Actions, last 30 days</dt><dd>{{ number_format($profile['actions_30']) }}</dd></div>
                    @endif
                </dl>
            </aside>

            <div class="prf-main">

                {{-- Details --}}
                <section class="card" aria-labelledby="prf-details">
                    <header class="card-header"><h2 id="prf-details" class="prf-h">Account details</h2></header>
                    <dl class="prf-dl">
                        @foreach ($details as [$label, $value])
                            <div><dt>{{ $label }}</dt><dd>{{ $value }}</dd></div>
                        @endforeach
                    </dl>
                    <p class="prf-note"><i class="bx bx-info-circle" aria-hidden="true"></i>
                        To correct these details, ask the person who manages your account (your District Khadhi or the Directorate).</p>
                </section>

                {{-- Password --}}
                <section class="card" id="security" aria-labelledby="prf-security">
                    <header class="card-header">
                        <h2 id="prf-security" class="prf-h">Password</h2>
                    </header>

                    @if ($profile['must_change'])
                        <div class="prf-callout" role="status">
                            <i class="bx bx-error-circle" aria-hidden="true"></i>
                            <span>Your password was issued to you. Choose your own now so only you know it.</span>
                        </div>
                    @endif

                    <form id="prfPassForm" class="prf-form" novalidate
                        data-url="{{ route('admin.change.password') }}"
                        data-must-change="{{ $profile['must_change'] ? '1' : '0' }}"
                        data-dashboard="{{ url('/users/dashboard') }}">
                        @csrf
                        <div class="prf-form__fields">
                            <div class="ui-field">
                                <label for="newPassword">New password</label>
                                <div class="prf-pw">
                                    <input type="password" class="form-control" id="newPassword" name="newPassword"
                                        autocomplete="new-password" aria-describedby="prfRules newPasswordErr" required>
                                    <button type="button" class="prf-pw__toggle" data-toggle-pw="newPassword"
                                        aria-label="Show password" aria-pressed="false"><i class="bx bx-show" aria-hidden="true"></i></button>
                                </div>
                                <p class="ui-err" id="newPasswordErr" role="alert" hidden></p>
                            </div>
                            <div class="ui-field">
                                <label for="confirmPassword">Confirm new password</label>
                                <div class="prf-pw">
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                        autocomplete="new-password" aria-describedby="confirmPasswordErr" required>
                                    <button type="button" class="prf-pw__toggle" data-toggle-pw="confirmPassword"
                                        aria-label="Show password" aria-pressed="false"><i class="bx bx-show" aria-hidden="true"></i></button>
                                </div>
                                <p class="ui-err" id="confirmPasswordErr" role="alert" hidden></p>
                            </div>
                        </div>

                        <ul class="prf-rules" id="prfRules" aria-label="Password requirements">
                            <li data-rule="len">At least 8 characters</li>
                            <li data-rule="upper">One uppercase letter</li>
                            <li data-rule="sym">One symbol, for example ! @ # $</li>
                            <li data-rule="match">Both entries match</li>
                        </ul>

                        <div class="prf-form__foot">
                            <button type="submit" class="ui-btn ui-btn--primary" id="prfPassBtn" disabled>
                                <i class="bx bx-key" aria-hidden="true"></i> Update password
                            </button>
                        </div>
                    </form>
                </section>

                {{-- Activity --}}
                <section class="card" aria-labelledby="prf-activity">
                    <header class="card-header prf-head-row">
                        <h2 id="prf-activity" class="prf-h">Your recent activity</h2>
                        @if ($canLogs)
                            <a class="ui-link" href="{{ route('activity-logs.index') }}">Full activity log</a>
                        @endif
                    </header>

                    @forelse ($profile['recent'] as $log)
                        @if ($loop->first)<ol class="prf-feed">@endif
                        <li>
                            <span class="ui-dot {{ $log->is_failure ? 'ui-dot--bad' : 'ui-dot--ok' }}" aria-hidden="true"></span>
                            <div>
                                <strong>{{ $log->action }}</strong>
                                @if ($log->description)<span class="prf-feed__desc">{{ \Illuminate\Support\Str::limit($log->description, 110) }}</span>@endif
                            </div>
                            <time datetime="{{ $log->created_at->toIso8601String() }}" title="{{ $log->created_at->format('j M Y, g:i A') }}">{{ $log->created_at->diffForHumans() }}</time>
                        </li>
                        @if ($loop->last)</ol>@endif
                    @empty
                        <x-ui.empty-state icon="bx-history" title="No activity yet"
                            text="Actions you take in the system, such as approving a record or changing a password, are listed here." />
                    @endforelse
                </section>
            </div>
        </div>
    @endif
</div>

<script src="{{ asset('js/umsc-profile.js') }}" defer></script>
@endsection
