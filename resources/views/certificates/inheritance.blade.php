@extends('certificates.layout')

@php
    $record = $application;
    $certType = 'inheritance';
    $titleEn = 'Certificate of Inheritance';
    $titleAr = 'شهادة توزيع الميراث';
    $downloadFilename = trim($application->deceased_name ?? 'estate') . '_InheritanceCertificate.pdf';
    $gross = (float) ($application->total_estate_value ?? 0);
    $netEstate = $gross
        - ($application->outstanding_debts ?? 0)
        - ($application->funeral_expenses ?? 0)
        - ($application->unpaid_zakat ?? 0)
        - ($application->other_liabilities ?? 0);
    $diedOn = $application->date_of_death ? \Carbon\Carbon::parse($application->date_of_death)->format('j F Y') : null;
@endphp

@section('body')
    <p class="cert-statement">
        This is to certify that the estate of the person named below has been assessed and distributed among the
        rightful heirs in accordance with the Islamic law of inheritance (Fara&rsquo;id), under the authority of the
        Directorate of Sharia of the Uganda Muslim Supreme Council.
    </p>

    <div class="cert-principal">
        <div class="cert-principal__role">Estate of the late</div>
        <div class="cert-principal__name">{{ $application->deceased_name }}</div>
        @if ($diedOn || $application->place_of_death)
            <div class="cert-principal__alt">
                Passed away
                @if ($diedOn)on <b>{{ $diedOn }}</b>@endif
                @if ($application->place_of_death)at <b>{{ $application->place_of_death }}</b>@endif
            </div>
        @endif
    </div>

    <dl class="cert-ledger">
        <div><dt>Applicant</dt><dd>{{ $application->applicant_name ?? '—' }}</dd></div>
        <div><dt>Relationship</dt><dd>{{ $application->relationship ?? '—' }}</dd></div>
        <div><dt>Gross estate (UGX)</dt><dd>{{ number_format($gross) }}</dd></div>
        <div><dt>Net estate (UGX)</dt><dd><strong>{{ number_format(max($netEstate, 0)) }}</strong></dd></div>
        <div><dt>District</dt><dd>{{ $application->officer_district ?? '—' }}</dd></div>
        <div><dt>Region</dt><dd>{{ $application->officer_region ?? '—' }}</dd></div>
    </dl>

    <p class="cert-epigraph">
        &ldquo;For men is a share of what the parents and close relatives leave, and for women is a share of what the
        parents and close relatives leave.&rdquo; Surah An-Nisa 4:7
    </p>
@endsection
