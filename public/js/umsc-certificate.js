/* UMSC certificates (Patch 11): fit-to-screen, QR code, print and PDF.
   The sheet is always built at true A4 size; on screen it is only scaled
   down to fit, and the scale is removed before the PDF is captured. */
(function () {
    'use strict';

    var embedded = false;
    try { embedded = window.self !== window.top; } catch (e) { embedded = true; }
    if (embedded) document.documentElement.classList.add('is-embedded');

    var sheet = document.querySelector('.certificate');
    var box = document.querySelector('.cert-box');
    var fit = document.querySelector('.cert-fit');
    if (!sheet || !box || !fit) return;

    function layout() {
        var w = sheet.offsetWidth, h = sheet.offsetHeight;
        var avail = document.documentElement.clientWidth - (embedded ? 0 : 32);
        var s = embedded ? 1 : Math.min(1, avail / w);
        fit.style.transform = s < 1 ? 'scale(' + s + ')' : '';
        box.style.width = Math.round(w * s) + 'px';
        box.style.height = Math.round(h * s) + 'px';
    }
    layout();
    window.addEventListener('resize', layout);

    // Long content: shrink the body text step by step until it fits the sheet.
    function fitBody() {
        var body = sheet.querySelector('.cert-body');
        if (!body) return;
        var f = 1;
        body.style.setProperty('--fit', f);
        while (body.scrollHeight - body.clientHeight > 1 && f > 0.72) {
            f = Math.round((f - 0.04) * 100) / 100;
            body.style.setProperty('--fit', f);
        }
        if (body.scrollHeight - body.clientHeight > 1) sheet.setAttribute('data-overfull', 'true');
    }
    fitBody();
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(fitBody);

    // QR code for the public verification page
    var qr = document.getElementById('qr');
    if (qr && window.QRCode) {
        new window.QRCode(qr, {
            text: qr.getAttribute('data-url'),
            width: 120, height: 120,
            colorDark: '#0d4b1e', colorLight: '#ffffff',
            correctLevel: window.QRCode.CorrectLevel.M
        });
    }

    var back = document.getElementById('certBack');
    if (back) back.addEventListener('click', function () {
        if (window.history.length > 1) window.history.back(); else window.close();
    });

    var printBtn = document.getElementById('certPrint');
    if (printBtn) printBtn.addEventListener('click', function () { window.print(); });

    var dl = document.getElementById('certDownload');
    var loader = document.getElementById('certLoader');
    if (dl) dl.addEventListener('click', function () {
        if (!window.html2pdf) { window.alert('The PDF tool could not be loaded. Check your connection, or use Print and choose "Save as PDF".'); return; }

        dl.disabled = true;
        if (loader) loader.classList.add('is-on');

        // Capture at full size, then put the on-screen scale back.
        fit.style.transform = '';
        var portrait = sheet.getAttribute('data-orientation') === 'portrait';
        var done = function () {
            layout();
            dl.disabled = false;
            if (loader) loader.classList.remove('is-on');
        };

        var ready = document.fonts && document.fonts.ready ? document.fonts.ready : Promise.resolve();
        ready.then(function () {
            return window.html2pdf().set({
                margin: 0,
                filename: sheet.getAttribute('data-filename') || 'certificate.pdf',
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 3, useCORS: true, backgroundColor: '#fefdf9', scrollX: 0, scrollY: 0 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: portrait ? 'portrait' : 'landscape' }
            }).from(sheet).save();
        }).then(done).catch(function () {
            done();
            window.alert('The PDF could not be generated. Use Print and choose "Save as PDF" instead.');
        });
    });
})();
