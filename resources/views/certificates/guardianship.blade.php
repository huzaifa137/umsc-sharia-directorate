@extends('certificates.layout')

@php
    $record = $application;
    $certType = 'guardianship';
    $titleEn = 'Certificate of Guardianship';
    $titleAr = 'شهادة وصاية';
    $downloadFilename = trim($application->ward_name ?? 'ward') . '_GuardianshipCertificate.pdf';
    $appointedOn = $application->guardianship_date ?? $application->created_at ?? null;
@endphp

@section('body')
    <p class="cert-statement">
        This is to certify that the guardian named below has been appointed the lawful guardian of the ward named
        below, to care for, nurture, protect and act in the best interest of the ward in accordance with Islamic
        teachings and the laws of Uganda.
    </p>

    <div class="cert-parties cert-parties--plain">
        <div class="cert-party">
            <div class="cert-party__role">Guardian</div>
            <div class="cert-party__name">{{ $application->guardian_name ?? '' }}</div>
        </div>
        <div class="cert-party">
            <div class="cert-party__role">Ward</div>
            <div class="cert-party__name">{{ $application->ward_name ?? '' }}</div>
        </div>
    </div>

    <dl class="cert-ledger">
        <div><dt>Date of appointment</dt><dd>{{ $appointedOn ? \Carbon\Carbon::parse($appointedOn)->format('j F Y') : '—' }}</dd></div>
        <div><dt>District</dt><dd>{{ $application->officer_district ?? '—' }}</dd></div>
    </dl>

    <div class="cert-verse">
        <div class="cert-verse__ar" lang="ar" dir="rtl">وَاتَّقُوا اللَّهَ وَاعْلَمُوا أَنَّ اللَّهَ بِكُلِّ شَيْءٍ عَلِيمٌ</div>
        <div class="cert-verse__en">&ldquo;And fear Allah and know that Allah is All-Aware of everything.&rdquo; Surah Al-Baqarah 2:282</div>
    </div>
    <p class="cert-dua">
        The Prophet <span style="font-family: var(--c-arabic);">ﷺ</span> said: &ldquo;Each of you is a shepherd and
        each of you is responsible for his flock.&rdquo; Sahih al-Bukhari 893. May Allah grant the guardian wisdom,
        patience and strength to fulfil this trust with justice, kindness and Taqwa.
    </p>
@endsection
