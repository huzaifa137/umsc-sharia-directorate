{{-- resources/views/certificates/divorce.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Divorce Certificate — {{ $application->groom_given_name ?? '' }} & {{ $application->bride_given_name ?? '' }}</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Cinzel:wght@600;700&family=Amiri:wght@400;700&display=swap">
<style>
  html, body { margin: 0; padding: 0; background: #fff; }
  * { box-sizing: border-box; }
  body {
    width: 297mm; min-height: 210mm;
    margin: 0 auto; font-family: 'Times New Roman', serif;
  }

  .certificate {
    width: 287mm; height: 198mm;
    position: relative; margin: 6mm auto;
    background: #fbf6e9;
  }

  .certificate-bg { position: absolute; inset: 0; z-index: 0; }
  .certificate-bg img { width: 100%; height: 100%; object-fit: fill; display: block; }

  .mosque-bg {
    position: absolute; right: 10mm; bottom: 18mm;
    width: 120mm; opacity: 0.5; z-index: 0; pointer-events: none;
  }

  /* Seal pinned to upper-right corner */
  .seal-corner {
    position: absolute;
    top: 18mm; right: 27mm;
    z-index: 3;
  }
  .seal-corner img { height: 28mm; width: auto; }

  .certificate-content {
    position: absolute;
    left: 28mm; right: 28mm;
    top: 45mm; bottom: 92mm;
    display: flex; flex-direction: column; align-items: center;
    text-align: center; z-index: 1;
  }
  .certificate-content > * { position: relative; z-index: 1; width: 100%; }

  .cert-subtitle {
    margin-top: 12mm;      /* Creates space below the Basmallah */
    margin-bottom: 1mm;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    color: #0d4b1e;
}
  .cert-title {
    font-family: 'Cinzel', 'Times New Roman', serif;
    font-size: 28px; font-weight: 700; letter-spacing: 3px;
    color: #0d4b1e;
  }

  .header-spacer {
            width: 52mm;
            flex-shrink: 0;
        }


  .verse-block { margin-top: 3mm; color: #2c2c2c; }
  .verse-arabic {
    font-family: 'Amiri', serif; font-size: 20px;
    color: #0d4b1e; direction: rtl; margin-bottom: 2mm;
  }
  .verse-translation { font-size: 11px; font-style: italic; line-height: 1.5; }
  .verse-ref { font-size: 10px; color: #5c5238; margin-top: 1mm; }

  .body-row {
    display: flex; justify-content: space-between;
    align-items: flex-start; width: 100%; margin-top: 4mm;
  }
  .photo-col { width: 42mm; text-align: center; flex-shrink: 0; }
  .photo-box {
    width: 34mm; height: 42mm;
    border: 2px solid #b8860b; border-radius: 3px;
    margin: 0 auto 2mm; overflow: hidden; background: #f7f4ec;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  }
  .photo-box img { width: 100%; height: 100%; object-fit: cover; }
  .label-text { font-weight: bold; letter-spacing: 2px; font-size: 11px; color: #0d4b1e; }

  .center-col {
    flex: 1; margin: 0 8mm;
    font-size: 12.5px; line-height: 1.9; color: #2c2c2c;
  }
  .input-line {
    display: inline-block; border-bottom: 1.5px solid #b8860b;
    min-width: 60mm; font-weight: bold; color: #0d4b1e; padding: 0 4mm;
  }
  /* Professional serif for names — small caps, tight tracking */
  .input-line.name {
    font-family: 'Playfair Display', 'Cinzel', 'Times New Roman', serif;
    font-size: 20px;
    font-weight: 700;
    font-variant: small-caps;
    letter-spacing: 2px;
    line-height: 1.3;
    color: #0d4b1e;
  }

  .disclaimer {
    font-size: 14px; font-style: italic; color: #1d1b16;
    line-height: 1.7; margin-top: 4mm; max-width: 170mm; text-align: center;
  }

  .footer-section {
    position: absolute;
    left: 28mm; right: 28mm;
    bottom: 22mm;
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    align-items: end;
    z-index: 1;
  }
  .qr-code img { width: 24mm; height: 24mm; object-fit: contain; }

  .signature-block { text-align: center; }
  .sign-space { height: 14mm; }
  .sign-line  { border-top: 1px solid #333; width: 70%; margin: 0 auto 2mm; }
  .sign-name  { font-weight: bold; font-size: 11px; color: #0d4b1e; letter-spacing: 1px; }
  .sign-role  { font-weight: bold; font-size: 10px; color: #2c2c2c; margin-top: 1mm; letter-spacing: 1px; }

  .date-block { text-align: right; font-size: 11px; color: #2c2c2c; }
  .date-block .input-line {
    min-width: 40mm; font-family: 'Times New Roman', serif;
    font-size: 12px; font-weight: bold; color: #0d4b1e;
  }

  @media print {
    body { background: #fff !important; }
    .certificate { box-shadow: none !important; page-break-inside: avoid; }
  }
</style>
</head>
<body>
  <div class="certificate">

    <div class="certificate-bg">
      <img src="{{ asset('assets/certificates/divorce-frame-landscape.png') }}" alt="">
    </div>

   

    {{-- UMSC seal — upper right corner --}}
    <div class="seal-corner">
      <img src="{{ asset('assets/certificates/umsc-seal.png') }}" alt="UMSC Seal">
    </div>

    <div class="certificate-content">
      <div class="header-spacer"></div>
      <div class="cert-subtitle">DIRECTORATE OF SHARIAH (UMSC)</div>
      <div class="cert-title">CERTIFICATE OF DIVORCE</div>

      <div class="verse-block">
        <div class="verse-arabic">
          فَإِنْ طَلَّقَهَا فَلَا تَحِلُّ لَهُ مِنْ بَعْدُ حَتَّىٰ تَنْكِحَ زَوْجًا غَيْرَهُ
        </div>
        <div class="verse-translation">
          “So if he divorces her, she shall not be lawful to him thereafter
          until she marries another husband.”
        </div>
        <div class="verse-ref">(Surah Al-Baqarah : 2:230)</div>
      </div>

      <div class="body-row">
        <div class="photo-col">
          <div class="photo-box">
            @if ($application->groom_photo_path ?? null)
              <img src="{{ asset('storage/' . $application->groom_photo_path) }}" alt="Husband">
            @endif
          </div>
          <div class="label-text">HUSBAND</div>
        </div>

        <div class="center-col">
          This is to certify that
          <div><span class="input-line name">{{ $application->groom_given_name }} {{ $application->groom_surname }}</span></div>
          has divorced his wife
          <div><span class="input-line name">{{ $application->bride_given_name }} {{ $application->bride_surname }}</span></div>
          on this day in accordance with Islamic Sharia at
          <strong>{{ $application->divorce_place ?? $application->masjid_name ?? 'UMSC Headquarters' }}</strong>,
          officiated by Imam
          <span class="input-line">{{ $application->imam_name ?? '' }}</span>.
        </div>

        <div class="photo-col">
          <div class="photo-box">
            @if ($application->bride_photo_path ?? null)
              <img src="{{ asset('storage/' . $application->bride_photo_path) }}" alt="Wife">
            @endif
          </div>
          <div class="label-text">WIFE</div>
        </div>
      </div>

      <div class="disclaimer">
        This divorce has been executed in accordance with the principles of Islamic Sharia,
        upholding the rights and responsibilities of both parties.
        May Allah grant them ease, forgiveness, and peace in their future.
      </div>
    </div>

    <div class="footer-section">
      <div class="qr-code">
        @if (!empty($qrCode))
          <img src="{{ $qrCode }}" alt="QR Code">
        @endif
      </div>

      <div class="signature-block">
        <div class="sign-space"></div>
        <div class="sign-line"></div>
        
        <div class="sign-role">DIRECTOR OF SHARIA</div>
      </div>

      <div class="date-block">
        Date of Issue:
        <div><span class="input-line">{{ \Carbon\Carbon::now()->format('jS F Y') }}</span></div>
      </div>
    </div>
  </div>
</body>
</html>
