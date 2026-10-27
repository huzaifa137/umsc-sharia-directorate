{{-- Shared certificate look & feel, v3 — landscape A4. Photos are back
     (grouped with each person's name/details rather than in a separate
     row, which is what makes the two-column layout work in less height). --}}
<style>
    html, body {
        margin: 0;
        padding: 0;
        background: #fff;
    }

    body {
        width: 297mm;
        min-height: 210mm;
        margin: auto;
        background: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
    }

    * { box-sizing: border-box; }

    .certificate {
        width: 287mm;
        height: 200mm;
        position: relative;
        margin: 5mm auto;
        background: #fdfbf3;
        overflow: hidden; /* safety net: content can never escape the page */
    }

    .certificate-bg {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
    }

    .certificate-bg img {
        width: 100%;
        height: 100%;
        object-fit: fill;
        display: block;
    }

    .certificate-content {
        position: absolute;
        left: 26mm;
        right: 26mm;
        top: 12mm;
        bottom: 10mm;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .cert-app-id {
        position: absolute;
        top: 0;
        right: 0;
        font-size: 7px;
        color: #9a8452;
        letter-spacing: 0.5px;
    }

    /* ---- Compact header row: seal + title side by side, not stacked ---- */
    .cert-header-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5mm;
        margin-bottom: 2mm;
    }

    .cert-seal img {
        height: 15mm;
        width: auto;
    }

    .cert-title-wrap {
        text-align: left;
    }

    .cert-dua {
        font-size: 8px;
        color: #0d4b1e;
        direction: rtl;
        font-family: 'Traditional Arabic', 'Amiri', 'Times New Roman', serif;
    }

    .cert-title-en {
        font-size: 17px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #0d4b1e;
        text-transform: uppercase;
        line-height: 1.1;
    }

    .cert-title-ar {
        direction: rtl;
        font-family: 'Traditional Arabic', 'Amiri', 'Times New Roman', serif;
        font-size: 12px;
        font-weight: 700;
        color: #a97e1f;
    }

    .cert-quote {
        font-size: 8px;
        color: #6b5f3d;
        font-style: italic;
        line-height: 1.35;
        max-width: 210mm;
        margin-bottom: 2mm;
    }

    .cert-preamble {
        font-size: 9px;
        color: #2c2c2c;
        line-height: 1.4;
        max-width: 220mm;
        margin-bottom: 2.5mm;
    }

    .cert-preamble .fill {
        font-weight: 700;
        color: #0d4b1e;
        border-bottom: 1px solid #c9a227;
        padding: 0 2px;
    }

    /* ---- Two-column parties row: photo + name + parent, side by side ---- */
    .cert-parties {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 16mm;
        width: 100%;
        max-width: 220mm;
        margin-bottom: 2.5mm;
    }

    .cert-parties .party {
        display: flex;
        align-items: center;
        gap: 4mm;
        text-align: left;
    }

    .cert-parties .party.reverse {
        text-align: right;
        flex-direction: row-reverse;
    }

    .cert-parties .photo-frame {
        width: 18mm;
        height: 22mm;
        flex-shrink: 0;
        border: 2px solid #c9a227;
        border-radius: 3px;
        overflow: hidden;
        background: #f7f4ec;
    }

    .cert-parties .photo-frame img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cert-parties .details {
        flex: 1;
        min-width: 0;
    }

    .cert-parties .col-title {
        font-size: 9px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #0d4b1e;
        margin-bottom: 1mm;
    }

    .cert-parties .col-name {
        font-size: 12px;
        font-weight: 700;
        color: #2c2c2c;
        border-bottom: 1px solid #2c2c2c;
        padding-bottom: 1mm;
        margin-bottom: 1mm;
        line-height: 1.25;
    }

    .cert-parties .col-parent {
        font-size: 8px;
        color: #5c5238;
    }

    .cert-parties .col-parent .fill {
        font-weight: 700;
        color: #2c2c2c;
    }

    .cert-blessing {
        font-size: 8.5px;
        color: #6b5f3d;
        line-height: 1.4;
        max-width: 220mm;
        margin-bottom: 2.5mm;
    }

    .cert-witnesses-title {
        font-size: 8.5px;
        font-weight: 800;
        letter-spacing: 1px;
        color: #0d4b1e;
        margin-bottom: 1mm;
    }

    .cert-witnesses {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1mm 16mm;
        width: 100%;
        max-width: 220mm;
        font-size: 9px;
        margin-bottom: 2.5mm;
    }

    .cert-witnesses .w-name {
        font-weight: 700;
        color: #2c2c2c;
        border-bottom: 1px solid #d8c896;
        padding-bottom: 0.5mm;
    }

    .cert-info-line {
        font-size: 8.5px;
        color: #5c5238;
        margin-bottom: 2mm;
    }

    .cert-info-line .fill {
        font-weight: 700;
        color: #0d4b1e;
    }

    /* Footer: exactly one signature (Director for Sharia) + QR + date/place */
    .cert-footer {
        width: 100%;
        max-width: 230mm;
        margin-top: auto;
        padding-top: 2.5mm;
        border-top: 1px dashed #d8c896;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .cert-footer .sign-block {
        text-align: center;
        width: 55mm;
    }

    .cert-footer .sign-block .line {
        border-top: 1.2px solid #2c2c2c;
        margin-bottom: 1.5mm;
        padding-top: 1mm;
        font-size: 9.5px;
        font-weight: 700;
        color: #0d4b1e;
    }

    .cert-footer .sign-block .role-en {
        font-size: 8px;
        color: #2c2c2c;
    }

    .cert-footer .sign-block .role-ar {
        direction: rtl;
        font-family: 'Traditional Arabic', 'Amiri', 'Times New Roman', serif;
        font-size: 8.5px;
        color: #a97e1f;
        margin-top: 0.5mm;
    }

    .cert-footer .qr-block {
        text-align: center;
    }

    .cert-footer .qr-block #qr {
        display: inline-block;
    }

    .cert-footer .qr-block .caption {
        font-size: 6px;
        color: #9a8452;
        margin-top: 1mm;
    }

    .cert-footer .date-block {
        text-align: right;
        width: 40mm;
        font-size: 8.5px;
    }

    .cert-footer .date-block .row {
        margin-bottom: 1mm;
    }

    .cert-footer .date-block .label {
        color: #9a8452;
        font-size: 6.5px;
        text-transform: uppercase;
        display: block;
    }

    .cert-footer .date-block .value {
        font-weight: 700;
        color: #0d4b1e;
    }

    @media print {
        body { padding: 0 !important; }
        .no-print { display: none !important; }
        .certificate { box-shadow: none !important; page-break-inside: avoid; }
    }
</style>
