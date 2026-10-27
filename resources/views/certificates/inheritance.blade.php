<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inheritance Certificate — {{ $application->deceased_name ?? '' }}</title>
    @include('certificates.partials.style')
</head>

<body>

    @php
        $certType = 'inheritance';
        $downloadFilename = trim($application->deceased_name ?? 'estate') . '_InheritanceCertificate.pdf';
        $netEstate = ($application->total_estate_value ?? 0)
            - ($application->outstanding_debts ?? 0)
            - ($application->funeral_expenses ?? 0)
            - ($application->unpaid_zakat ?? 0)
            - ($application->other_liabilities ?? 0);
    @endphp

    @include('certificates.partials.actions')

    <div class="certificate">
        <div class="certificate-bg">
            <img src="{{ asset('assets/certificates/gold-border-landscape.png') }}" alt="">
        </div>

        <div class="certificate-content">

            @include('certificates.partials.header', [
                'titleEn' => 'Inheritance Certificate',
                'titleAr' => 'شهادة توزيع الميراث',
            ])

            <div class="cert-quote">
                &ldquo;For men is a share of what the parents and close relatives leave, and for women is a share of
                what the parents and close relatives leave.&rdquo; — Surah An-Nisa (4:7)
            </div>

            <div class="cert-preamble">
                This is to certify that the estate of the late
                <span class="fill">{{ $application->deceased_name }}</span>,
                who passed away on
                <span class="fill">{{ optional($application->date_of_death)->format('jS F, Y') ?? $application->date_of_death }}</span>
                at
                <span class="fill">{{ $application->place_of_death ?? '—' }}</span>,
                has been assessed and distributed among the rightful heirs in accordance with the Islamic law of
                inheritance (Fara'id) —
            </div>

            <div class="cert-parties">
                <div class="party">
                    <div class="details">
                        <div class="col-title">APPLICANT</div>
                        <div class="col-name">{{ $application->applicant_name ?? '—' }}</div>
                        <div class="col-parent">Relationship: <span class="fill">{{ $application->relationship ?? '—' }}</span></div>
                    </div>
                </div>
                <div class="party reverse">
                    <div class="details">
                        <div class="col-title">NET ESTATE (UGX)</div>
                        <div class="col-name">{{ number_format(max($netEstate, 0)) }}</div>
                        <div class="col-parent">Gross: <span class="fill">{{ number_format($application->total_estate_value ?? 0) }}</span></div>
                    </div>
                </div>
            </div>

            <div class="cert-blessing">
                Distributed under the authority of the Directorate of Sharia, Uganda Muslim Supreme Council, in
                accordance with the Fara'id shares prescribed for each heir.
            </div>

            <div class="cert-info-line">
                District of Registration <span class="fill">{{ $application->officer_district ?? '—' }}</span>
                &nbsp;·&nbsp; Application ID <span class="fill">{{ $application->application_id ?? $application->id }}</span>
            </div>

            @include('certificates.partials.footer')
        </div>
    </div>

</body>

</html>
