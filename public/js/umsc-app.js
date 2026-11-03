/* UMSC staff shell: language, global search (command palette), notifications, logout.
   Vanilla JS, no globals except window.UMSCShell. Reads its settings from #umsc-shell-config.
   Deliberately avoids the names `translations` and `changeLanguage` because several
   pages declare those themselves. */
(function () {
    'use strict';

    var cfgEl = document.getElementById('umsc-shell-config');
    if (!cfgEl) return;
    var cfg = cfgEl.dataset;
    var STORAGE_KEY = 'app_language';
    var LANGS = ['en', 'sw', 'ar'];

    /* ------------------------------------------------------------------
       1. Shell dictionary. English is the markup default; sw/ar are applied
          to every [data-shell], [data-shell-placeholder] element.
          NOTE: please have a native speaker review the sw/ar wording.
       ------------------------------------------------------------------ */
    var T = {
        sw: {
            brand_name: 'Idara ya Sharia', brand_sub: 'Baraza Kuu la Waislamu Uganda',
            g_overview: 'Muhtasari', g_services: 'Huduma', g_records: 'Rekodi na Uchapishaji', g_admin: 'Utawala', g_comms: 'Mawasiliano',
            dashboard: 'Dashibodi', nikah: 'Nikah', divorce: 'Talaka', inheritance: 'Mirathi', guardianship: 'Ulezi', converts: 'Waliosilimu', consultancy: 'Ushauri',
            application: 'Maombi', new_consultation: 'Ushauri Mpya', all_consultations: 'Ushauri Wote',
            certificates: 'Vyeti', fatwa: 'Fatwa', bulk_import: 'Uingizaji kwa Wingi', reports: 'Ripoti', activity_logs: 'Kumbukumbu za Shughuli',
            users: 'Watumiaji', add_users: 'Ongeza Watumiaji', manage_users: 'Simamia Watumiaji', roles_privileges: 'Majukumu na Ruhusa',
            chat: 'Mazungumzo', side_foot: 'Maafisa walioidhinishwa pekee. Shughuli zote zinarekodiwa.',
            search_hint: 'Tafuta maombi, majina, namba…', scope_all: 'Yote',
            notifications: 'Arifa', all_caught_up: 'Hakuna arifa mpya.', unread_messages: 'ujumbe ambao haujasomwa', public_site: 'Tovuti ya umma',
            pal_navigate: 'sogea', pal_open: 'fungua', pal_close: 'funga',
            quick_links: 'Viungo vya haraka', results: 'Matokeo', type_more: 'Andika angalau herufi 2 kutafuta.',
            searching: 'Inatafuta…', no_results: 'Hakuna matokeo.', search_failed: 'Utafutaji umeshindikana. Jaribu tena.', session_expired: 'Kipindi chako kimeisha. Ingia tena.',
            logout_title: 'Una uhakika?', logout_text: 'Utatolewa kwenye kipindi chako.', logout_yes: 'Ndiyo, nitoe', logout_no: 'Ghairi'
        },
        ar: {
            brand_name: 'مديرية الشريعة', brand_sub: 'المجلس الأعلى لمسلمي أوغندا',
            g_overview: 'نظرة عامة', g_services: 'الخدمات', g_records: 'السجلات والنشر', g_admin: 'الإدارة', g_comms: 'التواصل',
            dashboard: 'لوحة التحكم', nikah: 'النكاح', divorce: 'الطلاق', inheritance: 'الميراث', guardianship: 'الولاية', converts: 'المهتدون الجدد', consultancy: 'الاستشارات',
            application: 'الطلب', new_consultation: 'استشارة جديدة', all_consultations: 'كل الاستشارات',
            certificates: 'الشهادات', fatwa: 'الفتاوى', bulk_import: 'الاستيراد الجماعي', reports: 'التقارير', activity_logs: 'سجل النشاط',
            users: 'المستخدمون', add_users: 'إضافة مستخدمين', manage_users: 'إدارة المستخدمين', roles_privileges: 'الأدوار والصلاحيات',
            chat: 'المحادثات', side_foot: 'للموظفين المصرّح لهم فقط. يتم تسجيل كل النشاط.',
            search_hint: 'ابحث في الطلبات والأسماء والأرقام…', scope_all: 'الكل',
            notifications: 'الإشعارات', all_caught_up: 'لا توجد إشعارات جديدة.', unread_messages: 'رسائل غير مقروءة', public_site: 'الموقع العام',
            pal_navigate: 'تنقل', pal_open: 'فتح', pal_close: 'إغلاق',
            quick_links: 'روابط سريعة', results: 'النتائج', type_more: 'اكتب حرفين على الأقل للبحث.',
            searching: 'جارٍ البحث…', no_results: 'لا توجد نتائج.', search_failed: 'فشل البحث. حاول مرة أخرى.', session_expired: 'انتهت جلستك. سجّل الدخول مرة أخرى.',
            logout_title: 'هل أنت متأكد؟', logout_text: 'سيتم تسجيل خروجك من الجلسة.', logout_yes: 'نعم، سجّل خروجي', logout_no: 'إلغاء'
        }
    };
    var EN = {}; // filled from the DOM on first run so English always matches the markup

    function captureEnglish() {
        document.querySelectorAll('[data-shell]').forEach(function (el) {
            var k = el.getAttribute('data-shell');
            if (!(k in EN)) EN[k] = el.textContent.trim();
        });
        document.querySelectorAll('[data-shell-placeholder]').forEach(function (el) {
            var k = el.getAttribute('data-shell-placeholder');
            if (el.tagName === 'INPUT') { if (!('ph:' + k in EN)) EN['ph:' + k] = el.getAttribute('placeholder') || ''; }
            else if (!(k in EN)) EN[k] = el.textContent.trim();
        });
        // English strings used only from JS
        EN.quick_links = 'Quick links'; EN.results = 'Results'; EN.type_more = 'Type at least 2 characters to search.';
        EN.searching = 'Searching…'; EN.no_results = 'No results found.'; EN.search_failed = 'Search failed. Please try again.';
        EN.session_expired = 'Your session has expired. Please sign in again.';
        EN.logout_title = 'Are you sure?'; EN.logout_text = 'You will be logged out of your session.';
        EN.logout_yes = 'Yes, log me out'; EN.logout_no = 'Cancel';
    }

    var currentLang = 'en';
    function t(key) {
        if (currentLang !== 'en' && T[currentLang] && T[currentLang][key] !== undefined) return T[currentLang][key];
        return EN[key] !== undefined ? EN[key] : key;
    }

    /* ------------------------------------------------------------------
       2. Language
       ------------------------------------------------------------------ */
    function applyShellLanguage(lang) {
        currentLang = lang;
        document.querySelectorAll('[data-shell]').forEach(function (el) {
            var k = el.getAttribute('data-shell');
            var v = (lang === 'en') ? EN[k] : (T[lang] && T[lang][k]);
            if (v !== undefined) el.textContent = v;
        });
        document.querySelectorAll('[data-shell-placeholder]').forEach(function (el) {
            var k = el.getAttribute('data-shell-placeholder');
            if (el.tagName === 'INPUT') {
                var v = (lang === 'en') ? EN['ph:' + k] : (T[lang] && T[lang][k]);
                if (v !== undefined) el.setAttribute('placeholder', v);
            } else {
                var v2 = (lang === 'en') ? EN[k] : (T[lang] && T[lang][k]);
                if (v2 !== undefined) el.textContent = v2;
            }
        });
        document.documentElement.lang = lang;
        document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';

        var label = document.getElementById('shell-lang-label');
        if (label) label.textContent = lang === 'ar' ? 'ع' : lang.toUpperCase();
        document.querySelectorAll('#shell-lang-menu .dropdown-item').forEach(function (a) {
            a.classList.toggle('is-active', a.getAttribute('data-lang') === lang);
        });
    }

    // Keep the server session locale in step so __() strings and the public
    // site follow the staff member's choice. redirect:'manual' avoids
    // downloading the page the route redirects back to.
    function syncServerLocale(lang) {
        try {
            fetch(cfg.langUrl + '/' + lang, { credentials: 'same-origin', redirect: 'manual', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .catch(function () { });
        } catch (e) { }
    }

    function setLanguage(lang, fromUser) {
        if (LANGS.indexOf(lang) === -1) return;
        try { localStorage.setItem(STORAGE_KEY, lang); } catch (e) { }
        applyShellLanguage(lang);

        if (fromUser) {
            // Let page-level translators follow (dashboard buttons / form engine), if present.
            var dash = document.querySelector('.dash-lang-btn[data-lang="' + lang + '"]');
            if (dash) dash.click();
            if (typeof window.changeLanguage === 'function') { try { window.changeLanguage(lang); } catch (e) { } }
            syncServerLocale(lang);
        }
        document.dispatchEvent(new CustomEvent('umsc:langchange', { detail: { lang: lang } }));
    }

    function initLanguage() {
        captureEnglish();
        var stored = null;
        try { stored = localStorage.getItem(STORAGE_KEY); } catch (e) { }
        var lang = (stored && LANGS.indexOf(stored) !== -1) ? stored : (cfg.serverLocale || 'en');
        if (LANGS.indexOf(lang) === -1) lang = 'en';
        applyShellLanguage(lang);

        // If the stored choice and the server session disagree, align the server once per tab.
        if (lang !== cfg.serverLocale && !sessionStorage.getItem('umsc_lang_synced_' + lang)) {
            try { sessionStorage.setItem('umsc_lang_synced_' + lang, '1'); } catch (e) { }
            syncServerLocale(lang);
        }

        var menu = document.getElementById('shell-lang-menu');
        if (menu) menu.addEventListener('click', function (e) {
            var a = e.target.closest('[data-lang]');
            if (!a) return;
            e.preventDefault();
            setLanguage(a.getAttribute('data-lang'), true);
        });
    }

    /* ------------------------------------------------------------------
       3. Logout confirmation (keeps the existing SweetAlert flow)
       ------------------------------------------------------------------ */
    function initLogout() {
        var btn = document.getElementById('logout-btn');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            if (!window.Swal) { window.location.href = cfg.logoutUrl; return; }
            window.Swal.fire({
                title: t('logout_title'), text: t('logout_text'), icon: 'warning',
                showCancelButton: true, confirmButtonColor: '#136a3b', cancelButtonColor: '#5d6b62',
                confirmButtonText: t('logout_yes'), cancelButtonText: t('logout_no'), reverseButtons: true
            }).then(function (r) { if (r.isConfirmed) window.location.href = cfg.logoutUrl; });
        });
    }

    /* ------------------------------------------------------------------
       4. Notifications: chat unread count (sidebar badge + bell)
       ------------------------------------------------------------------ */
    function initNotifications() {
        if (!cfg.chatUnreadUrl) return;
        var sideBadge = document.getElementById('sidebar-chat-badge');
        var bell = document.getElementById('topbar-chat-badge');
        var empty = document.getElementById('notes-empty');
        var item = document.getElementById('notes-chat');
        var count = document.getElementById('notes-chat-count');

        function render(n) {
            var txt = n > 99 ? '99+' : String(n);
            [sideBadge, bell].forEach(function (el) {
                if (!el) return;
                el.textContent = txt;
                el.classList.toggle('d-none', n <= 0);
            });
            if (empty) empty.classList.toggle('d-none', n > 0);
            if (item) item.classList.toggle('d-none', n <= 0);
            if (count) count.textContent = txt;
        }
        function refresh() {
            if (document.hidden) return;
            fetch(cfg.chatUnreadUrl, { credentials: 'same-origin', headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function (r) { return r.json(); })
                .then(function (d) { render(d && d.status ? (parseInt(d.count, 10) || 0) : 0); })
                .catch(function () { });
        }
        refresh();
        setInterval(refresh, 15000);
        document.addEventListener('visibilitychange', function () { if (!document.hidden) refresh(); });
    }

    /* ------------------------------------------------------------------
       5. Command palette (global search over /smart-search)
       ------------------------------------------------------------------ */
    var MODULE_ROUTES = { nikah: '/records/nikah/', divorce: '/records/divorce/', inheritance: '/records/inheritance/', guardianship: '/records/guardianship/', convert: '/records/convert/' };
    var MODULE_LABEL = { nikah: 'Nikah', divorce: 'Divorce', inheritance: 'Inheritance', guardianship: 'Guardianship', convert: 'Convert' };
    var MODULE_ICON = { nikah: 'bx-heart-circle', divorce: 'bx-unlink', inheritance: 'bx-briefcase-alt-2', guardianship: 'bx-shield-quarter', convert: 'bx-user-plus' };

    function esc(s) { return String(s == null ? '' : s).replace(/[&<>"']/g, function (c) { return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[c]; }); }

    function initPalette() {
        var pal = document.getElementById('shell-palette');
        var input = document.getElementById('shell-pal-input');
        var list = document.getElementById('shell-pal-list');
        var scopes = document.getElementById('shell-pal-scopes');
        if (!pal || !input || !list) return;

        var scope = '', timer = null, reqId = 0, lastFocus = null;

        function quickLinks() {
            // Harvest the sidebar, so the quick list always matches the user's permissions.
            var out = [];
            document.querySelectorAll('#layout-menu .menu-link[href]').forEach(function (a) {
                var href = a.getAttribute('href');
                if (!href || href.indexOf('javascript') === 0) return;
                var lab = a.querySelector('[data-shell]');
                var parent = a.closest('.menu-sub') ? a.closest('.menu-sub').parentElement.querySelector(':scope > .menu-link [data-shell]') : null;
                var text = (lab ? lab.textContent : a.textContent).trim();
                if (parent) text = parent.textContent.trim() + ' · ' + text;
                var icon = a.querySelector('.menu-icon') || (a.closest('.menu-sub') ? a.closest('.menu-sub').parentElement.querySelector(':scope > .menu-link .menu-icon') : null);
                var cls = icon ? (Array.prototype.find.call(icon.classList, function (c) { return c.indexOf('bx-') === 0; }) || 'bx-right-arrow-alt') : 'bx-right-arrow-alt';
                out.push({ href: href, text: text, icon: cls });
            });
            return out;
        }

        function showQuick() {
            var links = quickLinks();
            var html = '<li class="s-pal-title">' + esc(t('quick_links')) + '</li>';
            links.forEach(function (l) {
                html += '<li class="s-pal-item"><a href="' + esc(l.href) + '"><i class="bx ' + esc(l.icon) + '"></i><span class="s-pal-main"><strong>' + esc(l.text) + '</strong></span></a></li>';
            });
            list.innerHTML = html;
            select(0);
        }
        function msg(text) { list.innerHTML = '<li class="s-pal-msg">' + esc(text) + '</li>'; }

        function items() { return Array.prototype.slice.call(list.querySelectorAll('.s-pal-item a')); }
        function select(i) {
            var els = items();
            els.forEach(function (a) { a.classList.remove('is-sel'); });
            if (!els.length) return;
            i = Math.max(0, Math.min(els.length - 1, i));
            els[i].classList.add('is-sel');
            els[i].scrollIntoView({ block: 'nearest' });
        }
        function selIndex() { return items().findIndex(function (a) { return a.classList.contains('is-sel'); }); }

        function open() {
            lastFocus = document.activeElement;
            pal.hidden = false;
            pal.classList.add('is-open');
            document.body.style.overflow = 'hidden';
            input.value = '';
            input.focus();
            showQuick();
        }
        function close() {
            pal.classList.remove('is-open');
            pal.hidden = true;
            document.body.style.overflow = '';
            if (lastFocus && lastFocus.focus) lastFocus.focus();
        }

        function renderResults(rows) {
            if (!rows.length) { msg(t('no_results')); return; }
            var html = '<li class="s-pal-title">' + esc(t('results')) + '</li>';
            rows.forEach(function (r) {
                var base = MODULE_ROUTES[r.module];
                if (!base) return;
                var href = cfg.base.replace(/\/$/, '') + base + encodeURIComponent(r.reference_id);
                var label = (T[currentLang] && T[currentLang][r.module === 'convert' ? 'converts' : r.module]) || MODULE_LABEL[r.module] || r.module;
                var date = r.application_date ? String(r.application_date).substring(0, 10) : '';
                html += '<li class="s-pal-item"><a href="' + esc(href) + '"><i class="bx ' + (MODULE_ICON[r.module] || 'bx-file') + '"></i>' +
                    '<span class="s-pal-main"><strong>' + esc(r.application_id) + '</strong><span>' + esc(r.title || '') + (date ? ' · ' + esc(date) : '') + '</span></span>' +
                    '<span class="s-tag">' + esc(label) + '</span></a></li>';
            });
            list.innerHTML = html;
            select(0);
        }

        function run() {
            var q = input.value.trim();
            if (q.length < 2) { q.length === 0 ? showQuick() : msg(t('type_more')); return; }
            var my = ++reqId;
            msg(t('searching'));
            var token = (document.querySelector('meta[name="csrf-token"]') || {}).content || '';
            var body = new URLSearchParams();
            body.append('keyword', q); body.append('scope', scope); body.append('_token', token);
            fetch(cfg.searchUrl, {
                method: 'POST', credentials: 'same-origin',
                headers: { 'X-CSRF-TOKEN': token, 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: body
            }).then(function (r) {
                if (r.status === 401) { throw new Error('auth'); }
                if (!r.ok) throw new Error('http');
                return r.json();
            }).then(function (rows) {
                if (my !== reqId) return;
                renderResults(Array.isArray(rows) ? rows : []);
            }).catch(function (err) {
                if (my !== reqId) return;
                msg(err && err.message === 'auth' ? t('session_expired') : t('search_failed'));
            });
        }

        input.addEventListener('input', function () { clearTimeout(timer); timer = setTimeout(run, 250); });
        input.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowDown') { e.preventDefault(); select(selIndex() + 1); }
            else if (e.key === 'ArrowUp') { e.preventDefault(); select(selIndex() - 1); }
            else if (e.key === 'Enter') { var els = items(); var i = selIndex(); if (els[i]) { e.preventDefault(); window.location.href = els[i].href; } }
        });
        if (scopes) scopes.addEventListener('click', function (e) {
            var chip = e.target.closest('.s-chip');
            if (!chip) return;
            scope = chip.getAttribute('data-scope') || '';
            scopes.querySelectorAll('.s-chip').forEach(function (c) { c.classList.toggle('is-on', c === chip); });
            input.focus();
            run();
        });
        pal.addEventListener('mousedown', function (e) { if (e.target === pal) close(); });
        list.addEventListener('mousemove', function (e) { var a = e.target.closest('.s-pal-item a'); if (a) { var els = items(); select(els.indexOf(a)); } });

        document.querySelectorAll('[data-open-search]').forEach(function (b) { b.addEventListener('click', open); });
        document.addEventListener('keydown', function (e) {
            var tag = (e.target.tagName || '').toLowerCase();
            var typing = tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable;
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') { e.preventDefault(); pal.classList.contains('is-open') ? close() : open(); }
            else if (e.key === '/' && !typing && !pal.classList.contains('is-open')) { e.preventDefault(); open(); }
            else if (e.key === 'Escape' && pal.classList.contains('is-open')) { close(); }
        });
        // Mac shows the right modifier hint
        if (/Mac|iPhone|iPad/.test(navigator.platform)) {
            document.querySelectorAll('.s-search kbd').forEach(function (k) { k.textContent = '\u2318 K'; });
        }
    }

    function init() { initLanguage(); initLogout(); initNotifications(); initPalette(); }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init); else init();

    window.UMSCShell = { setLanguage: function (l) { setLanguage(l, true); }, t: t };
})();
