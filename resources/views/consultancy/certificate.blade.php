<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Consultation Certificate — {{ $consultancy->applicant_name }}</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Cinzel:wght@600;700&family=Amiri:wght@400;700&display=swap">
<style>
  html, body { 
    margin: 0; 
    padding: 0; 
    background: #fff; 
  }
  * { 
    box-sizing: border-box; 
  }
  body {
    width: 210mm; 
    min-height: 297mm;
    margin: 0 auto; 
    font-family: 'Times New Roman', serif;
  }

  .certificate {
    width: 200mm; 
    height: 285mm;
    position: relative; 
    margin: 6mm auto;
    background: #fbf6e9;
    border-radius: 4px;
    overflow: hidden;
  }

  /* Background Frame */
  .certificate-bg { 
    position: absolute; 
    inset: 0; 
    z-index: 0; 
  }
  .certificate-bg img { 
    width: 100%; 
    height: 100%; 
    object-fit: fill; 
    display: block; 
  }

  /* Decorative Mosque Silhouette */
  .mosque-bg {
    position: absolute; 
    bottom: 8mm; 
    right: 8mm;
    width: 70mm; 
    opacity: 0.06; 
    z-index: 0; 
    pointer-events: none;
  }

  /* UMSC Seal - Top Right */
  .seal-corner {
    position: absolute;
    top: 18mm; 
    right: 18mm;
    z-index: 3;
  }
  .seal-corner img { 
    height: 20mm; 
    width: auto; 
  }

  /* Corner Decorations */
  .corner-decoration {
    position: absolute;
    z-index: 1;
    opacity: 0.25;
  }
  .corner-tl {
    top: 10mm;
    left: 10mm;
    width: 18mm;
    height: 18mm;
    border-top: 2px solid #b8860b;
    border-left: 2px solid #b8860b;
  }
  .corner-tr {
    top: 10mm;
    right: 10mm;
    width: 18mm;
    height: 18mm;
    border-top: 2px solid #b8860b;
    border-right: 2px solid #b8860b;
  }
  .corner-bl {
    bottom: 10mm;
    left: 10mm;
    width: 18mm;
    height: 18mm;
    border-bottom: 2px solid #b8860b;
    border-left: 2px solid #b8860b;
  }
  .corner-br {
    bottom: 10mm;
    right: 10mm;
    width: 18mm;
    height: 18mm;
    border-bottom: 2px solid #b8860b;
    border-right: 2px solid #b8860b;
  }

  /* Main Content Area */
  .certificate-content {
    position: absolute;
    left: 18mm; 
    right: 18mm;
    top: 18mm; 
    bottom: 18mm;
    display: flex; 
    flex-direction: column;
    text-align: center; 
    z-index: 1;
  }
  .certificate-content > * { 
    position: relative; 
    z-index: 1; 
    width: 100%; 
  }

  /* ================================================================
     HEADER SECTION - Logo Centered at Top
  ================================================================ */
  .cert-header {
    text-align: center;
    margin-bottom: 1.5mm;
  }

  /* Centered Logo */
  .cert-logo {
    display: flex;
    justify-content: center;
    margin-bottom: 4mm;
  }
  .cert-logo img {
    height: 30mm;
    width: auto;
    object-fit: contain;
  }

  .cert-subtitle {
    font-size: 12px; 
    font-weight: 700; 
    letter-spacing: 2.5px;
    color: #0d4b1e; 
    margin-bottom: 0.5mm;
    text-transform: uppercase;
  }

  .cert-title {
    font-family: 'Cinzel', 'Times New Roman', serif;
    font-size: 24px; 
    font-weight: 700; 
    letter-spacing: 3px;
    color: #0d4b1e;
    text-transform: uppercase;
  }

  .cert-id {
    font-size: 12px; 
    color: #5c5238; 
    margin-top: 0.5mm;
    letter-spacing: 0.5px;
    font-weight: 600;
  }

  /* Decorative Divider */
  .divider {
    width: 65%;
    margin: 1.5mm auto;
    border: none;
    height: 1px;
    background: linear-gradient(to right, transparent, #b8860b, transparent);
  }

  /* Verse Section */
  .verse-block { 
    margin-top: 1.5mm; 
    color: #2c2c2c; 
  }
  .verse-arabic {
    font-family: 'Amiri', serif; 
    font-size: 16px;
    color: #0d4b1e; 
    direction: rtl; 
    margin-bottom: 0.5mm;
  }
  .verse-translation { 
    font-size: 9.5px; 
    font-style: italic; 
    line-height: 1.4; 
    color: #3d3d3d;
  }
  .verse-ref { 
    font-size: 8.5px; 
    color: #5c5238; 
    margin-top: 0.5mm; 
    font-weight: 600;
  }

  /* Body Text */
  .body-text {
    margin-top: 1.5mm;
    font-size: 14px;
    line-height: 1.7;
    color: #2c2c2c;
    text-align: left;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-evenly;
    gap: 1.5mm;
  }

  .body-text p {
    margin: 2.5mm 2.5;
  }

  .cert-statement {
    display: flex;
    flex-direction: column;
  }

  .body-text .input-line {
    display: inline-block;
    border-bottom: 1.5px solid #b8860b;
    min-width: 40mm;
    font-weight: bold;
    color: #0d4b1e;
    padding: 5 5mm;
  }

  .body-text .input-line.name {
    font-family: 'Playfair Display', 'Cinzel', 'Times New Roman', serif;
    font-size: 15px;
    font-weight: 700;
    font-variant: small-caps;
    letter-spacing: 1px;
    color: #0d4b1e;
    min-width: 60mm;
  }

  .body-text .input-line.subject {
    font-family: 'Playfair Display', 'Cinzel', 'Times New Roman', serif;
    font-size: 13px;
    font-weight: 600;
    font-variant: small-caps;
    letter-spacing: 1px;
    color: #0d4b1e;
    min-width: 50mm;
  }

  /* GO AHEAD - Approval Box */
  .approval-box {
    padding: 1.5mm 3mm;
    background: rgba(5,149,104,0.08);
    border: 1.5px solid #059568;
    border-radius: 4px;
    font-size: 10.5px;
    line-height: 1.5;
    text-align: center;
    color: #0d4b1e;
  }

  .approval-box .check {
    font-size: 14px;
    color: #059568;
  }

  .approval-box strong {
    color: #059568;
    font-weight: 700;
  }

  /* Guidance Box */
  .guidance-box {
    padding: 1.5mm 3mm;
    background: rgba(5,149,104,0.05);
    border-left: 3px solid #059568;
    border-radius: 3px;
    font-size: 10px;
    line-height: 1.5;
    text-align: left;
    color: #1a202c;
  }

  .guidance-box strong {
    color: #0d4b1e;
    font-size: 9.5px;
  }

  /* Recommendation */
  .rec-block {
    padding: 1.5mm 3mm;
    background: rgba(13,110,253,0.04);
    border-left: 3px solid #0d6efd;
    border-radius: 3px;
    font-size: 10px;
    line-height: 1.5;
    text-align: left;
    color: #1a202c;
  }

  .rec-block strong {
    color: #0d4b1e;
    font-size: 9.5px;
  }

  /* Conditions & Restrictions Grid */
  .conditions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5mm;
  }

  .condition-box {
    padding: 1.5mm 3mm;
    border-radius: 3px;
    font-size: 9.5px;
    line-height: 1.4;
    text-align: left;
  }

  .condition-box.conditions {
    background: rgba(255,193,7,0.06);
    border-left: 3px solid #ffc107;
  }

  .condition-box.restrictions {
    background: rgba(220,53,69,0.05);
    border-left: 3px solid #dc3545;
  }

  .condition-box strong {
    font-size: 9px;
    color: #0d4b1e;
  }

  /* References */
  .references {
    padding: 1.5mm 3mm;
    background: rgba(108,117,125,0.05);
    border-radius: 3px;
    font-size: 9px;
    color: #5c5238;
    text-align: center;
    display: flex;
    justify-content: center;
    gap: 3mm;
    flex-wrap: wrap;
    border: 1px dashed rgba(184,134,11,0.2);
  }

  .references .ref-item {
    display: inline-flex;
    align-items: center;
    gap: 0.5mm;
  }

  .references .ref-item .icon {
    font-size: 10px;
  }

  /* Disclaimer */
  .disclaimer {
    font-size: 8.5px;
    font-style: italic;
    color: #5c5238;
    line-height: 1.4;
    margin-top: 1.5mm;
    text-align: center;
    padding: 1mm 2mm;
    border-top: 1px solid rgba(184,134,11,0.15);
  }

  /* Footer Section - Signature & Date */
  .footer-section {
    margin-top: 1.5mm;
    display: grid;
    grid-template-columns: 1fr 2fr 1fr;
    align-items: end;
    gap: 2mm;
    padding-top: 1.5mm;
    border-top: 1px solid rgba(184,134,11,0.15);
  }

  .qr-code { 
    text-align: left; 
  }
  .qr-code img { 
    width: 14mm; 
    height: 14mm; 
    object-fit: contain; 
  }

  .signature-block { 
    text-align: center; 
  }
  .sign-space { 
    height: 6mm; 
  }
  .sign-line { 
    border-top: 1.5px solid #333; 
    width: 70%; 
    margin: 0 auto 1mm; 
  }
  .sign-name { 
    font-weight: 700; 
    font-size: 9.5px; 
    color: #0d4b1e; 
    letter-spacing: 0.5px; 
  }
  .sign-role { 
    font-weight: 600; 
    font-size: 8px; 
    color: #2c2c2c; 
    margin-top: 0.5mm; 
    letter-spacing: 0.5px; 
  }

  .date-block { 
    text-align: right; 
    font-size: 9.5px; 
    color: #2c2c2c; 
  }
  .date-block .input-line {
    display: inline-block;
    min-width: 28mm;
    font-family: 'Times New Roman', serif;
    font-size: 10px;
    font-weight: bold;
    color: #0d4b1e;
    border-bottom: 1.5px solid #b8860b;
    padding: 0 2mm;
  }

  /* Print Styles */
  @media print {
    body { 
      background: #fff !important; 
      width: 210mm;
      min-height: 297mm;
    }
    .certificate { 
      box-shadow: none !important; 
      page-break-inside: avoid;
      margin: 0 auto;
      width: 200mm;
      height: 285mm;
    }
  }

  /* Responsive */
  @media screen and (max-width: 220mm) {
    body { 
      padding: 5mm; 
    }
    .certificate {
      width: 100%;
      height: auto;
      aspect-ratio: 210 / 297;
      margin: 0 auto;
    }
  }
