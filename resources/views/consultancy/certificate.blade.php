@extends('certificates.layout')

@php
    $record = $consultancy;
    $certType = 'consultancy';
    $orientation = 'portrait';
    $titleEn = 'Certificate of Consultation';
    $titleAr = 'شهادة استشارة';
    $downloadFilename = trim($consultancy->applicant_name ?? 'consultation') . '_ConsultationCertificate.pdf';
@endphp

@section('body')
    <div class="cert-verse">
        <div class="cert-verse__ar" lang="ar" dir="rtl">فَسْأَلُوا أَهْلَ الذِّكْرِ إِن كُنتُمْ لَا تَعْلَمُونَ</div>
        <div class="cert-verse__en">&ldquo;So ask the people of remembrance if you do not know.&rdquo; Surah An-Nahl 16:43</div>
    </div>

    <p class="cert-statement">
        This is to certify that <b>{{ $consultancy->applicant_name }}</b> appeared before the Directorate of Sharia
        of the Uganda Muslim Supreme Council and formally sought Islamic guidance on a matter of
        <b>{{ $consultancy->consultation_type_label }}</b>. Following a careful review of the circumstances, the
        relevant rulings of the Qur&rsquo;an, the authentic Sunnah of Prophet Muhammad
        <span style="font-family: var(--c-arabic);">ﷺ</span> and the opinions of recognised jurists were considered,
        and the guidance below was given.
    </p>

    <dl class="cert-ledger cert-ledger--one" style="max-width: none;">
        <div><dt>Matter presented</dt><dd>{{ $consultancy->subject ?? $consultancy->consultation_type_label }}</dd></div>
        <div><dt>Decision</dt><dd><strong>Approved</strong> <small>The Directorate confirms the consultation is in accordance with Islamic teaching.</small></dd></div>
    </dl>

    @if ($consultancy->islamic_guidance)
        <section class="cert-section">
            <h3>Islamic guidance</h3>
            <p>{{ $consultancy->islamic_guidance }}</p>
        </section>
    @endif

    @if ($consultancy->recommendation)
        <section class="cert-section">
            <h3>Recommendation</h3>
            <p>{{ $consultancy->recommendation }}</p>
        </section>
    @endif

    @if ($consultancy->conditions || $consultancy->restrictions)
        <section class="cert-section">
            @if ($consultancy->conditions)
                <h3>Conditions</h3>
                <p>{{ $consultancy->conditions }}</p>
            @endif
            @if ($consultancy->restrictions)
                <h3 style="margin-top: 3mm;">Restrictions</h3>
                <p>{{ $consultancy->restrictions }}</p>
            @endif
        </section>
    @endif

    @if ($consultancy->quran_reference || $consultancy->hadith_reference || $consultancy->scholar_reference)
        <section class="cert-section">
            <h3>References</h3>
            <ul class="cert-refs">
                @if ($consultancy->quran_reference)<li><b>Qur&rsquo;an</b>{{ $consultancy->quran_reference }}</li>@endif
                @if ($consultancy->hadith_reference)<li><b>Hadith</b>{{ $consultancy->hadith_reference }}</li>@endif
                @if ($consultancy->scholar_reference)<li><b>Scholar</b>{{ $consultancy->scholar_reference }}</li>@endif
            </ul>
        </section>
    @endif
@endsection
