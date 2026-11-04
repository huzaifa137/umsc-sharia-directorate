@extends('certificates.layout')

@php
    $record = $application;
    $certType = 'convert';
    $titleEn = 'Certificate of Acceptance of Islam';
    $titleAr = 'شهادة اعتناق الإسلام';
    $newName = $application->new_names ?? $application->former_names ?? '';
    $downloadFilename = trim($newName ?: 'convert') . '_ConvertCertificate.pdf';
    $gender = $application->gender ?? null;
    $pronoun = $gender === 'female' ? 'her' : ($gender === 'male' ? 'him' : 'them');
    $onDate = $application->conversion_date ?? $application->created_at ?? null;
@endphp

@section('body')
    <div class="cert-verse">
        <div class="cert-verse__ar" lang="ar" dir="rtl">وَمَن يَبْتَغِ غَيْرَ الْإِسْلَامِ دِينًا</div>
        <div class="cert-verse__en">&ldquo;And whoever seeks a religion other than Islam, it will never be accepted from him, and he will be in the Hereafter among the losers.&rdquo; Surah Al-Imran 3:85</div>
    </div>

    <div class="cert-principal">
        <div class="cert-principal__role">This is to certify that</div>
        <div class="cert-principal__name">{{ $newName }}</div>
        @if (!empty($application->former_names) && $application->former_names !== $newName)
            <div class="cert-principal__alt">Formerly <b>{{ $application->former_names }}</b></div>
        @endif
    </div>

    <p class="cert-statement">
        has sincerely embraced Islam and has been accepted into the Ummah of Prophet Muhammad
        <span style="font-family: var(--c-arabic);">ﷺ</span>, and the Directorate of Sharia of the Uganda Muslim
        Supreme Council has entered this in its register.
    </p>

    <dl class="cert-ledger">
        <div><dt>Date</dt><dd>{{ $onDate ? \Carbon\Carbon::parse($onDate)->format('j F Y') : '—' }}</dd></div>
        <div><dt>Place</dt><dd>{{ $application->conversion_place ?? $application->mosque_location ?? 'Kampala, Uganda' }}</dd></div>
        <div><dt>Mosque</dt><dd>{{ $application->mosque_name ?? 'Gaddafi National Mosque' }}</dd></div>
        <div><dt>District</dt><dd>{{ $application->officer_district ?? '—' }}</dd></div>
    </dl>

    <p class="cert-dua">
        May Allah <span style="font-family: var(--c-arabic);">ﷻ</span> strengthen {{ $pronoun }} in faith, grant
        {{ $pronoun }} knowledge and righteous deeds, and make {{ $pronoun }} a source of goodness in this world
        and the Hereafter. Ameen.
    </p>
@endsection