</style>
</head>
<body>
  <div class="certificate">

    <!-- Background Frame -->
    <div class="certificate-bg">
      <img src="{{ asset('assets/certificates/consultancy-frame-portrait.png') }}" alt="">
    </div>

    <!-- Decorative Mosque Silhouette -->
    <img class="mosque-bg" src="{{ asset('assets/certificates/mosque.png') }}" alt="">

    <!-- UMSC Seal - Top Right (kept for official stamp) -->
    

    <!-- Corner Decorations -->
    <div class="corner-decoration corner-tl"></div>
    <div class="corner-decoration corner-tr"></div>
    <div class="corner-decoration corner-bl"></div>
    <div class="corner-decoration corner-br"></div>

    <!-- Main Content -->
    <div class="certificate-content">

      <!-- ========================================================= -->
      <!-- HEADER - With Logo Centered at Top                        -->
      <!-- ========================================================= -->
      <div class="cert-header">
        <!-- Centered Logo -->
        <div class="cert-logo">
          <img src="{{ asset('assets/certificates/umsc-seal.png') }}" alt="UMSC Logo">
        </div>
        <div class="cert-subtitle">DIRECTORATE OF SHARIAH (UMSC)</div>
        <div class="cert-title">CERTIFICATE OF CONSULTATION</div>
        <div class="cert-id">Ref: {{ $certificateNumber ?? $consultancy->application_id }}</div>
      </div>

      <hr class="divider">

      <!-- Verse -->
      <div class="verse-block">
        <div class="verse-arabic">فَسْأَلُوا أَهْلَ الذِّكْرِ إِن كُنتُمْ لَا تَعْلَمُونَ</div>
        <div class="verse-translation">“So ask the people of remembrance if you do not know.”</div>
        <div class="verse-ref">— Surah An-Nahl (16:43)</div>
      </div>

      <hr class="divider">

      <!-- Body -->
      <div class="body-text">

       <!-- Certification Statement -->
