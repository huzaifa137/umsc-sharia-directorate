{{-- Flows inside the parent .certificate-content box. Seal and title sit
     side-by-side to save vertical space in landscape orientation. --}}

<div class="cert-app-id">
    Cert. Ref: {{ $application->application_id ?? ('UMSC-' . $application->id) }}
</div>

<div class="cert-header-row">
    <div class="cert-seal">
        <img src="{{ asset('assets/img/branding/umsc-seal.png') }}" alt="UMSC Seal">
    </div>
    <div class="cert-title-wrap">
        <div class="cert-dua">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
        <div class="cert-title-en">{{ $titleEn }}</div>
        <div class="cert-title-ar">{{ $titleAr }}</div>
    </div>
</div>
