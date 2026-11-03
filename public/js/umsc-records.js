/* UMSC record page (Patch 9). No dependencies; uses window.UMSC and Swal when present. */
(function () {
    'use strict';

    var root = document.getElementById('rec');
    if (!root) return;

    var csrf = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
    var toast = function (type, msg) {
        if (window.UMSC && UMSC.toast) UMSC.toast(type, msg);
    };

    /* ---- National ID: masked until someone asks ---------------------------- */
    root.addEventListener('click', function (e) {
        var btn = e.target.closest('[data-rec-reveal]');
        if (!btn) return;
        var span = btn.parentNode.querySelector('.rec-nin');
        if (!span) return;
        var shown = btn.getAttribute('aria-pressed') === 'true';
        span.textContent = shown ? span.dataset.masked : span.dataset.full;
        btn.setAttribute('aria-pressed', shown ? 'false' : 'true');
        btn.textContent = shown ? 'Show' : 'Hide';
    });

    /* ---- Copy reference ----------------------------------------------------- */
    var copy = root.querySelector('[data-rec-copy]');
    if (copy) {
        copy.addEventListener('click', function () {
            var ref = root.dataset.reference || '';
            var done = function () { toast('success', 'Reference copied'); };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(ref).then(done, function () { toast('error', 'Could not copy'); });
            } else {
                var t = document.createElement('textarea');
                t.value = ref; document.body.appendChild(t); t.select();
                try { document.execCommand('copy'); done(); } catch (err) { toast('error', 'Could not copy'); }
                document.body.removeChild(t);
            }
        });
    }

    /* ---- Print ---------------------------------------------------------------- */
    var print = root.querySelector('[data-rec-print]');
    if (print) print.addEventListener('click', function () { window.print(); });

    /* ---- Status decision --------------------------------------------------------- */
    var buttons = root.querySelectorAll('[data-rec-status]');
    function lock(on) {
        buttons.forEach(function (b) { b.disabled = on; });
    }
    buttons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var value = btn.dataset.recStatus;
            var label = btn.dataset.label || value;
            var danger = btn.classList.contains('rec-decide__btn--bad');

            var ask = (window.UMSC && UMSC.confirm)
                ? UMSC.confirm({
                    title: 'Mark this record as ' + label.toLowerCase() + '?',
                    text: 'The change is recorded in the history of this record.',
                    confirmText: 'Mark as ' + label.toLowerCase(),
                    cancelText: 'Cancel',
                    danger: danger
                })
                : Promise.resolve(window.confirm('Mark this record as ' + label + '?'));

            ask.then(function (ok) {
                if (!ok) return;
                lock(true);
                fetch(root.dataset.endpoint, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({ status: value })
                }).then(function (res) {
                    return res.text().then(function (txt) {
                        var data = {};
                        try { data = JSON.parse(txt); } catch (err) { /* non-JSON: treat as failure below */ }
                        return { ok: res.ok && data.success !== false, data: data };
                    });
                }).then(function (r) {
                    if (r.ok) {
                        toast('success', 'Status updated');
                        window.setTimeout(function () { window.location.reload(); }, 600);
                    } else {
                        lock(false);
                        toast('error', (r.data && r.data.message) || 'The status could not be changed.');
                    }
                }).catch(function () {
                    lock(false);
                    toast('error', 'Network problem. Nothing was changed.');
                });
            });
        });
    });

    /* ---- Section index follows the reader ------------------------------------------ */
    var links = Array.prototype.slice.call(root.querySelectorAll('[data-rec-nav]'));
    if (links.length && 'IntersectionObserver' in window) {
        var map = {};
        links.forEach(function (a) { map[a.dataset.recNav] = a; });
        var current = null;
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) current = en.target.id;
            });
            if (current && map[current]) {
                links.forEach(function (a) { a.classList.remove('is-active'); a.removeAttribute('aria-current'); });
                map[current].classList.add('is-active');
                map[current].setAttribute('aria-current', 'true');
            }
        }, { rootMargin: '-90px 0px -65% 0px', threshold: 0 });
        Object.keys(map).forEach(function (id) {
            var el = document.getElementById(id);
            if (el) io.observe(el);
        });
        links[0].classList.add('is-active');
    }
})();
