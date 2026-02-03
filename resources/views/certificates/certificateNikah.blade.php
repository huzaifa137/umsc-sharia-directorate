<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
            margin: 0;
            font-family: 'Times New Roman', serif;
        }

        .certificate-container {
            width: 1100px;
            min-height: 700px;
            padding: 20px;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
            border: 25px solid #7f8c8d;
            background: linear-gradient(135deg, #fdfbf6 0%, #f4efe0 100%);
            background-image: url('parchment-texture.jpg');
            background-size: cover;
        }

        .inner-border {
            border: 2px solid rgba(127, 140, 141, 0.6);
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: inset 0 0 40px rgba(127, 140, 141, 0.12);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            font-weight: bold;
            font-size: 1.1rem;
            color: #2c3e50;
        }

        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .sharia-text {
            font-size: 1rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: #7f8c8d;
        }

        .cert-title {
            font-size: 1.8rem;
            margin: 25px 0;
            letter-spacing: 2px;
            color: #2c3e50;
            position: relative;
        }

        .cert-title::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 25%;
            right: 25%;
            height: 3px;
            background: linear-gradient(to right, transparent, #7f8c8d, transparent);
            border-radius: 2px;
        }

        .photo-section {
            display: flex;
            justify-content: space-around;
            /* more space in landscape */
            align-items: flex-start;
            width: 100%;
            margin-top: 30px;
        }

        .box-container {
            width: 130px;
            text-align: center;
        }

        .photo-box {
            width: 120px;
            height: 150px;
            border: 2px solid #7f8c8d;
            border-radius: 6px;
            margin: 0 auto 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .label-text {
            font-weight: bold;
            letter-spacing: 2px;
            font-size: .9rem;
        }

        .center-content {
            flex: 1;
            margin: 0 30px;
        }

        .main-content {
            font-size: 1.1rem;
            line-height: 1.8;
            width: 100%;
            color: #2c3e50;
        }

        .input-line {
            display: inline-block;
            border-bottom: 2px solid #2c3e50;
            min-width: 500px;
            font-weight: bold;
        }

        .input-line.name {
            font-family: 'Great Vibes', cursive;
            font-size: 1.2rem;
        }

        .disclaimer {
            margin-top: 25px;
            font-size: .9rem;
            font-style: italic;
            width: 95%;
        }

        .footer-section {
            width: 100%;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dotted #2c3e50;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            align-items: center;
        }

        .qr-code {
            width: 90px;
            height: 90px;
            border: 2px solid #2c3e50;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: inset 0 0 5px rgba(191, 163, 63, 0.5);
        }

        .signature-block {
            text-align: center;
            font-weight: bold;
        }

        .reg-info {
            text-align: right;
            font-weight: bold;
        }

        @media print {
            body {
                background-color: #fff !important;
                padding: 0 !important;
            }

            .certificate-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 auto !important;
                page-break-inside: avoid;
            }

            button {
                display: none;
                /* hide print button in print */
            }
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <div style="width: 1100px; text-align: right; margin-bottom: 15px;">
        <div style="width: 1100px; text-align: right; margin-bottom: 15px;">
            <button id="downloadCertificate"
                style="padding: 10px 20px; background-color: #059580; color: #fff; border: none; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center;">
                <i class="bi bi-download" style="margin-right: 8px; font-size: 1.1rem;"></i>
                Download Certificate PDF
            </button>
        </div>

        <!-- Loader Overlay -->
        <!-- Loader Overlay -->
        <div id="pageLoader" class="d-none">
            <div class="loader-box">
                <div class="spinner"></div>
                <p class="loader-main-text">Processing your certificate</p>
                <p class="loader-sub-text">Please do not refresh the page</p>
            </div>
        </div>

        <style>
            /* Hide by default */
            .d-none {
                display: none !important;
            }

            /* Full screen overlay with frosted glass effect */
            #pageLoader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(8px);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 9999;
                font-family: 'Segoe UI', Roboto, sans-serif;
            }

            /* Loader box */
            .loader-box {
                background: white;
                padding: 40px;
                border-radius: 24px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                text-align: center;
                border: 1px solid rgba(255, 255, 255, 0.3);
                min-width: 260px;
            }

            /* Spinner animation */
            .spinner {
                width: 50px;
                height: 50px;
                border: 3px solid #f3f3f3;
                border-top: 3px solid #3498db;
                /* Primary color */
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 20px;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* Loader text styles */
            .loader-main-text {
                color: #2c3e50;
                font-weight: 600;
                font-size: 1.1rem;
                margin: 0;
            }

            .loader-sub-text {
                color: #7f8c8d;
                font-size: 0.9rem;
                margin-top: 8px;
            }
        </style>
    </div>
    </div>
    <div class="certificate-container">
        <div class="inner-border">
            <div class="header">
                <span>UGANDA MUSLIM</span>
                <div class="logo-area">
                    <span class="sharia-text">SHARIA</span>
                    <img class="logo-img" src="{{ asset('assets/img/branding/logo-png.png') }}" alt="UMSC Logo"
                        style="width:100px;">

                    <span class="sharia-text">DIRECTORATE</span>
                </div>
                <span>SUPREME COUNCIL</span>
            </div>

            <div class="cert-title">CERTIFICATE OF MARRIAGE</div>

            <div class="photo-section">
                <div class="box-container">
                    <div class="photo-box">
                        <!-- For groom photo -->
                        @if($application->groom_photo_path)
                            <img src="{{ asset('storage/' . $application->groom_photo_path) }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" />
                        @endif

                    </div>
                    <div class="label-text">GROOM</div>
                </div>

                <div class="center-content">
                    <div class="main-content">
                        This record of marriage between<br>
                        <span class="input-line name">
                            {{ $application->groom_given_name . ' ' . $application->groom_surname }}
                        </span><br>
                        and<br>
                        <span class="input-line name">
                            {{ $application->bride_given_name . ' ' . $application->bride_surname }}
                        </span><br>
                        was lawfully solemnized in accordance to<br>
                        Islamic Sharia at Masjid <span class="input-line name" style="min-width:450px">
                            {{-- {{ $application->masjid_name ?? '________________' }} --}}
                            {{ $application->masjid_name ?? 'UMSC - HEADQUARTERS'}}
                        </span><br>
                        officiated by Imam <span class="input-line name" style="min-width:487px">
                            {{ $application->imam_name ?? '________________' }}
                        </span>
                    </div>
                </div>

                <div class="box-container">
                    <div class="photo-box">
                        <!-- For bride photo -->
                        @if($application->bride_photo_path)
                            <img src="{{ asset('storage/' . $application->bride_photo_path) }}"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;" />
                        @endif
                    </div>
                    <div class="label-text">BRIDE</div>
                </div>
            </div>

            <div class="disclaimer">
                This marriage has been officially registered in accordance with Islamic Sharia principles
                under authority vested in the Sharia Directorate of the Uganda Muslim Supreme Council
                establishing a sacred covenant between the parties.
            </div>

            <div class="footer-section">
                <div class="footer-content">
                    <div class="qr-code">
                        <img src="{{ asset('/assets/img/branding/dummyQr.png') }}" alt="Official QR Code"
                            style="width: 90px; height: 90px; object-fit: contain; border: 2px solid #2c3e50; box-shadow: inset 0 0 5px rgba(191, 163, 63, 0.5);">
                    </div>
                    <div class="signature-block">
                        PROF. DR. ZIYAD S. LUBANGA<br>
                        DIRECTOR OF SHARIA
                    </div>
                    <div class="reg-info"
                        style="display: flex; justify-content: center; align-items: center; gap: 5px; white-space: nowrap; width: 100%;">
                        <span>Date of Issue:</span>
                        <span class="input-line" style="flex-shrink: 0; min-width: 150px; text-align: center;">
                            {{ \Carbon\Carbon::now()->format('jS/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const downloadBtn = document.getElementById('downloadCertificate');
        const loader = document.getElementById('pageLoader');

        downloadBtn.addEventListener('click', () => {
            // Show loader
            loader.classList.remove('d-none');
            downloadBtn.disabled = true; // prevent multiple clicks

            const element = document.querySelector('.certificate-container');
            const elementWidth = element.offsetWidth;
            const elementHeight = element.offsetHeight;
            const pdfWidthInches = elementWidth / 96;
            const pdfHeightInches = elementHeight / 96;

            const opt = {
                margin: 0,
                filename: '{{ $application->groom_given_name }}_{{ $application->bride_given_name }}_NikahCertificate.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, logging: true, useCORS: true },
                jsPDF: { unit: 'in', format: [pdfWidthInches, pdfHeightInches], orientation: 'landscape' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                loader.classList.add('d-none'); // hide loader
                downloadBtn.disabled = false;   // re-enable button
            }).catch(() => {
                loader.classList.add('d-none');
                downloadBtn.disabled = false;
                alert('An error occurred while generating the PDF.');
            });
        });

    </script>


</body>

</html>