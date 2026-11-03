@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <x-ui.page-header title="Reports" subtitle="Filter records by status and date, then export a certified report."
            :crumbs="['Dashboard' => route('user.dashboard'), 'Reports' => null]" />

        <section class="card">
            @if (count($rows))
                <div class="table-responsive">
                    <table class="table table-hover adm-table adm-hub">
                        <thead>
                            <tr><th>Report</th><th class="is-num">Records</th><th class="is-num">This month</th><th>Latest record</th><th class="adm-actions"><span class="visually-hidden">Open</span></th></tr>
                        </thead>
                        <tbody>
                            @foreach ($rows as $r)
                                <tr>
                                    <td class="adm-title"><strong>{{ $r['label'] }}</strong><span>{{ $r['title'] }}</span></td>
                                    <td class="is-num">{{ number_format($r['total']) }}</td>
                                    <td class="is-num">{{ number_format($r['month']) }}</td>
                                    <td class="adm-muted">{{ $r['latest'] ? \Illuminate\Support\Carbon::parse($r['latest'])->format('d M Y') : '—' }}</td>
                                    <td class="adm-actions"><a class="ui-btn" href="{{ route('reports.index', $r['slug']) }}">Open report</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-ui.empty-state icon="bx-bar-chart-alt-2" title="No reports available" text="Your role does not include access to any module reports." />
            @endif
        </section>
    </div>
@endsection
