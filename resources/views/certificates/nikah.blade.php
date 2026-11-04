@extends('certificates.layout')

@php
    $record = $application;
    $certType = 'nikah';
    $titleEn = 'Certificate of Marriage';
    $titleAr = 'شهادة زواج';
    $groom = trim(($application->groom_given_name ?? '') . ' ' . ($application->groom_surname ?? ''));
    $bride = trim(($application->bride_given_name ?? '') . ' ' . ($application->bride_surname ?? ''));
    $downloadFilename = trim(($application->groom_given_name ?? 'groom') . '_' . ($application->bride_given_name ?? 'bride')) . '_NikahCertificate.pdf';
@endphp

@section('body')
    <p class="cert-statement">
        This is to certify that the marriage (Nikah) between the parties named below was solemnised in
        accordance with Islamic Sharia, and has been entered in the register of the Directorate of Sharia of the
        Uganda Muslim Supreme Council.
    </p>

    <div class="cert-parties">
        <div class="cert-party">
            <div class="cert-photo {{ $application->groom_photo_path ? '' : 'is-empty' }}">
                @if ($application->groom_photo_path)
                    <img src="{{ asset('storage/' . $application->groom_photo_path) }}" alt="Groom">
                @endif
            </div>
            <div class="cert-party__text">
                <div class="cert-party__role">Groom</div>
                <div class="cert-party__name">{{ $groom }}</div>
            </div>
        </div>
        <div class="cert-party">
            <div class="cert-photo {{ $application->bride_photo_path ? '' : 'is-empty' }}">
                @if ($application->bride_photo_path)
                    <img src="{{ asset('storage/' . $application->bride_photo_path) }}" alt="Bride">
                @endif
            </div>
            <div class="cert-party__text">
                <div class="cert-party__role">Bride</div>
                <div class="cert-party__name">{{ $bride }}</div>
            </div>
        </div>
    </div>

    <dl class="cert-ledger">
        <div><dt>Masjid</dt><dd>{{ $application->masjid_name ?? 'UMSC Headquarters' }}</dd></div>
        <div><dt>Officiating Imam</dt><dd>{{ $application->imam_name ?? '—' }}</dd></div>
        <div><dt>District</dt><dd>{{ $application->officer_district ?? '—' }}</dd></div>
        <div><dt>Region</dt><dd>{{ $application->officer_region ?? '—' }}</dd></div>
    </dl>
@endsection
