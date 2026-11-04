<header class="cert-head">
    <div class="cert-org">
        <img src="{{ asset('assets/img/branding/umsc-seal.png') }}" alt="UMSC seal">
        <div>
            <div class="cert-org__name">Uganda Muslim Supreme Council</div>
            <div class="cert-org__sub">Directorate of Sharia</div>
            <div class="cert-org__ar" lang="ar" dir="rtl">مديرية الشريعة</div>
        </div>
    </div>

    <div class="cert-heading">
        <div class="cert-bismillah" lang="ar" dir="rtl">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</div>
        <h1 class="cert-title {{ mb_strlen($titleEn) > 30 ? 'cert-title--long' : '' }}">{{ $titleEn }}</h1>
        <div class="cert-title-ar" lang="ar" dir="rtl">{{ $titleAr }}</div>
    </div>

    <div class="cert-no">
        <div class="cert-no__label">Certificate no.</div>
        <div class="cert-no__value">{{ $certNo }}</div>
    </div>
</header>
<div class="cert-rule" aria-hidden="true"><i></i></div>
