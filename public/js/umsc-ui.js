/* UMSC shared UI helpers (Patch 6). No dependencies beyond SweetAlert2, which the
   layout already loads. Exposes window.UMSC.{toast, confirm, busy, skeleton}. */
(function () {
    'use strict';

    var TONE = { success: 'success', error: 'error', warning: 'warning', info: 'info' };
    var toaster = null;

    function getToaster() {
        if (toaster || !window.Swal) return toaster;
        toaster = window.Swal.mixin({
            toast: true, position: document.documentElement.dir === 'rtl' ? 'top-start' : 'top-end',
            showConfirmButton: false, timer: 4200, timerProgressBar: true,
            didOpen: function (el) {
                el.addEventListener('mouseenter', window.Swal.stopTimer);
                el.addEventListener('mouseleave', window.Swal.resumeTimer);
            }
        });
        return toaster;
    }

    /** UMSC.toast('success', 'Saved') */
    function toast(type, message) {
        var t = getToaster();
        var tone = TONE[type] || 'info';
        if (!t) { return; }
        t.fire({ icon: tone, title: message, customClass: { popup: 'ui-toast--' + tone } });
    }

    /** UMSC.confirm({ title, text, confirmText, cancelText, danger }) -> Promise<boolean> */
    function confirm(o) {
        o = o || {};
        if (!window.Swal) return Promise.resolve(window.confirm(o.title || 'Are you sure?'));
        return window.Swal.fire({
            title: o.title || 'Are you sure?', text: o.text || '', icon: o.danger ? 'warning' : 'question',
            showCancelButton: true, reverseButtons: true,
            confirmButtonText: o.confirmText || 'Confirm', cancelButtonText: o.cancelText || 'Cancel',
            confirmButtonColor: o.danger ? '#a8322a' : '#136a3b', cancelButtonColor: '#66756c'
        }).then(function (r) { return !!r.isConfirmed; });
    }

    /** UMSC.busy(button, true, 'Saving…') keeps the original label for when it's switched off. */
    function busy(btn, on, label) {
        if (!btn) return;
        if (on) {
            if (btn.getAttribute('data-label') === null) btn.setAttribute('data-label', btn.innerHTML);
            btn.disabled = true;
            if (label) btn.textContent = label;
        } else {
            var old = btn.getAttribute('data-label');
            if (old !== null) { btn.innerHTML = old; btn.removeAttribute('data-label'); }
            btn.disabled = false;
        }
    }

    /** UMSC.skeleton(container, true, 4) fills a container with placeholder lines; false clears it. */
    function skeleton(el, on, lines) {
        if (!el) return;
        if (!on) { el.classList.remove('ui-loading'); var s = el.querySelector(':scope > .ui-skel-wrap'); if (s) s.remove(); return; }
        var wrap = document.createElement('div');
        wrap.className = 'ui-skel-wrap'; wrap.setAttribute('aria-hidden', 'true');
        var title = document.createElement('div'); title.className = 'ui-skel ui-skel--title'; wrap.appendChild(title);
        for (var i = 0; i < (lines || 4); i++) {
            var l = document.createElement('div'); l.className = 'ui-skel ui-skel--line';
            l.style.width = (100 - (i % 3) * 14) + '%'; wrap.appendChild(l);
        }
        el.appendChild(wrap);
    }

    /** UMSC.esc(text) escapes text before it goes into innerHTML. */
    function esc(s) {
        return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
        });
    }

    // Laravel flash messages: <div data-ui-flash="success" hidden>Saved</div>
    function flash() {
        document.querySelectorAll('[data-ui-flash]').forEach(function (n) {
            toast(n.getAttribute('data-ui-flash'), n.textContent.trim());
            n.remove();
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', flash); else flash();

    window.UMSC = Object.assign(window.UMSC || {}, { toast: toast, confirm: confirm, busy: busy, skeleton: skeleton, esc: esc });
})();