<div class="cert-statement">

    <p>
        This is to officially certify that
        <span class="input-line name">{{ strtoupper($consultancy->applicant_name) }}</span>
        appeared before the Directorate of Shariah of the Uganda Muslim Supreme Council (UMSC)
        and formally sought Islamic guidance and religious consultation concerning
        <strong>{{ $consultancy->consultation_type_label }}</strong>.
    </p>

    <p>
        The matter presented for consultation was:
    </p>

    <p style="text-align:center; margin:3mm 0;">
        <span class="input-line subject">
            "{{ $consultancy->subject ?? $consultancy->consultation_type_label }}"
        </span>
    </p>

    <p>
        Following a careful review of the circumstances presented, the relevant rulings and
        principles of the Holy Qur'an, the authentic Sunnah of Prophet Muhammad (ﷺ),
        and the opinions of recognized Islamic jurists were duly considered.
        Appropriate Islamic guidance and recommendations were subsequently provided in
        accordance with the principles of Shariah as understood and applied by the
        Directorate of Shariah, Uganda Muslim Supreme Council.
    </p>

    
</div>
        <!-- ========================================================= -->
        <!-- GO AHEAD - Approval / Clearance                           -->
        <!-- ========================================================= -->
        <div class="approval-box">
          <span class="check">✓</span>
          <strong>DECISION: APPROVED</strong>
          <span class="check">✓</span>
          <br>
          After careful review of the matter presented, the Directorate of Sharia
          <strong>grants its approval</strong> and confirms that the consultation
          is in accordance with Islamic teachings and principles.
        </div>

        <!-- ========================================================= -->
        <!-- ISLAMIC GUIDANCE                                          -->
        <!-- ========================================================= -->
        @if($consultancy->islamic_guidance)
        <div class="guidance-box">
          <strong>📜 Islamic Guidance:</strong><br>
          {{ $consultancy->islamic_guidance }}
        </div>
        @endif

        <!-- ========================================================= -->
        <!-- RECOMMENDATION                                            -->
        <!-- ========================================================= -->
        @if($consultancy->recommendation)
        <div class="rec-block">
          <strong>💡 Recommendation:</strong><br>
          {{ $consultancy->recommendation }}
        </div>
        @endif

        <!-- ========================================================= -->
        <!-- CONDITIONS & RESTRICTIONS                                 -->
        <!-- ========================================================= -->
        @if($consultancy->conditions || $consultancy->restrictions)
        <div class="conditions-grid">
          @if($consultancy->conditions)
          <div class="condition-box conditions">
            <strong>📋 Conditions:</strong><br>
            {{ $consultancy->conditions }}
          </div>
          @endif
          @if($consultancy->restrictions)
          <div class="condition-box restrictions">
            <strong>🚫 Restrictions:</strong><br>
            {{ $consultancy->restrictions }}
          </div>
          @endif
        </div>
        @endif

        <!-- ========================================================= -->
        <!-- REFERENCES                                               -->
        <!-- ========================================================= -->
        @if($consultancy->quran_reference || $consultancy->hadith_reference || $consultancy->scholar_reference)
        <div class="references">
          @if($consultancy->quran_reference)
          <span class="ref-item">
            <span class="icon">📖</span> Qur'an: {{ $consultancy->quran_reference }}
          </span>
          @endif
          @if($consultancy->hadith_reference)
          <span class="ref-item">
            <span class="icon">📚</span> Hadith: {{ $consultancy->hadith_reference }}
          </span>
          @endif
          @if($consultancy->scholar_reference)
          <span class="ref-item">
            <span class="icon">👤</span> Scholar: {{ $consultancy->scholar_reference }}
          </span>
          @endif
        </div>
        @endif
      </div>

      <!-- ========================================================= -->
      <!-- DISCLAIMER                                                -->
      <!-- ========================================================= -->
      
      <!-- ========================================================= -->
      <!-- FOOTER - Signature & Date                                 -->
      <!-- ========================================================= -->
      

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
  </div>
</body>
</html>