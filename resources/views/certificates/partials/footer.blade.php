{{-- Exactly one signature block (Director for Sharia) plus a QR code —
     no second generic "Kazi/Imam signature" line, by design. --}}
<div class="cert-footer">
    <div class="sign-block">
        <div class="line">PROF. DR. ZIYAD S. LUBANGA</div>
        <div class="role-en">DIRECTOR OF SHARIA</div>
        <div class="role-ar">مدير الشريعة</div>
    </div>

    <div class="qr-block">
        <div id="qr"></div>
        <div class="caption">Scan to verify</div>
    </div>

    <div class="date-block">
        <div class="row">
            <span class="label">Date of Issue</span>
            <span class="value">{{ \Carbon\Carbon::now()->format('jS F, Y') }}</span>
        </div>
        <div class="row">
            <span class="label">Place</span>
            <span class="value">{{ $application->officer_district ?? 'Uganda' }}</span>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById("qr"), {
        text: {!! json_encode(url('/certificates/verify/' . ($certType ?? 'nikah') . '/' . $application->id)) !!},
        width: 60,
        height: 60,
        colorDark: "#0d4b1e",
        colorLight: "#fdfbf3",
        correctLevel: QRCode.CorrectLevel.H
    });
</script>
