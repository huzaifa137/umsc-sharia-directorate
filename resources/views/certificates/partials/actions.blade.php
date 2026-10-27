<div class="no-print" style="width: 287mm; margin: 10px auto; text-align: right;">
    <button id="downloadCertificateBtn"
        style="padding: 10px 22px; background: #0d4b1e; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
        <i class="bi bi-download"></i> Download Certificate PDF
    </button>
</div>

<div id="pageLoader" class="d-none no-print">
    <div class="loader-box">
        <div class="spinner"></div>
        <p class="loader-main-text">Processing your certificate</p>
        <p class="loader-sub-text">Please do not refresh the page</p>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .d-none { display: none !important; }

    #pageLoader {
        position: fixed;
        inset: 0;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loader-box {
        background: #fff;
        padding: 36px;
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        text-align: center;
        min-width: 240px;
    }

    .spinner {
        width: 46px;
        height: 46px;
        border: 3px solid #f0f0f0;
        border-top: 3px solid #0d4b1e;
        border-radius: 50%;
        animation: cert-spin 1s linear infinite;
        margin: 0 auto 16px;
    }

    @keyframes cert-spin { to { transform: rotate(360deg); } }

    .loader-main-text { color: #0d4b1e; font-weight: 600; margin: 0; }
    .loader-sub-text { color: #8a8a8a; font-size: 0.85rem; margin-top: 6px; }
</style>

<script>
    (function () {
        const downloadBtn = document.getElementById('downloadCertificateBtn');
        const loader = document.getElementById('pageLoader');
        if (!downloadBtn) return;

        downloadBtn.addEventListener('click', () => {
            loader.classList.remove('d-none');
            downloadBtn.disabled = true;

            const element = document.querySelector('.certificate');

            const opt = {
                margin: 0,
                filename: {!! json_encode($downloadFilename ?? 'certificate.pdf') !!},
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                loader.classList.add('d-none');
                downloadBtn.disabled = false;
            }).catch(() => {
                loader.classList.add('d-none');
                downloadBtn.disabled = false;
                alert('An error occurred while generating the PDF.');
            });
        });
    })();
</script>
