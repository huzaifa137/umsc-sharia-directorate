<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate of Guardianship — {{ $application->ward_name ?? '' }}</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Amiri:wght@400;700&display=swap">
    <style>
        html, body {
            margin: 0; padding: 0;
            background: #e8e8e8;
            min-height: 100vh;
        }

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

        /* Certificate number — moved to the top-RIGHT corner. The
           top-left corner in this frame image has a solid dark-green
           decorative block, and the number was landing on top of it
           (illegible, low contrast). Top-right is clear. */
        .cert-no {
            position: absolute;
            top: 12mm; right: 18mm;
            font-size: 10px;
            color: #333;
            letter-spacing: 1px;
            text-align: right;
            z-index: 3;
        }

        /* ===== Header: council name + directorate ===== */
        .header {
            position: absolute;
            top: 45mm; left: 0; width: 297mm;
            text-align: center;
            z-index: 3;
        }
        .council-name {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 700;
            color: #0d3b1f;
            letter-spacing: 1px;
            margin: 0;
        }
        .directorate {
            font-size: 12px;
            color: #1a1a1a;
            letter-spacing: 3px;
            margin: 1mm 0 0 0;
        }

        .mini-divider {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3mm;
            margin: 2mm auto 0 auto;
        }
        .mini-divider .ln { width: 22mm; height: 1px; background: #0d3b1f; }
        .mini-divider .dot {
            width: 5px; height: 5px; background: #d4a017;
            transform: rotate(45deg);
        }

        /* ===== Title =====
           The frame image has its seal artwork baked in roughly between
           8mm and 45mm from the top, centered horizontally — this
           margin-top pushes CERTIFICATE below it instead of through it. */
        .title {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 700;
            color: #0d3b1f;
            text-align: center;
            letter-spacing: 3px;
            margin: 1mm 0 0 0;
        }

        .subtitle-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5mm;
            margin: 1mm 0 0 0;
        }
        .subtitle-row .ln { flex: 0 0 32mm; height: 1px; background: #0d3b1f; }
        .subtitle-row .txt {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 3px;
            color: #0d3b1f;
        }

        /* ===== Body ===== */
        .body-block {
            position: absolute;
            top: 84mm; left: 24mm; width: 249mm;
            text-align: center;
            z-index: 2;
        }
        .certify-line { font-size: 15px; margin: 0; }
        .blank-line {
            width: 190mm;
            margin: 3mm auto;
            border-bottom: 1px dotted #333;
            padding-bottom: 1.5mm;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 17px;
            color: #0d3b1f;
        }
        .body-para {
            font-size: 13px;
            line-height: 1.6;
            max-width: 200mm;
            margin: 3mm auto 0 auto;
        }

        .scripture-block { margin-top: 2mm; }
        .scripture-lead { font-size: 13px; margin: 0; }
        .arabic-verse {
            font-family: 'Amiri', serif;
            font-size: 19px;
            font-weight: 700;
            color: #0d3b1f;
            direction: rtl;
            margin: 1.5mm 0;
        }
        .verse-en {
            font-style: italic;
            font-size: 12.5px;
            margin: 0;
        }
        .citation {
            font-size: 11px;
            color: #333;
            margin: 1mm 0 0 0;
        }

        .dua-para {
            font-size: 13px;
            line-height: 1.5;
            max-width: 205mm;
            margin: 3mm auto 0 auto;
        }

        /* ===== Footer: signature | seal ring | date =====
           Insets widened (22mm -> 34mm/26mm) so the signature lines
           clear the frame's thick decorative bars along the edges,
           particularly the vertical green bar on the left. */
        .footer-row {
            position: absolute;
            left: 34mm; right: 26mm; bottom: 14mm;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            z-index: 3;
        }
        .footer-col { width: 74mm; text-align: center; }
        .sig-line { border-top: 1px solid #333; margin-bottom: 1.5mm; }
        .footer-title {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 12px;
            color: #0d3b1f;
        }
        .footer-sub {
            font-size: 10.5px;
            color: #1a1a1a;
            margin-top: 0.5mm;
        }
       .footer-value {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 12px;
            color: #0d3b1f;
            margin-top: 0.5mm;
        }
 
        .seal-ring {
            width: 25mm; height: 25mm;
            border-radius: 50%;
            border: 2px dashed #d4a017;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            top: 12mm; /* nudges it down, clear of the dua/hadith text above */
            margin: 0 auto;
        }
        .seal-ring::before {
            content: '';
            position: absolute;
            inset: 3px;
            border: 1px solid #0d3b1f;
            border-radius: 50%;
        }
        .seal-ring img {
            width: 22mm; height: 22mm;
            border-radius: 50%;
            position: relative;
            z-index: 1;
        }

        @media print {
            .print-bar { display: none; }
            html, body { background: #fff; padding-top: 0; display: block; }
            .page { box-shadow: none; margin: 0; }
            @page { size: 297mm 210mm landscape; margin: 0; }
        }
    </style>
</head>
<body>

    <div class="print-bar">
        <button class="print-btn" onclick="window.print()">PRINT CERTIFICATE</button>
    </div>

    <div class="page">
        @php
            $issueDate = $application->guardianship_date ?? $application->created_at ?? now();
        @endphp

        <img src="{{ asset('assets/certificates/guardianship-frame-landscape.png') }}" class="frame" alt="frame">

        <div class="cert-no">{{ $certificateNumber ?? '' }}</div>

        <div class="header">
            <div class="council-name">UGANDA MUSLIM SUPREME COUNCIL</div>
            <div class="directorate">DIRECTORATE OF SHARIA</div>
            <div class="mini-divider"><span class="ln"></span><span class="dot"></span><span class="ln"></span></div>

            <h1 class="title">CERTIFICATE</h1>
            <div class="subtitle-row">
                <span class="ln"></span>
                <span class="txt">OF GUARDIANSHIP</span>
                <span class="ln"></span>
            </div>
        </div>

        <div class="body-block">
            <p class="certify-line">This is to certify that</p>
            <div class="blank-line">{{ $application->guardian_name ?? '' }}</div>

            <p class="certify-line">has been appointed as the lawful guardian of</p>
            <div class="blank-line">{{ $application->ward_name ?? '' }}</div>

            <p class="body-para">
                to care for, nurture, protect and act in the best interest of the above-named
                in accordance with Islamic teachings and the laws of Uganda.
            </p>

            <div class="scripture-block">
                <p class="scripture-lead">Allah <span style="font-family:'Amiri',serif;">ﷻ</span> says:</p>
                <p class="arabic-verse">وَاتَّقُوا اللَّهَ وَاعْلَمُوا أَنَّ اللَّهَ بِكُلِّ شَيْءٍ عَلِيمٌ</p>
                <p class="verse-en">&ldquo;And fear Allah and know that Allah is All-Aware of everything.&rdquo;</p>
                <p class="citation">(Surah Al-Baqarah: 2: 282)</p>
            </div>

            <div class="scripture-block">
                <p class="scripture-lead">The Prophet Muhammad <span style="font-family:'Amiri',serif;">ﷺ</span> said:</p>
                <p class="verse-en">
                    &ldquo;Each of you is a shepherd and each of you is responsible for his flock.<br>
                    The leader is a shepherd and he is responsible for his flock...&rdquo;
                </p>
                <p class="citation">(Sahih Al-Bukhari: 893)</p>
            </div>

            <p class="dua-para">
                May Allah <span style="font-family:'Amiri',serif;">ﷻ</span> grant the guardian wisdom, patience and strength
                to fulfill this trust with justice, kindness and Taqwa.
            </p>

            <div class="mini-divider"></div>
        </div>

        <div class="footer-row">
            <div class="footer-col">
                <div class="sig-line"></div>
                <div class="footer-title">DIRECTOR OF SHARIA</div>
                <div class="footer-sub">Uganda Muslim Supreme Council</div>
            </div>

            <div class="footer-col">
                <div class="seal-ring">
                    @if(!empty($qrCode))
                        <img src="{{ $qrCode }}" alt="QR">
                    @endif
                </div>
            </div>

            <div class="footer-col">
                <div class="sig-line"></div>
                <div class="footer-title">DATE OF ISSUE</div>
                <div class="footer-value">{{ \Carbon\Carbon::parse($issueDate)->format('d-M-Y') }}</div>
            </div>
        </div>
    </div>

</body>
</html>