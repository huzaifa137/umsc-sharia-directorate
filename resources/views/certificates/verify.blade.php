@extends('layouts.public')

@section('title', 'Check a certificate | Directorate of Sharia')

@push('head')
<style>
    .vf { padding: clamp(40px, 8vw, 88px) 0; }
    .vf-card { max-width: 640px; margin: 0 auto; background: #fff; border: 1px solid #dfe5e1; border-radius: 8px; overflow: hidden; }
    .vf-top { padding: 28px 32px; border-inline-start: 6px solid var(--tone, #55635b); }
    .vf-top h1 { margin: 0 0 6px; font: 600 1.6rem/1.2 'Source Serif 4', Georgia, serif; color: var(--tone, #14241b); }
    .vf-top p { margin: 0; color: #4a5a50; line-height: 1.55; }
    .vf-ok { --tone: #136a3b; } .vf-info { --tone: #1f6283; } .vf-bad { --tone: #a8322a; } .vf-warn { --tone: #8a6100; }
    .vf-list { margin: 0; padding: 4px 32px 20px; }
    .vf-list div { display: grid; grid-template-columns: 160px 1fr; gap: 12px; padding: 12px 0; border-top: 1px solid #edf1ef; }
    .vf-list dt { margin: 0; font-size: .85rem; color: #66756c; }
    .vf-list dd { margin: 0; font-weight: 500; color: #14241b; }
    .vf-foot { padding: 18px 32px; background: #f3f5f4; font-size: .88rem; color: #4a5a50; }
    .vf-form { display: flex; flex-wrap: wrap; gap: 10px; padding: 20px 32px 28px; border-top: 1px solid #edf1ef; }
    .vf-form select, .vf-form input { height: 42px; padding: 0 .8rem; border: 1.5px solid #cfd6d2; border-radius: 6px; font: inherit; }
    .vf-form input { flex: 1 1 200px; }
</style>
@endpush

@section('content')
@php
    $label = fn ($t) => ['nikah' => 'Nikah', 'divorce' => 'Divorce', 'inheritance' => 'Inheritance', 'guardianship' => 'Guardianship', 'convert' => 'Convert', 'consultancy' => 'Consultation'][$t] ?? ucfirst($t);

    if (! $result) {
        $tone = 'vf-warn';
        $head = 'No matching certificate';
        $text = $reference
            ? 'No ' . $label($type) . ' certificate with the reference "' . $reference . '" is on record. Check the reference and the type, then try again.'
            : 'No certificate with these details is on record. Do not rely on the document you were given.';
    } elseif (! $result['issued']) {
        $tone = 'vf-bad';
        $head = 'Not issued';
        $text = 'A record exists for this reference, but no certificate has been issued for it. Do not rely on the document you were given.';
    } elseif ($codeGiven && ! $codeMatches) {
        $tone = 'vf-bad';
        $head = 'Code does not match';
        $text = 'The authenticity code on this link is wrong. The document may be altered or forged. Do not rely on it.';
    } elseif ($codeMatches) {
        $tone = 'vf-ok';
        $head = 'Certificate verified';
        $text = 'This certificate was issued by the Directorate of Sharia, Uganda Muslim Supreme Council.';
    } else {
        $tone = 'vf-info';
        $head = 'Certificate on record';
        $text = 'A certificate with this reference is on record. Compare the details below with the paper copy. For full verification, scan the QR code printed on the certificate.';
    }
    $show = $result && $result['issued'] && ! ($codeGiven && ! $codeMatches);
@endphp

<section class="vf">
    <div class="u-wrap">
        <div class="vf-card" role="status">
            <div class="vf-top {{ $tone }}">
                <h1>{{ $head }}</h1>
                <p>{{ $text }}</p>
            </div>

            @if ($show)
                <dl class="vf-list">
                    <div><dt>Type</dt><dd>{{ $result['label'] }}</dd></div>
                    <div><dt>Reference</dt><dd>{{ $result['reference'] }}</dd></div>
                    @if (count($result['parties']))
                        <div><dt>Named on certificate</dt><dd>{{ implode('  and  ', $result['parties']) }}</dd></div>
                    @endif
                    <div><dt>Issued</dt><dd>{{ $result['on']->format('j F Y') }}</dd></div>
                    @if ($result['place'])
                        <div><dt>District</dt><dd>{{ $result['place'] }}</dd></div>
                    @endif
                </dl>
                <div class="vf-foot">Names are partly hidden to protect the people named. The Directorate can confirm full details on request.</div>
            @endif

            <form class="vf-form" method="get" action="{{ route('certificates.verify.lookup') }}">
                <select name="type" aria-label="Certificate type">
                    @foreach (['nikah', 'divorce', 'inheritance', 'guardianship', 'convert', 'consultancy'] as $t)
                        <option value="{{ $t }}" {{ $type === $t ? 'selected' : '' }}>{{ $label($t) }}</option>
                    @endforeach
                </select>
                <input type="text" name="reference" value="{{ $reference }}" placeholder="Reference number" autocomplete="off" aria-label="Reference number">
                <button type="submit" class="u-btn u-btn--solid">Check another</button>
            </form>
        </div>
    </div>
</section>
@endsection
