@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow-lg border-0">
            <div class="card-header text-white" style="background:#0d4b1e;">
                <h5 class="mb-0"><i class="bx bx-printer me-2"></i> Bulk Print — {{ $label }}</h5>
            </div>
            <div class="card-body text-center">
                <p class="mb-3">Merging <strong>{{ $applications->count() }}</strong> certificate(s) into a single PDF…</p>

                <button id="startMergeBtn" class="btn px-5" style="background:#0d4b1e;color:#fff;">
                    <i class="bx bx-play-circle me-1"></i> Start
                </button>

                <div id="progressWrapper" style="display:none; margin-top: 20px; max-width: 600px; margin-inline: auto;">
                    <div style="font-weight:bold; margin-bottom:6px;">
                        <span id="progressText">Preparing...</span>
                    </div>
                    <div style="background:#e9ecef; border-radius:8px; height:22px; width:100%;">
                        <div id="progressBar"
                            style="background:#0d4b1e; height:100%; width:0%; border-radius:8px; transition:width 0.3s ease; text-align:center; color:white; font-size:13px; line-height:22px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf-lib/1.17.1/pdf-lib.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        const RECORD_IDS = @json($applications->pluck('id')->values());
        const CERT_TYPE = {!! json_encode($type) !!};

        document.getElementById('startMergeBtn').addEventListener('click', async function () {
            const btn = this;
            const progressWrapper = document.getElementById('progressWrapper');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const total = RECORD_IDS.length;

            btn.disabled = true;
            btn.innerHTML = '<i class="bx bx-loader-alt bx-spin me-1"></i> Generating...';
            progressWrapper.style.display = 'block';

            const { PDFDocument } = PDFLib;
            const mergedPdf = await PDFDocument.create();

            for (let i = 0; i < total; i++) {
                const id = RECORD_IDS[i];
                const percent = Math.round((i / total) * 100);

                progressText.textContent = `Generating ${i + 1} of ${total}...`;
                progressBar.style.width = percent + '%';
                progressBar.textContent = percent + '%';

                await new Promise((resolve) => {
                    const iframe = document.createElement('iframe');
                    // A4 landscape at 96dpi ≈ 1123 x 794 px, matching the certificate's 297mm x 210mm.
                    iframe.style.cssText = 'position:fixed;left:-9999px;top:-9999px;width:1123px;height:794px;border:none;visibility:hidden;';
                    document.body.appendChild(iframe);

                    iframe.onload = async () => {
                        try {
                            await new Promise(r => setTimeout(r, 2000)); // let the border image + QR code render

                            const certEl = iframe.contentDocument.querySelector('.certificate');

                            if (!certEl) {
                                console.warn('Certificate element not found for record', id);
                                document.body.removeChild(iframe);
                                resolve();
                                return;
                            }

                            const canvas = await html2canvas(certEl, {
                                scale: 3,
                                useCORS: true,
                                allowTaint: false,
                                backgroundColor: '#ffffff',
                            });

                            const imgData = canvas.toDataURL('image/jpeg', 1.0);

                            const { jsPDF } = window.jspdf;
                            const pdf = new jsPDF({ orientation: 'landscape', unit: 'mm', format: 'a4' });
                            pdf.addImage(imgData, 'JPEG', 0, 0, 297, 210);

                            const pdfBytes = pdf.output('arraybuffer');
                            const singlePdf = await PDFDocument.load(pdfBytes);
                            const copiedPages = await mergedPdf.copyPages(singlePdf, singlePdf.getPageIndices());
                            copiedPages.forEach(page => mergedPdf.addPage(page));
                        } catch (err) {
                            console.error(`Failed for record ${id}:`, err);
                        }

                        document.body.removeChild(iframe);
                        resolve();
                    };

                    iframe.src = `/certificates/${CERT_TYPE}/${id}/preview`;
                });
            }

            progressText.textContent = 'Finalizing merged PDF...';
            progressBar.style.width = '100%';
            progressBar.textContent = '100%';

            const mergedBytes = await mergedPdf.save();
            const blob = new Blob([mergedBytes], { type: 'application/pdf' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${CERT_TYPE}_certificates_${new Date().toISOString().slice(0, 10)}.pdf`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);

            btn.disabled = false;
            btn.innerHTML = '<i class="bx bx-play-circle me-1"></i> Start';
            progressText.textContent = `Done! ${total} certificates merged and downloaded.`;
        });
    </script>
@endsection
