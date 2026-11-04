@php
    $issuedOn = \App\Services\CertificateVerifier::issuedOn($record);
    $verifyUrl = \App\Services\CertificateVerifier::url($certType, $record->id);
    $verifyCode = \App\Services\CertificateVerifier::code($certType, $record->id);
@endphp
<footer class="cert-foot">
    <div class="cert-sign">
        <div class="cert-sign__space"></div>
        <div class="cert-sign__line">Prof. Dr. Ziyad S. Lubanga</div>
        <div class="cert-sign__role">Director of Sharia, Uganda Muslim Supreme Council</div>
        <div class="cert-sign__ar" lang="ar" dir="rtl">مدير الشريعة</div>
    </div>

    <div class="cert-issue">
        <div>
            <small>Date of issue</small>
            <strong>{{ $issuedOn->format('j F Y') }}</strong>
        </div>
        <div>
            <small>Place of issue</small>
            <strong>{{ $record->officer_district ?? 'Uganda' }}</strong>
        </div>
    </div>

    <div class="cert-verify">
        <div class="cert-verify__text">
            <small>Scan to check this certificate</small>
            <div class="cert-verify__code">{{ $verifyCode }}</div>
        </div>
        <div class="cert-verify__qr" id="qr" data-url="{{ $verifyUrl }}"></div>
    </div>
</footer>
