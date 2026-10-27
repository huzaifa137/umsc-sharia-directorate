<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Acceptance of Islam — {{ $application->new_names ?? $application->former_names ?? '' }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700&family=Playfair+Display:wght@600;700&family=Amiri:wght@400;700&family=Great+Vibes&display=swap">
    <style>
        html, body {
            margin: 0; padding: 0;
            background: #e8e8e8;
            min-height: 100vh;
        }

        /* Body is now just a centering flex container. The actual
           certificate lives in .page below, which keeps its fixed
           297mm x 210mm size and is centered inside the viewport
           instead of being pinned to the browser's left edge. */
        body {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 70px; /* clears the fixed print bar */
        }

        .page {
            width: 297mm; height: 210mm;
            font-family: 'Times New Roman', serif;
            color: #1a1a1a;
            position: relative;
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.25);
            -webkit-print-color-adjust: exact; print-color-adjust: exact;
        }

        /* ===== Print bar ===== */
        .print-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 56px;
            background: #0d3b1f;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        }
        .print-btn {
            background: #d4a017;
            color: #0d3b1f;
            border: none;
            padding: 10px 26px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            border-radius: 5px;
            cursor: pointer;
            font-family: 'Playfair Display', 'Times New Roman', serif;
        }
        .print-btn:hover { background: #c49416; }

        .frame { position: absolute; inset: 0; width: 297mm; height: 210mm; z-index: 0; }
        .mosque-bg {
            position: absolute;
            right: 8mm;
            top: 38mm;
            width: 150mm;
            height: auto;
            opacity: 0.22;
            z-index: 1;
            filter: grayscale(10%);
        }

        /* Top-left seal */
        .seal-corner {
            position: absolute;
            top: 12mm; left: 18mm;
            width: 32mm; height: auto;
            z-index: 3;
        }
        .seal-caption {
            position: absolute;
            top: 55mm; left: 10mm;
            width: 48mm;
            text-align: center;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #0d3b1f;
            z-index: 3;
        }
        .cert-no {
            position: absolute;
            top: 62mm; left: 18mm;
            font-size: 12px;
            color: #1a1a1a;
            z-index: 3;
            letter-spacing: 1px;
        }

        /* Title block — centered upper area */
        .title-block {
            position: absolute;
            top: 16mm; left: 62mm; width: 120mm;
            z-index: 3;
        }
        .title {
            font-family: 'Cinzel', 'Times New Roman', serif;
            font-size: 54px;
            font-weight: 700;
            color: #0d3b1f;
            letter-spacing: 4px;
            margin: 0;
            line-height: 1;
        }
        .subtitle {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            color: #0d3b1f;
            margin: 2mm 0 0 4mm;
            font-style: italic;
        }

        /* Arabic verse — top right */
        .arabic-block {
            position: absolute;
            top: 20mm; right: 22mm;
            width: 80mm;
            text-align: center;
            z-index: 3;
        }
        .arabic-verse {
            font-family: 'Amiri', serif;
            font-size: 26px;
            font-weight: 700;
            color: #b8860b;
            direction: rtl;
            margin: 0;
            line-height: 1.4;
        }
        .verse-en {
            font-size: 10px;
            font-style: italic;
            color: #333;
            margin-top: 3mm;
            line-height: 1.5;
        }

        /* Certify body — center-left column */
        .content {
            position: absolute;
            top: 68mm; left: 60mm; width: 120mm;
            z-index: 2;
        }
        .certify-line { font-size: 20px; margin: 0 0 4mm 0; }
        .name-display {
            font-family: 'Great Vibes', cursive;
            font-size: 42px;
            color: #0d3b1f;
            text-align: center;
            margin: 0 0 6mm 0;
            line-height: 1;
        }
        .name-row {
            display: flex;
            align-items: baseline;
            gap: 6mm;
            border-bottom: 1px solid #d4a017;
            padding: 2mm 4mm;
            margin: 0 auto 3mm auto;
            width: 105mm;
        }
        .name-row .label {
            font-family: 'Playfair Display', serif;
            font-size: 12px;
            color: #333;
            min-width: 36mm;
        }
        .name-row .value {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 14px;
            color: #0d3b1f;
        }
        .paragraph {
            font-size: 20px;
            line-height: 1.6;
            margin: 5mm 0 0 0;
            max-width: 105mm;
        }
        .dua {
            font-style: italic;
            font-size: 18px;
            line-height: 1.6;
            margin: 5mm 0 0 0;
            max-width: 100mm;
        }

        /* ===== Bottom row: Signature | Date of Issue | Mosque ===== */
        .bottom-row {
            position: absolute;
            left: 158mm; right: 16mm; bottom: 12mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 8mm;
            z-index: 3;
        }

        .sig-col {
            width: 62mm;
            text-align: center;
        }
        .sig-line { width: 100%; border-top: 1px solid #333; margin-bottom: 1.5mm; }
        .sig-name {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 11px;
            color: #0d3b1f;
            letter-spacing: 0.5px;
        }
        .sig-title {
            font-size: 9px;
            color: #333;
            letter-spacing: 1px;
            margin-top: 0.5mm;
        }
        .ameen-note {
            font-style: italic;
            font-size: 8.5px;
            color: #333;
            line-height: 1.35;
            margin-top: 2mm;
        }

        .meta-col {
            text-align: center;
            font-size: 11px;
            color: #1a1a1a;
        }
        .meta-col .icon {
            font-size: 20px;
            color: #0d3b1f;
            display: block;
            margin-bottom: 1mm;
        }
        .meta-col strong {
            display: block;
            font-size: 11px;
            color: #0d3b1f;
            font-family: 'Playfair Display', serif;
        }

        /* QR — sits just above the bottom row, over the signature column */
        .qr {
            position: absolute;
            left: 172mm; bottom: 44mm;
            width: 26mm; height: 26mm;
            z-index: 3;
        }
        .qr img { width: 100%; height: 100%; display: block; }

        /* ===== Print handling =====
           The print bar and gray backdrop/shadow should never show up on
           the printed page — only the certificate itself, sized exactly
           to the paper. */
        @media print {
            .print-bar { display: none; }
            html, body {
                background: #fff;
                padding-top: 0;
                display: block;
            }
            .page {
                box-shadow: none;
                margin: 0;
            }
            @page {
                size: 297mm 210mm landscape;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="print-bar">
        <button class="print-btn" onclick="window.print()">PRINT CERTIFICATE</button>
    </div>

    <div class="page">
        @php
            $issueDate = $application->conversion_date ?? $application->created_at ?? now();
        @endphp

        <img src="{{ asset('assets/certificates/convert-frame-landscape.png') }}" class="frame" alt="frame">

        <img src="{{ asset('assets/certificates/umsc-seal.png') }}" class="seal-corner" alt="UMSC seal">

        <div class="seal-caption">
            DIRECTORATE OF SHARIAH<br>(UMSC)
        </div>

        <div class="cert-no">{{ $certificateNumber }}</div>

        <div class="title-block">
            <h1 class="title">CERTIFICATE</h1>
            <p class="subtitle">of Acceptance of Islam</p>
        </div>

        <div class="arabic-block">
            <p class="arabic-verse">وَمَن يَبْتَغِ غَيْرَ الْإِسْلَامِ دِينًا</p>
            <p class="verse-en">
                &ldquo;And whoever seeks a religion other than Islam,<br>
                it will never be accepted from him,<br>
                and he will be in the Hereafter among the losers.&rdquo;<br>
                (Surah Al-Imran : 85)
            </p>
        </div>

        <div class="content">
            <p class="certify-line">This is to certify that</p>
            <p class="name-display">{{ $application->new_names ?? $application->former_names ?? '' }}</p>

            <div class="name-row">
                <span class="label">Former Name:</span>
                <span class="value">{{ $application->former_names ?? '' }}</span>
            </div>
            <div class="name-row">
                <span class="label">New Muslim Name:</span>
                <span class="value">{{ $application->new_names ?? '' }}</span>
            </div>

            <p class="paragraph">
                has sincerely embraced Islam and has been accepted into the Ummah of Prophet Muhammad
                <span style="font-family: 'Amiri', serif;">ﷺ</span> on this blessed day.
            </p>

            <p class="dua">
                May Allah <span style="font-family: 'Amiri', serif;">ﷻ</span> strengthen
                {{ ($application->gender ?? 'male') === 'female' ? 'her' : (($application->gender ?? '') === 'male' ? 'him' : 'them') }}
                in faith, grant
                {{ ($application->gender ?? 'male') === 'female' ? 'her' : (($application->gender ?? '') === 'male' ? 'him' : 'them') }}
                knowledge and righteous deeds, and make
                {{ ($application->gender ?? 'male') === 'female' ? 'her' : (($application->gender ?? '') === 'male' ? 'him' : 'them') }}
                a source of goodness in this world and the Hereafter.
            </p>
        </div>

        @if(!empty($qrCode))
        <div class="qr">
            <img src="data:image/png;base64,{{ $qrCode }}" alt="QR">
        </div>
        @endif

        <div class="bottom-row">
            <div class="sig-col">
                <div class="sig-line"></div>
                <div class="sig-name">PROF. DR. ZIYAD S. LUBANGA</div>
                <div class="sig-title">DIRECTOR OF SHARIAH (UMSC)</div>
                <div class="ameen-note">
                    O Allah! Accept them into Islam with sincerity,<br>
                    and guide them on the Straight Path. (Ameen)
                </div>
            </div>

            <div class="meta-col">
                <span class="icon">&#128197;</span>
                <strong>Date of Issue</strong>
                {{ \Carbon\Carbon::parse($issueDate)->format('d-M-Y') }}
            </div>

            <div class="meta-col">
                <span class="icon">&#127765;</span>
                <strong>Mosque</strong>
                {{ $application->mosque_name ?? 'Gaddafi National Mosque' }}<br>
                <span style="font-size:10px;">{{ $application->conversion_place ?? $application->mosque_location ?? 'Kampala, Uganda' }}</span>
            </div>
        </div>
    </div>

</body>
</html>