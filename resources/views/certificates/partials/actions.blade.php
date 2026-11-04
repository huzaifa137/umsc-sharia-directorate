{{-- Screen-only toolbar. Hidden when printing and inside the bulk-print frame. --}}
<div class="cert-toolbar" role="toolbar" aria-label="Certificate actions">
    <button type="button" class="cert-toolbar__back" id="certBack">
        <span aria-hidden="true">&larr;</span> Back
    </button>
    <div class="cert-toolbar__title">
        {{ $titleEn }}
        <small>{{ $certNo }}. Printing and PDF use the exact A4 page shown below.</small>
    </div>
    <div class="cert-toolbar__actions">
        <button type="button" class="cert-btn" id="certPrint">Print</button>
        <button type="button" class="cert-btn cert-btn--primary" id="certDownload">Download PDF</button>
    </div>
</div>

<div class="cert-loader" id="certLoader" role="status" aria-live="polite">
    <div class="cert-loader__card">
        Preparing your PDF
        <small>This takes a few seconds. Please keep this page open.</small>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
