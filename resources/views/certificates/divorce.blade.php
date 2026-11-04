@extends('certificates.layout')

@php
    $record = $application;
    $certType = 'divorce';
    $titleEn = 'Certificate of Divorce';
    $titleAr = 'شهادة طلاق';
    $husband = trim(($application->groom_given_name ?? '') . ' ' . ($application->groom_surname ?? ''));
    $wife = trim(($application->bride_given_name ?? '') . ' ' . ($application->bride_surname ?? ''));
    $downloadFilename = trim(($application->groom_given_name ?? 'husband') . '_' . ($application->bride_given_name ?? 'wife')) . '_DivorceCertificate.pdf';
@endphp

@section('body')
    <p class="cert-statement">
        This is to certify that the husband named below has divorced his wife, in accordance with Islamic Sharia,
        and that the dissolution of the marriage has been entered in the register of the Directorate of Sharia of
        the Uganda Muslim Supreme Council.
    </p>

    <div class="cert-parties">
        <div class="cert-party">
            <div class="cert-photo {{ ($application->groom_photo_path ?? null) ? '' : 'is-empty' }}">
                @if ($application->groom_photo_path ?? null)
                    <img src="{{ asset('storage/' . $application->groom_photo_path) }}" alt="Husband">
                @endif
            </div>
            <div class="cert-party__text">
                <div class="cert-party__role">Husband</div>
                <div class="cert-party__name">{{ $husband }}</div>
            </div>
        </div>
        <div class="cert-party">
            <div class="cert-photo {{ ($application->bride_photo_path ?? null) ? '' : 'is-empty' }}">
                @if ($application->bride_photo_path ?? null)
                    <img src="{{ asset('storage/' . $application->bride_photo_path) }}" alt="Wife">
                @endif
            </div>
            <div class="cert-party__text">
                <div class="cert-party__role">Wife</div>
                <div class="cert-party__name">{{ $wife }}</div>
            </div>
        </div>
    </div>

    <dl class="cert-ledger">
        <div><dt>Place of divorce</dt><dd>{{ $application->divorce_place ?? $application->masjid_name ?? 'UMSC Headquarters' }}</dd></div>
        <div><dt>Officiating Imam</dt><dd>{{ $application->imam_name ?? '—' }}</dd></div>
        <div><dt>District</dt><dd>{{ $application->officer_district ?? '—' }}</dd></div>
        <div><dt>Region</dt><dd>{{ $application->officer_region ?? '—' }}</dd></div>
    </dl>

    <div class="cert-verse">
        <div class="cert-verse__ar" lang="ar" dir="rtl">فَإِنْ طَلَّقَهَا فَلَا تَحِلُّ لَهُ مِنْ بَعْدُ حَتَّىٰ تَنْكِحَ زَوْجًا غَيْرَهُ</div>
        <div class="cert-verse__en">&ldquo;So if he divorces her, she shall not be lawful to him thereafter until she marries another husband.&rdquo; Surah Al-Baqarah 2:230</div>
    </div>
    <p class="cert-dua">May Allah grant them ease, forgiveness and peace in their future.</p>
@endsection
