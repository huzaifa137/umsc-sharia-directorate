@extends('layouts.app')

@section('content')
@php
    $badgeStatus = $status['pending'] ? 'pending' : $status['key'];
@endphp

<link rel="stylesheet" href="{{ asset('css/umsc-records.css') }}">

<div class="container-xxl flex-grow-1 container-p-y rec"
     id="rec"
     data-endpoint="{{ $status['endpoint'] }}"
     data-reference="{{ $case['reference'] }}">

    <x-ui.page-header :title="$title"
        :subtitle="$def['noun'] . ' · ' . $case['reference']"
        :crumbs="['Dashboard' => url('/dashboard'), $def['label'] => $urls['dashboard'], $case['reference'] => null]">
        <a href="{{ $urls['list'] }}" class="ui-btn"><i class="bx bx-list-ul"></i> {{ $def['label'] }} list</a>
        @if ($urls['edit'])
            <a href="{{ $urls['edit'] }}" class="ui-btn"><i class="bx bx-edit-alt"></i> Edit</a>
        @endif
        <button type="button" class="ui-btn" data-rec-print><i class="bx bx-printer"></i> Print</button>
        @if ($urls['certificate'])
            <a href="{{ $urls['certificate'] }}" target="_blank" rel="noopener" class="ui-btn ui-btn--primary"><i class="bx bx-certification"></i> Certificate</a>
        @endif
    </x-ui.page-header>

    {{-- Record strip: the five things an officer looks for first --}}
    <dl class="rec-strip">
        <div>
            <dt>Reference</dt>
            <dd>
                <span class="rec-ref">{{ $case['reference'] }}</span>
                <button type="button" class="rec-link" data-rec-copy title="Copy reference">Copy</button>
            </dd>
        </div>
        <div>
            <dt>Status</dt>
            <dd><x-ui.status-badge :status="$badgeStatus" :label="$status['label']" /></dd>
        </div>
        @foreach (array_slice($facts, 0, 3) as [$label, $value])
            <div>
                <dt>{{ $label }}</dt>
                <dd>{{ $value }}</dd>
            </div>
        @endforeach
        <div>
            <dt>Lodged</dt>
            <dd>{{ $case['lodged'] ?? '—' }}</dd>
        </div>
    </dl>

    <div class="rec-layout">

        {{-- Contents --}}
        <nav class="rec-index" aria-label="Sections">
            <p class="rec-index__title">On this page</p>
            <ol>
                @foreach ($sections as $s)
                    <li><a href="#sec-{{ $s['id'] }}" data-rec-nav="sec-{{ $s['id'] }}">{{ $s['title'] }}</a></li>
                @endforeach
                @if (count($files))
                    <li><a href="#sec-documents" data-rec-nav="sec-documents">Documents</a></li>
                @endif
            </ol>
        </nav>

        {{-- The record --}}
        <div class="rec-main">
            @foreach ($sections as $s)
                <section class="rec-sec" id="sec-{{ $s['id'] }}">
                    <header class="rec-sec__head">
                        <h2>{{ $s['title'] }}</h2>
                        @if ($s['type'] !== 'table' && $s['total'])
                            <span class="rec-count" title="Fields completed">{{ $s['filled'] }} of {{ $s['total'] }}</span>
                        @elseif ($s['type'] === 'table' && $s['table'])
                            <span class="rec-count">{{ $s['table']['count'] }} {{ \Illuminate\Support\Str::plural('item', $s['table']['count']) }}</span>
                        @endif
                    </header>

                    @if ($s['type'] === 'table')
                        @if ($s['table'] && $s['table']['count'])
                            <div class="rec-tablewrap">
                                <table class="rec-table">
                                    <thead>
                                        <tr>@foreach ($s['table']['head'] as $h)<th>{{ $h }}</th>@endforeach</tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($s['table']['body'] as $row)
                                            <tr>@foreach ($row as $cell)<td>{{ $cell ?? '—' }}</td>@endforeach</tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="rec-none">Nothing has been recorded here.</p>
                        @endif

                    @elseif ($s['type'] === 'groups')
                        <div class="rec-groups">
                            @foreach ($s['groups'] as $g)
                                <div class="rec-group">
                                    <h3>{{ $g['label'] }}</h3>
                                    @include('records.partials.rows', ['rows' => $g['rows'], 'single' => true])
                                </div>
                            @endforeach
                        </div>

                    @else
                        @if (count($s['rows']))
                            @include('records.partials.rows', ['rows' => $s['rows'], 'single' => false])
                        @else
                            <p class="rec-none">Nothing has been recorded here.</p>
                        @endif
                    @endif
                </section>
            @endforeach

            @if (count($files))
                <section class="rec-sec" id="sec-documents">
                    <header class="rec-sec__head"><h2>Documents</h2><span class="rec-count">{{ count($files) }}</span></header>
                    <div class="rec-files">
                        @foreach ($files as $f)
                            @if ($f['kind'] === 'image')
                                <figure class="rec-photo">
                                    @if ($f['exists'])
                                        <a href="{{ $f['url'] }}" target="_blank" rel="noopener">
                                            <img src="{{ $f['url'] }}" alt="{{ $f['label'] }}" loading="lazy">
                                        </a>
                                    @else
                                        <div class="rec-photo__missing">File not found in storage</div>
                                    @endif
                                    <figcaption>{{ $f['label'] }}</figcaption>
                                </figure>
                            @else
                                <a class="rec-doc {{ $f['exists'] ? '' : 'is-missing' }}" href="{{ $f['exists'] ? $f['url'] : '#' }}" @if ($f['exists']) target="_blank" rel="noopener" @endif>
                                    <i class="bx bx-file"></i>
                                    <span>
                                        <strong>{{ $f['label'] }}</strong>
                                        <small>{{ $f['exists'] ? ($f['ext'] ?: 'File') . ' · ' . $f['name'] : 'File not found in storage' }}</small>
                                    </span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        {{-- Rail --}}
        <aside class="rec-rail">

            @if ($can['decide'])
                <section class="rec-panel">
                    <h2 class="rec-panel__title">Decision</h2>
                    @if ($status['pending'])
                        <p class="rec-panel__text">
                            This record is waiting for a decision@if ($case['waiting'] !== null && $case['waiting'] > 0), lodged {{ $case['waiting'] }} {{ \Illuminate\Support\Str::plural('day', $case['waiting']) }} ago @endif.
                        </p>
                    @else
                        <p class="rec-panel__text">Current status: <strong>{{ $status['label'] }}</strong>. You can change it if a decision needs correcting.</p>
                    @endif
                    <div class="rec-decide">
                        @foreach ($status['offer'] as $o)
                            <button type="button" class="rec-decide__btn rec-decide__btn--{{ $o['tone'] }}"
                                    data-rec-status="{{ $o['value'] }}" data-label="{{ $o['label'] }}">
                                {{ $o['label'] }}
                            </button>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="rec-panel">
                <h2 class="rec-panel__title">Case file</h2>
                <dl class="rec-meta">
                    <div><dt>Reference</dt><dd>{{ $case['reference'] }}</dd></div>
                    <div><dt>Lodged by</dt><dd>{{ $case['by'] ?: '—' }}</dd></div>
                    <div><dt>Lodged</dt><dd>{{ $case['lodged'] ?? '—' }}</dd></div>
                    @if ($case['updated'])<div><dt>Last updated</dt><dd>{{ $case['updated'] }}</dd></div>@endif
                    <div><dt>Region</dt><dd>{{ $case['region'] ?: '—' }}</dd></div>
                    <div><dt>District</dt><dd>{{ $case['district'] ?: '—' }}</dd></div>
                    <div><dt>County</dt><dd>{{ $case['county'] ?: '—' }}</dd></div>
                </dl>
                <div class="rec-complete" role="img" aria-label="{{ $completeness['pct'] }} percent of fields completed">
                    <div class="rec-complete__bar"><span style="width: {{ $completeness['pct'] }}%"></span></div>
                    <p>{{ $completeness['filled'] }} of {{ $completeness['total'] }} fields completed</p>
                </div>
            </section>

            <section class="rec-panel">
                <h2 class="rec-panel__title">History</h2>
                <ol class="rec-timeline">
                    @foreach ($timeline as $e)
                        <li class="rec-timeline__item rec-timeline__item--{{ $e['tone'] }}">
                            <p class="rec-timeline__title">{{ $e['title'] }}</p>
                            @if (!empty($e['text']))<p class="rec-timeline__text">{{ $e['text'] }}</p>@endif
                            @if ($e['when'])<time class="rec-timeline__when" title="{{ $e['when'] }}">{{ $e['ago'] }}</time>@endif
                        </li>
                    @endforeach
                </ol>
            </section>
        </aside>
    </div>
</div>

<script src="{{ asset('js/umsc-records.js') }}" defer></script>
@endsection
