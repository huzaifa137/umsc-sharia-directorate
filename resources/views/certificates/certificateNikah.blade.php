<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marriage Certificate</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 30px;
            margin: 0;
            font-family: 'Times New Roman', serif;
        }

        .certificate-container {
            width: 1100px;
            /* wider for landscape */
            min-height: 700px;
            /* shorter height */
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
    </style>
</head>

<body>
    <div class="certificate-container">
        <div class="inner-border">
            <div class="header">
                <span>UGANDA MUSLIM</span>
                <div class="logo-area">
                    <span class="sharia-text">SHARIA</span>
                    <img class="logo-img" src="logo-png.png" alt="UMSC Logo" style="width:100px;">
                    <span class="sharia-text">DIRECTORATE</span>
                </div>
                <span>SUPREME COUNCIL</span>
            </div>

            <div class="cert-title">CERTIFICATE OF MARRIAGE</div>

            <div class="photo-section">
                <div class="box-container">
                    <div class="photo-box"></div>
                    <div class="label-text">GROOM</div>
                </div>

                <div class="center-content">
                    <div class="main-content">
                        This record of marriage between<br>
                        <span class="input-line name"></span><br>
                        and<br>
                        <span class="input-line name"></span><br>
                        was lawfully solemnized in accordance to<br>
                        Islamic Sharia at Masjid <span class="input-line" style="min-width:450px"></span><br>
                        officiated by Imam <span class="input-line" style="min-width:487px"></span>
                    </div>
                </div>

                <div class="box-container">
                    <div class="photo-box"></div>
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
                    <div class="qr-code">OFFICIAL<br>SEAL</div>
                    <div class="signature-block">
                        PROF. DR. ZIYAD S. LUBANGA<br>
                        DIRECTOR OF SHARIA
                    </div>
                    <div class="reg-info">Date of Issue: _________________</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>