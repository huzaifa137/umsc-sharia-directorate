/* ==========================================================================
   UMSC Directorate of Sharia: application form enhancer (Patch 8)

   The six application forms keep their own step logic, validation and submit
   handlers. This file never replaces any of that. It only:

   1. tags the existing markup with classes that umsc-forms.css styles;
   2. mirrors the current step onto the step list (data-uf), because not every
      form toggles the same classes;
   3. shows a short message under a field when the form's own validation marks
      it .is-invalid, and clears it again when the field is fixed;
   4. stops Enter inside a text field from submitting a half-finished form;
   5. warns before the tab is closed once something has been typed.
   ========================================================================== */
(function () {
    'use strict';
    if (!document.body.classList.contains('umsc-form')) return;

    var $ = function (s, r) { return (r || document).querySelector(s); };
    var $$ = function (s, r) { return Array.prototype.slice.call((r || document).querySelectorAll(s)); };

    /** Climb from `el` until the ancestor whose parent is `stop`. */
    function childOf(stop, el) {
        while (el && el.parentElement !== stop) el = el.parentElement;
        return el;
    }

    /* ---------- 1. Tag the stepper layout (Divorce, Guardianship, Inheritance, Convert) ---------- */
    var form = $('#multiStepForm');
    var wrap = form && childOf(document.body, form);
    if (wrap) {
        // wrap is the nearest ancestor under <main>; walk up to the two-pane root
        var root = form.closest('div[style*="min-height: 100vh"]');
        if (root && root.children.length >= 2) {
            wrap = root;
            wrap.classList.add('uf-wrap');
            var rail = wrap.children[0];
            var pane = wrap.children[1];
            rail.classList.add('uf-rail');
            pane.classList.add('uf-pane');

            var bar = $('#progressBar', rail);
            if (bar) {
                var pb = childOf(rail, bar);
                // the block that holds the progress card sits inside the sticky header; tag the card itself
                var card = bar.parentElement && bar.parentElement.parentElement;
                if (card) card.classList.add('uf-progress');
                if (pb) pb.classList.add('uf-rail__head');
            }
            var first = $('#stepIndicator1', rail) || $('.step-indicator', rail);
            var list = first && first.parentElement;
            if (list) list.classList.add('uf-steps');

            // Some forms nest the instructions inside the same wrapper as the title, others
            // place them beside the step list; either way they share a parent with the list.
            var instr = $('[data-i18n="instructions_title"]', rail);
            if (instr && list) {
                var ib = childOf(list.parentElement, instr);
                if (ib && ib !== list && !ib.contains(list)) ib.classList.add('uf-note');
            }

            var title = $('#currentStepTitle', pane);
            if (title) {
                var head = childOf(pane, title);
                if (head) head.classList.add('uf-pane__head');
            }

            $$('.form-step', form).forEach(function (step) {
                var panel = step.firstElementChild;
                if (panel) {
                    panel.classList.add('uf-panel');
                    var ph = panel.firstElementChild;
                    // decorative circles come first, then the numbered header row
                    var kids = Array.prototype.slice.call(panel.children);
                    kids.forEach(function (k) {
                        if (k.querySelector && k.querySelector('h3') && !k.classList.contains('uf-panel__head') &&
                            !k.querySelector('input,select,textarea')) {
                            k.classList.add('uf-panel__head');
                        }
                    });
                }
            });

            // The bar is the nearest ancestor that holds both Previous and Next
            // (Divorce wraps them directly, Convert nests them in two groups).
            var prev = $('#prevBtn');
            var nextB = $('#nextBtn');
            if (prev && nextB) {
                var bar2 = prev.parentElement;
                while (bar2 && !bar2.contains(nextB)) bar2 = bar2.parentElement;
                if (bar2 && bar2 !== form) bar2.classList.add('uf-actions');
            }
        }
    }

    // Field cards (label + control) so inline messages have a predictable home.
    $$('.uf-panel div[style]').forEach(function (d) {
        if (/rgba\(255,\s*255,\s*255,\s*0\.\d+\)/.test(d.getAttribute('style')) && d.querySelector(':scope > label')) {
            d.classList.add('uf-field');
        }
    });

    // Step titles in the list are filled by each form's translation pass; if that has not
    // happened yet, fill them from the form's own dictionary so the list is never blank.
    try {
        if (typeof translations !== 'undefined') {
            var L = translations[lang()] || translations.en || {};
            $$('.step-indicator [data-i18n]').forEach(function (el) {
                if (!el.textContent.trim() && L[el.getAttribute('data-i18n')]) el.textContent = L[el.getAttribute('data-i18n')];
            });
        }
    } catch (e) { /* the form's own script owns translations */ }

    var steps = $$('.form-step');
    var indicators = $$('.step-indicator');

    /* ---------- 2. Mirror the current step ---------- */
    function currentIndex() {
        // The forms show one step by setting its inline display; fall back to the first visible one.
        var shown = -1;
        steps.forEach(function (s, i) { if (s.style.display === 'block' || s.style.display === 'flex') shown = i; });
        if (shown > -1) return shown;
        steps.forEach(function (s, i) { if (shown === -1 && s.style.display !== 'none') shown = i; });
        return shown < 0 ? 0 : shown;
    }

    function syncSteps() {
        if (!steps.length) return;
        var cur = currentIndex();
        indicators.forEach(function (el, i) {
            el.setAttribute('data-uf', i < cur ? 'done' : (i === cur ? 'current' : 'todo'));
            if (i === cur) el.setAttribute('aria-current', 'step'); else el.removeAttribute('aria-current');
        });
        document.documentElement.style.setProperty('--uf-step', String(cur + 1));
        document.documentElement.style.setProperty('--uf-steps', String(steps.length));
        var wrapEl = $('.uf-wrap');
        if (wrapEl) wrapEl.setAttribute('data-uf-last', cur === steps.length - 1 ? 'true' : 'false');
    }

    if (steps.length) {
        syncSteps();
        var mo = new MutationObserver(syncSteps);
        steps.forEach(function (s) { mo.observe(s, { attributes: true, attributeFilter: ['style', 'class'] }); });
    }

    /* ---------- 3. Inline field messages ---------- */
    var MSG = {
        en: 'This field is required.',
        ar: 'هذا الحقل مطلوب.',
        sw: 'Sehemu hii inahitajika.'
    };
    function lang() { return (document.documentElement.lang || 'en').slice(0, 2); }

    function holderOf(field) {
        // the nearest wrapper that holds the label and the control
        return field.closest('.uf-field') || field.closest('.form-group') || field.parentElement;
    }
    function showError(field) {
        var h = holderOf(field);
        if (!h || h.querySelector(':scope > .uf-err')) return;
        var p = document.createElement('p');
        p.className = 'uf-err';
        p.setAttribute('role', 'alert');
        p.textContent = MSG[lang()] || MSG.en;
        h.appendChild(p);
    }
    function clearError(field) {
        var h = holderOf(field);
        var e = h && h.querySelector(':scope > .uf-err');
        if (e) e.remove();
    }
    var fieldObserver = new MutationObserver(function (list) {
        list.forEach(function (m) {
            var t = m.target;
            if (!t.matches || !t.matches('input,select,textarea')) return;
            if (t.classList.contains('is-invalid')) showError(t); else clearError(t);
        });
    });
    $$('input,select,textarea').forEach(function (f) {
        fieldObserver.observe(f, { attributes: true, attributeFilter: ['class'] });
        var clear = function () { if (f.value && f.classList.contains('is-invalid')) { f.classList.remove('is-invalid'); clearError(f); } };
        f.addEventListener('input', clear);
        f.addEventListener('change', clear);
    });

    /* ---------- 4. Enter should move forward, not submit early ---------- */
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Enter' || e.isComposing) return;
        var t = e.target;
        if (!t || t.tagName !== 'INPUT') return;
        if (['text', 'tel', 'email', 'number', 'date', 'search', 'password', 'url'].indexOf(t.type) === -1) return;
        if (t.closest('.select2-container, .select2-dropdown')) return;
        var submit = $('#submitBtn');
        var next = $('#nextBtn');
        // Only on the multi-step forms, and only while the submit button is still hidden.
        if (!submit || !next || !t.form) return;
        if (submit.style.display !== 'none' && submit.style.display !== '') return;
        if (next.style.display === 'none') return;
        e.preventDefault();
        next.click();
    });

    /* ---------- 5. Unsaved-changes guard ---------- */
    var dirty = false;
    var guarded = $('#multiStepForm') || $('#nikkahForm');
    if (guarded) {
        guarded.addEventListener('input', function () { dirty = true; }, { once: true });
        guarded.addEventListener('change', function () { dirty = true; }, { once: true });
        guarded.addEventListener('submit', function () { window.__ufLeaving = true; });
        window.addEventListener('beforeunload', function (e) {
            if (!dirty || window.__ufLeaving) return;
            e.preventDefault();
            e.returnValue = '';
        });
    }
})();
