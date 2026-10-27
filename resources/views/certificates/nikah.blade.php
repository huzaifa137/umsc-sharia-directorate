<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nikah Certificate — {{ $application->groom_given_name ?? '' }} & {{ $application->bride_given_name ?? '' }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap">
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            background: white;
        }

        body {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto;
            background: #FFF;
            font-family: 'Times New Roman', serif;
        }

        * {
            box-sizing: border-box;
        }

        .certificate {
            width: 287mm;
            height: 198mm;
            position: relative;
            margin-left: auto;
            margin-right: auto;
            margin-top: 6mm;
            margin-bottom: 6mm;
            display: block;
        }

        .certificate-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .certificate-bg img {
            width: 100%;
            height: 100%;
            object-fit: fill;
            display: block;
        }

        /* Pushed "top" down from 12mm to 34mm so the title/subtitle render
           BELOW the frame artwork's own Bismillah calligraphy instead of
           on top of it — that graphic lives in the frame image itself,
           not in this HTML, so the only fix is giving it more clearance. */
        .certificate-content {
            position: absolute;
            left: 34mm;
            right: 34mm;
            top: 48mm;
            bottom: 20mm;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            align-items: center;
            text-align: center;
        }

        .certificate-content>* {
            position: relative;
            z-index: 1;
            width: 100%;
        }

        /* HEADER — now a 3-zone row (spacer | center | seal) using the SAME
           42mm width as .box-container below, so the seal's column lines
           up exactly with the bride's photo column, not just "roughly
           right-aligned" the way margin-left:auto was doing before. */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            color: #2c3e50;
            width: 100%;
        }

        .header-spacer {
            width: 42mm;
            flex-shrink: 0;
        }

        .header-center {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .header-seal {
            width: 42mm;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            transform: translateY(-20mm); /* Move logo upward */
        }

        .header img.seal {
            height: 36mm;
            width: auto;
            display: block;
        }

        .cert-subtitle {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #b8860b;
            margin-bottom: 1.5mm;
        }

        .cert-title {
            font-size: 25px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #0d4b1e;
            text-align: center;
        }

        .cert-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 3mm;
            color: #b8860b;
            font-size: 13px;
        }

        .cert-divider .line {
            width: 45mm;
            height: 1.5px;
            background: linear-gradient(90deg, transparent, #b8860b, transparent);
        }

        .photo-section {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .box-container {
            width: 42mm;
            text-align: center;
            flex-shrink: 0;
        }

        .photo-box {
            width: 34mm;
            height: 42mm;
            border: 2px solid #b8860b;
            border-radius: 4px;
            margin: 0 auto 2.5mm;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            background: #f7f4ec;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .label-text {
            font-weight: bold;
            letter-spacing: 1.5px;
            font-size: 10px;
            color: #0d4b1e;
        }

        .center-content {
            flex: 1;
            margin: 0 10mm;
            max-width: 140mm;
        }

        .main-content {
            font-size: 12.5px;
            line-height: 1.85;
            width: 100%;
            color: #2c2c2c;
            text-align: center;
        }

        .input-line {
            display: inline-block;
            border-bottom: 2px solid #2c2c2c;
            min-width: 55mm;
            font-weight: bold;
            color: #0d4b1e;
        }

        .input-line.name {
            font-family: 'Great Vibes', cursive;
            font-size: 26px;
            font-weight: normal;
            line-height: 1.4;
        }

        .disclaimer {
            font-size: 12px;
            font-style: italic;
            width: 100%;
            max-width: 200mm;
            text-align: center;
            color: #5c5238;
            line-height: 1.6;
        }

        .footer-section {
            width: 100%;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: end;
            width: 100%;
        }

        .qr-code {
            display: flex;
            justify-content: center;
        }

        .qr-code img {
            width: 22mm;
            height: 22mm;
            object-fit: contain;
            border: 2px solid #2c2c2c;
        }

        .signature-block {
            text-align: center;
        }

        .signature-block .sign-line {
            width: 55mm;
            border-bottom: 1.5px solid #2c2c2c;
            margin: 0 auto 2mm;
            height: 9mm;
        }

        .signature-block .sign-name {
            font-weight: bold;
            font-size: 11px;
            color: #0d4b1e;
        }

        .signature-block .sign-role {
            font-weight: bold;
            font-size: 9.5px;
            color: #2c2c2c;
            margin-top: 0.5mm;
        }

        .reg-info {
            text-align: center;
            font-weight: bold;
            font-size: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5mm;
        }

        .reg-info .input-line {
            min-width: 32mm;
            text-align: center;
            font-size: 10px;
        }

        @media print {
            body {
                background-color: #fff !important;
            }

            .certificate {
                box-shadow: none !important;
                page-break-inside: avoid;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<body>

    <div class="no-print" style="width: 287mm; margin: 0 auto 10px; text-align: right;">
        <button id="downloadCertificate"
            style="padding: 10px 20px; background-color: #0d4b1e; color: #fff; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center;">
            <i class="bi bi-download"></i>&nbsp;&nbsp;Download Certificate PDF
        </button>
    </div>

    <div class="certificate">

        <div class="certificate-bg">
            <img src="{{ asset('assets/certificates/gold-border-landscape.png') }}" alt="">
        </div>

        <div class="certificate-content">

            <!-- HEADER: spacer | title (center) | seal — same 42mm zones as
                 the photo row below, so the seal sits directly above the
                 bride's photo instead of just floating at the right edge. -->
            <div class="header">
                <div class="header-spacer"></div>
                <div class="header-center">
                    <div class="cert-subtitle">DIRECTORATE OF SHARIAH (UMSC)</div>
                    <div class="cert-title">CERTIFICATE OF MARRIAGE (NIKAH)</div>
                    <div class="cert-divider"><span class="line"></span>&#10022;<span class="line"></span></div>
                </div>
                <div class="header-seal">
                    <img class="seal" src="{{ asset('assets/img/branding/umsc-seal.png') }}" alt="UMSC Seal">
                </div>
            </div>

            <div class="photo-section">
                <div class="box-container">
                    <div class="photo-box">
                        @if ($application->groom_photo_path)
                            <img src="{{ asset('storage/' . $application->groom_photo_path) }}" alt="Groom">
                        @endif
                    </div>
                    <div class="label-text">GROOM</div>
                </div>

                <div class="center-content">
                    <div class="main-content">
                        This record of marriage between<br>
                        <span class="input-line name">{{ $application->groom_given_name }} {{ $application->groom_surname }}</span><br>
                        and<br>
                        <span class="input-line name">{{ $application->bride_given_name }} {{ $application->bride_surname }}</span><br>
                        was lawfully solemnized in accordance to Islamic Sharia at Masjid
                        <span class="input-line" style="min-width:60mm;">{{ $application->masjid_name ?? 'UMSC Headquarters' }}</span><br>
                        officiated by Imam
                        <span class="input-line" style="min-width:60mm;">{{ $application->imam_name ?? '________________' }}</span>
                    </div>
                </div>

                <div class="box-container">
                    <div class="photo-box">
                        @if ($application->bride_photo_path)
                            <img src="{{ asset('storage/' . $application->bride_photo_path) }}" alt="Bride">
                        @endif
                    </div>
                    <div class="label-text">BRIDE</div>
                </div>
            </div>

            <div class="disclaimer">
                This marriage has been officially registered in accordance with Islamic Sharia principles under
                authority vested in the Sharia Directorate of the Uganda Muslim Supreme Council, establishing a
                sacred covenant between the parties.
            </div>

            <div class="footer-section">
                <div class="cert-divider" style="margin-bottom: 4mm;"><span class="line"></span>&#10022;<span class="line"></span></div>
                <div class="footer-content">
                    <div class="qr-code">
                        <div id="qr"></div>
                    </div>
                    <div class="signature-block">
                        <div class="sign-line"></div>
                        <div class="sign-name"></div>
                        <div class="sign-role">DIRECTOR OF SHARIA</div>
                    </div>
                    <div class="reg-info">
                        <span>Date of Issue:</span>
                        <span class="input-line">{{ \Carbon\Carbon::now()->format('jS F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        new QRCode(document.getElementById("qr"), {
            text: {!! json_encode(url('/certificates/verify/nikah/' . $application->id)) !!},
            width: 84,
            height: 84,
            colorDark: "#0d4b1e",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });

        const downloadBtn = document.getElementById('downloadCertificate');

        downloadBtn.addEventListener('click', () => {
            downloadBtn.disabled = true;
            const original = downloadBtn.innerHTML;
            downloadBtn.innerHTML = 'Preparing PDF...';

            const element = document.querySelector('.certificate');

            const opt = {
                margin: 0,
                filename: '{{ $application->groom_given_name }}_{{ $application->bride_given_name }}_NikahCertificate.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, useCORS: true },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                downloadBtn.disabled = false;
                downloadBtn.innerHTML = original;
            }).catch(() => {
                downloadBtn.disabled = false;
                downloadBtn.innerHTML = original;
                alert('An error occurred while generating the PDF.');
            });
        });
    </script>

</body>

</html>