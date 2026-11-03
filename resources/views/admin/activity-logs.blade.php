@extends('layouts.app')

@section('content')
    @php
        $hasFilters = collect($filters)->filter()->isNotEmpty();
        $redact = function ($data) {
            if (!is_array($data)) return [];
            $out = [];
            foreach ($data as $k => $v) {
                $out[$k] = preg_match('/pass|token|secret|nin|otp/i', (string) $k) ? '••••••' : (is_scalar($v) || $v === null ? (string) $v : json_encode($v, JSON_UNESCAPED_UNICODE));
            }
            return $out;
        };
    @endphp

    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Activity log" subtitle="A record of sign-ins, changes and decisions made by officers in your scope."
            :crumbs="['Users' => route('users.dashboard'), 'Activity log' => null]">
            <a class="ui-btn" href="{{ route('activity-logs.export', array_filter($filters)) }}"><i class="bx bx-download"></i> Export CSV</a>
        </x-ui.page-header>

        <x-ui.stats :cols="4">
            <x-ui.stat label="Today" :value="$stats['today']" note="Events recorded" icon="bx-calendar-event" />
            <x-ui.stat label="Active officers" :value="$stats['officers']" note="Last 7 days" icon="bx-user-check" />
            <x-ui.stat label="Failed" :value="$stats['failed']" note="Last 7 days" icon="bx-error-circle" :tone="$stats['failed'] ? 'bad' : null" />
            <x-ui.stat label="Matching" :value="$stats['matching']" :note="$hasFilters ? 'With current filters' : 'All events'" icon="bx-filter-alt" />
        </x-ui.stats>

        <section class="card">
            <form method="GET" action="{{ route('activity-logs.index') }}" class="ui-toolbar" role="search">
                <input type="search" name="q" value="{{ $filters['q'] }}" class="ui-field ui-grow" placeholder="Search officer, action, description or IP address" aria-label="Search the log">
                <select name="action" class="ui-field" style="width:auto;max-width:220px" aria-label="Action">
                    <option value="">Any action</option>
                    @foreach ($actions as $a)<option value="{{ $a }}" @selected($filters['action'] === $a)>{{ $a }}</option>@endforeach
                </select>
                <select name="status" class="ui-field" style="width:auto" aria-label="Result">
                    <option value="">Any result</option>
                    <option value="success" @selected($filters['status'] === 'success')>Success</option>
                    <option value="fail" @selected($filters['status'] === 'fail')>Failed</option>
                </select>
                <input type="date" name="date_from" value="{{ $filters['date_from'] }}" class="ui-field" style="width:auto" aria-label="From date">
                <input type="date" name="date_to" value="{{ $filters['date_to'] }}" class="ui-field" style="width:auto" aria-label="To date">
                <button class="ui-btn ui-btn--primary" type="submit"><i class="bx bx-filter-alt"></i> Apply</button>
                @if ($hasFilters)<a class="ui-btn" href="{{ route('activity-logs.index') }}">Clear</a>@endif
            </form>

            @if ($logs->count())
                <div class="table-responsive">
                    <table class="table adm-table adm-log">
                        <thead>
                            <tr><th style="width:1%"></th><th>When</th><th>Officer</th><th>Action</th><th>What happened</th><th>Result</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                @php
                                    $name = $log->user?->full_name ?: ($log->user_id ? 'User #' . $log->user_id : 'System');
                                    $old = $redact($log->old_values); $new = $redact($log->new_values);
                                    $keys = array_values(array_unique(array_merge(array_keys($old), array_keys($new))));
                                    $hasMore = $keys || $log->user_agent || $log->ip_address || $log->target_type;
                                @endphp
                                <tr data-row="{{ $log->id }}">
                                    <td>@if ($hasMore)<button type="button" class="adm-icon-btn js-expand" aria-expanded="false" aria-controls="log-{{ $log->id }}" aria-label="Show details"><i class="bx bx-chevron-down"></i></button>@endif</td>
                                    <td class="adm-time">{{ $log->created_at->format('d M Y') }}<small>{{ $log->created_at->format('H:i:s') }}</small></td>
                                    <td>
                                        <div class="adm-person"><div><strong>{{ $name }}</strong><span>{{ $log->user_role ?: '—' }}</span></div></div>
                                    </td>
                                    <td><span class="adm-action">{{ $log->action }}</span></td>
                                    <td class="adm-desc">{{ $log->description ?: '—' }}</td>
                                    <td><x-ui.status-badge :status="$log->is_failure ? 'rejected' : 'approved'" :label="$log->is_failure ? 'Failed' : 'Success'" /></td>
                                </tr>
                                @if ($hasMore)
                                    <tr class="adm-detail" id="log-{{ $log->id }}" hidden>
                                        <td colspan="6">
                                            <dl class="adm-kv" style="padding-top:4px">
                                                @if ($log->target_type)<div><dt>Target</dt><dd>{{ $log->target_type }}@if ($log->target_id) <span class="adm-mono">#{{ $log->target_id }}</span>@endif</dd></div>@endif
                                                @if ($log->ip_address)<div><dt>IP address</dt><dd class="adm-mono">{{ $log->ip_address }}</dd></div>@endif
                                                <div><dt>Recorded</dt><dd>{{ $log->created_at->format('d M Y, H:i:s') }}</dd></div>
                                            </dl>
                                            @if ($keys)
                                                <table class="adm-diff">
                                                    <thead><tr><th>Field</th><th>Before</th><th>After</th></tr></thead>
                                                    <tbody>
                                                        @foreach ($keys as $k)
                                                            <tr><td>{{ $k }}</td><td>{{ ($old[$k] ?? '') !== '' ? $old[$k] : '—' }}</td><td>{{ ($new[$k] ?? '') !== '' ? $new[$k] : '—' }}</td></tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                            @if ($log->user_agent)<p class="adm-ua">{{ $log->user_agent }}</p>@endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="adm-foot">
                    <span>Showing {{ number_format($logs->firstItem()) }}–{{ number_format($logs->lastItem()) }} of {{ number_format($logs->total()) }}</span>
                    {{ $logs->links('pagination::bootstrap-5') }}
                </div>
            @else
                <x-ui.empty-state icon="bx-history" title="No activity found" :text="$hasFilters ? 'Nothing matches these filters.' : 'Events will appear here as officers use the system.'">
                    @if ($hasFilters)<a class="ui-btn" href="{{ route('activity-logs.index') }}">Clear filters</a>@endif
                </x-ui.empty-state>
            @endif
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.js-expand').forEach(function (b) {
                b.addEventListener('click', function () {
                    var row = document.getElementById(b.getAttribute('aria-controls'));
                    var open = row.hidden;
                    row.hidden = !open;
                    b.setAttribute('aria-expanded', open ? 'true' : 'false');
                    b.querySelector('i').className = open ? 'bx bx-chevron-up' : 'bx bx-chevron-down';
                    b.closest('tr').classList.toggle('adm-open', open);
                });
            });
        });
    </script>
@endsection
