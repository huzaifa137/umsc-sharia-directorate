/* UMSC profile page (Patch 12): password form. No jQuery. Same endpoint and rules as before
   (min 8, one uppercase, one symbol, confirmation must match). */
(function () {
    'use strict';
    var form = document.getElementById('prfPassForm');
    if (!form) return;

    var pw = document.getElementById('newPassword');
    var cf = document.getElementById('confirmPassword');
    var btn = document.getElementById('prfPassBtn');
    var rules = {};
    form.querySelectorAll('[data-rule]').forEach(function (li) { rules[li.getAttribute('data-rule')] = li; });

    function state() {
        var v = pw.value;
        return {
            len: v.length >= 8,
            upper: /[A-Z]/.test(v),
            sym: /[^a-zA-Z0-9]/.test(v),
            match: v !== '' && v === cf.value
        };
    }
    function refresh() {
        var s = state(), all = true;
        Object.keys(s).forEach(function (k) {
            rules[k].classList.toggle('is-met', s[k]);
            if (!s[k]) all = false;
        });
        btn.disabled = !all;
    }
    function showErr(id, msg) {
        var p = document.getElementById(id + 'Err');
        var input = document.getElementById(id);
        if (!p) return;
        p.textContent = msg || '';
        p.hidden = !msg;
        input.classList.toggle('is-invalid', !!msg);
        if (msg) input.setAttribute('aria-invalid', 'true'); else input.removeAttribute('aria-invalid');
    }
    function toast(type, msg) { if (window.UMSC) window.UMSC.toast(type, msg); }

    pw.addEventListener('input', refresh);
    cf.addEventListener('input', refresh);

    form.querySelectorAll('[data-toggle-pw]').forEach(function (b) {
        b.addEventListener('click', function () {
            var input = document.getElementById(b.getAttribute('data-toggle-pw'));
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            b.setAttribute('aria-pressed', show ? 'true' : 'false');
            b.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            b.firstElementChild.className = show ? 'bx bx-hide' : 'bx bx-show';
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (btn.disabled) return;
        showErr('newPassword', ''); showErr('confirmPassword', '');
        if (window.UMSC) window.UMSC.busy(btn, true, 'Updating…');

        var token = (form.querySelector('input[name="_token"]') || {}).value
            || (document.querySelector('meta[name="csrf-token"]') || {}).content;

        fetch(form.getAttribute('data-url'), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest' },
            body: JSON.stringify({ newPassword: pw.value, confirmPassword: cf.value })
        }).then(function (r) {
            return r.json().catch(function () { return {}; }).then(function (d) { return { ok: r.ok, status: r.status, d: d }; });
        }).then(function (res) {
            if (res.ok && res.d.status !== false) {
                toast('success', res.d.message || 'Password changed.');
                form.reset(); refresh();
                if (form.getAttribute('data-must-change') === '1') {
                    setTimeout(function () { window.location.href = form.getAttribute('data-dashboard'); }, 1200);
                }
                return;
            }
            if (res.status === 419 || res.status === 401) {
                toast('warning', 'Your session expired. Reload the page and sign in again.');
                return;
            }
            var errs = res.d.errors || {};
            if (errs.newPassword) showErr('newPassword', errs.newPassword[0]);
            if (errs.confirmPassword) showErr('confirmPassword', errs.confirmPassword[0]);
            if (!res.d.errors) toast('error', res.d.message || 'Could not change the password.');
            else (document.querySelector('.is-invalid') || pw).focus();
        }).catch(function () {
            toast('error', 'Network problem. Check your connection and try again.');
        }).then(function () {
            if (window.UMSC) window.UMSC.busy(btn, false);
            refresh();
        });
    });

    refresh();
})();
