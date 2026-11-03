/* UMSC staff dashboard (Patch 5): trend chart, legend toggles and page labels.
   No libraries. The chart is plain SVG drawn from data-chart on #dash-root.
   Language follows the shell's menu (localStorage "app_language" + the
   "umsc:langchange" event fired by umsc-app.js). Deliberately avoids the global
   names `translations` / `changeLanguage` so it cannot clash with other scripts.
   NOTE: please have a native speaker review the sw / ar wording. */
(function () {
    'use strict';

    var root = document.getElementById('dash-root');
    if (!root) return;

    var LANGS = ['en', 'sw', 'ar'];
    var data = null;
    try { data = JSON.parse(root.getAttribute('data-chart') || 'null'); } catch (e) { data = null; }

    /* ------------------------------------------------------------------
       1. Labels. English is the markup default (captured on first run).
       ------------------------------------------------------------------ */
    var T = {
        sw: {
            welcome: 'Karibu tena', new: 'Mpya',
            m_nikah: 'Nikah', m_divorce: 'Talaka', m_inheritance: 'Mirathi', m_guardianship: 'Ulezi', m_converts: 'Waliosilimu', m_consultancy: 'Ushauri',
            no_modules_title: 'Bado hujapewa huduma yoyote', no_modules_text: 'Mwombe Mkurugenzi akupe ruhusa ya huduma unazofanyia kazi. Dashibodi yako itajaa yenyewe.',
            k_total: 'Rekodi zote', k_total_note: 'Katika huduma unazoweza kuona',
            k_pending: 'Zinasubiri hatua', k_pending_note: 'Zimewasilishwa, hazijaamuliwa', k_pending_none: 'Hakuna kinachosubiri',
            k_done: 'Zilizokamilika', k_done_note: 'ya rekodi zote', k_done_empty: 'Bado hakuna rekodi',
            k_month: 'Zilizosajiliwa mwezi huu', k_new: 'Mpya mwezi huu', k_vs: 'ukilinganisha na mwezi uliopita', k_flat: 'Sawa na mwezi uliopita',
            h_services: 'Huduma', pending_short: 'zinasubiri', this_month: 'mwezi huu', quiet: 'Hakuna shughuli mpya',
            h_trend: 'Usajili, miezi 12 iliyopita', h_trend_sub: 'Rekodi mpya kwa mwezi, kwa huduma', trend_empty: 'Hakuna usajili katika miezi 12 iliyopita. Chati itaonekana rekodi zikiongezwa.',
            h_mix: 'Hali ya rekodi', h_mix_sub: 'Hali ya kila kitu unachoweza kuona', mix_empty: 'Hakuna cha kuonyesha bado.',
            seg_pending: 'Zinasubiri hatua', seg_done: 'Zilizokamilika', seg_rejected: 'Zilizokataliwa', seg_other: 'Zinaendelea',
            h_pending: 'Zinasubiri uamuzi wako', h_pending_sub: 'Za zamani kwanza, katika huduma zote unazoidhinisha',
            th_ref: 'Namba', th_record: 'Rekodi', th_place: 'Eneo', th_waiting: 'Inasubiri', th_action: 'Hatua',
            today: 'Leo', day: 'siku', days: 'siku', review: 'Kagua',
            and_more: 'Inaonyesha za zamani zaidi', of: 'kati ya', open_service: 'Fungua huduma kuona zilizobaki.',
            pending_norights: 'Jukumu lako husajili rekodi lakini haliziidhinishi. Wanaoidhinisha huona orodha yao hapa.', pending_clear: 'Umemaliza yote. Hakuna kinachosubiri uamuzi.',
            h_by: 'Kwa', by_region: 'Mkoa', by_district: 'Wilaya', by_county: 'Kaunti', h_by_sub: 'Rekodi zilizosajiliwa, huduma zote kwa pamoja', more_areas: 'zaidi',
            h_by_service: 'Kwa huduma', h_by_service_sub: 'Rekodi zako kwa kila huduma', by_empty: 'Hakuna rekodi za kuchambua bado.',
            h_activity: 'Shughuli za hivi karibuni', h_glance: 'Idara kwa muhtasari', g_fatwa: 'Fatwa zilizochapishwa', g_staff: 'Akaunti za wafanyakazi'
        },
        ar: {
            welcome: 'مرحباً بعودتك', new: 'جديد',
            m_nikah: 'النكاح', m_divorce: 'الطلاق', m_inheritance: 'المواريث', m_guardianship: 'الولاية', m_converts: 'المهتدون', m_consultancy: 'الاستشارات',
            no_modules_title: 'لم تُسنَد إلى دورك أي خدمة بعد', no_modules_text: 'اطلب من المدير منح دورك صلاحية الخدمات التي تعمل عليها، وستمتلئ لوحتك تلقائياً.',
            k_total: 'جميع السجلات', k_total_note: 'في الخدمات التي يمكنك رؤيتها',
            k_pending: 'بانتظار الإجراء', k_pending_note: 'مقدَّمة ولم يُبتّ فيها', k_pending_none: 'لا شيء بانتظار الإجراء',
            k_done: 'المكتملة', k_done_note: 'من جميع السجلات', k_done_empty: 'لا توجد سجلات بعد',
            k_month: 'المسجَّلة هذا الشهر', k_new: 'جديدة هذا الشهر', k_vs: 'مقارنة بالشهر الماضي', k_flat: 'مثل الشهر الماضي',
            h_services: 'الخدمات', pending_short: 'قيد الانتظار', this_month: 'هذا الشهر', quiet: 'لا نشاط جديد',
            h_trend: 'التسجيلات خلال آخر 12 شهراً', h_trend_sub: 'السجلات الجديدة شهرياً حسب الخدمة', trend_empty: 'لا توجد تسجيلات في آخر 12 شهراً. سيظهر المخطط عند إضافة السجلات.',
            h_mix: 'أين وصلت السجلات', h_mix_sub: 'حالة كل ما يمكنك رؤيته', mix_empty: 'لا شيء لعرضه بعد.',
            seg_pending: 'بانتظار الإجراء', seg_done: 'المكتملة', seg_rejected: 'المرفوضة', seg_other: 'قيد المعالجة',
            h_pending: 'بانتظار قرارك', h_pending_sub: 'الأقدم أولاً، عبر كل الخدمات التي يمكنك اعتمادها',
            th_ref: 'المرجع', th_record: 'السجل', th_place: 'المنطقة', th_waiting: 'مدة الانتظار', th_action: 'إجراء',
            today: 'اليوم', day: 'يوم', days: 'أيام', review: 'مراجعة',
            and_more: 'عرض الأقدم', of: 'من أصل', open_service: 'افتح الخدمة لرؤية الباقي.',
            pending_norights: 'دورك يسجّل السجلات ولا يعتمدها. يرى المعتمدون قائمتهم هنا.', pending_clear: 'لقد أنجزت كل شيء. لا شيء بانتظار القرار.',
            h_by: 'حسب', by_region: 'الإقليم', by_district: 'المقاطعة', by_county: 'المحافظة', h_by_sub: 'السجلات المسجَّلة، جميع الخدمات معاً', more_areas: 'أخرى',
            h_by_service: 'حسب الخدمة', h_by_service_sub: 'سجلاتك موزَّعة على الخدمات', by_empty: 'لا توجد سجلات لتحليلها بعد.',
            h_activity: 'النشاط الأخير', h_glance: 'المديرية في لمحة', g_fatwa: 'الفتاوى المنشورة', g_staff: 'حسابات الموظفين'
        }
    };
    var EN = {};
    var lang = 'en';

    function captureEnglish() {
        root.querySelectorAll('[data-d]').forEach(function (el) {
            var k = el.getAttribute('data-d');
            if (!(k in EN)) EN[k] = el.textContent;
        });
    }

    function applyLabels(l) {
        lang = LANGS.indexOf(l) === -1 ? 'en' : l;
        root.querySelectorAll('[data-d]').forEach(function (el) {
            var k = el.getAttribute('data-d');
            var v = lang === 'en' ? EN[k] : (T[lang] && T[lang][k]);
            if (v !== undefined) el.textContent = v;
        });
        var d = document.getElementById('d-date');
        if (d) {
            var loc = lang === 'ar' ? 'ar-u-nu-latn' : lang;
            try { d.textContent = new Date().toLocaleDateString(loc, { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }); } catch (e) { }
        }
        drawChart();
        relTimes();
    }

    // Activity times: localised with Intl so they follow the language menu.
    function relTimes() {
        var loc = lang === 'ar' ? 'ar-u-nu-latn' : lang;
        root.querySelectorAll('time[data-ts]').forEach(function (t) {
            var ms = Date.parse(t.getAttribute('data-ts'));
            if (isNaN(ms) || !window.Intl || !Intl.RelativeTimeFormat) return;
            var diff = (ms - Date.now()) / 1000, a = Math.abs(diff), u, v;
            if (a < 60) { u = 'second'; v = diff; }
            else if (a < 3600) { u = 'minute'; v = diff / 60; }
            else if (a < 86400) { u = 'hour'; v = diff / 3600; }
            else if (a < 2592000) { u = 'day'; v = diff / 86400; }
            else { u = 'month'; v = diff / 2592000; }
            try { t.textContent = new Intl.RelativeTimeFormat(loc, { numeric: 'auto' }).format(Math.round(v), u); } catch (e) { }
        });
    }

    function currentLang() {
        var s = null;
        try { s = localStorage.getItem('app_language'); } catch (e) { }
        return (s && LANGS.indexOf(s) !== -1) ? s : (document.documentElement.lang || 'en').slice(0, 2);
    }

    /* ------------------------------------------------------------------
       2. Trend chart: stacked columns, one segment per service.
       ------------------------------------------------------------------ */
    var off = {};              // series keys switched off in the legend
    var chartEl = document.getElementById('d-chart');
    var tip = document.getElementById('d-tip');
    var NS = 'http://www.w3.org/2000/svg';

    function el(name, attrs, text) {
        var n = document.createElementNS(NS, name);
        for (var k in attrs) n.setAttribute(k, attrs[k]);
        if (text !== undefined) n.textContent = text;
        return n;
    }
    function niceMax(v) {
        if (v <= 4) return 4;
        var p = Math.pow(10, Math.floor(Math.log10(v)));
        var f = v / p;
        return (f <= 1 ? 1 : f <= 2 ? 2 : f <= 5 ? 5 : 10) * p;
    }
    function monthLabel(key) {
        var p = key.split('-');
        var loc = lang === 'ar' ? 'ar-u-nu-latn' : lang;
        try { return new Date(+p[0], +p[1] - 1, 1).toLocaleDateString(loc, { month: 'short' }); } catch (e) { return key; }
    }
    function fullMonth(key) {
        var p = key.split('-');
        var loc = lang === 'ar' ? 'ar-u-nu-latn' : lang;
        try { return new Date(+p[0], +p[1] - 1, 1).toLocaleDateString(loc, { month: 'long', year: 'numeric' }); } catch (e) { return key; }
    }
    function seriesName(s) {
        var t = T[lang] && T[lang]['m_' + s.label.toLowerCase()];
        return (lang !== 'en' && t) ? t : s.label;
    }

    function drawChart() {
        if (!chartEl || !data) return;
        var W = 720, H = 280, L = 34, R = 8, Tp = 10, B = 28;
        var rtl = document.documentElement.dir === 'rtl';
        var series = data.series.filter(function (s) { return !off[s.key]; });
        var n = data.monthKeys.length;

        var totals = data.monthKeys.map(function (m, i) {
            return series.reduce(function (a, s) { return a + (s.values[i] || 0); }, 0);
        });
        var max = niceMax(Math.max.apply(null, totals.concat([1])));
        var plotW = W - L - R, plotH = H - Tp - B;
        var colW = plotW / n, barW = Math.min(34, colW * 0.62);
        var y = function (v) { return Tp + plotH - (v / max) * plotH; };
        var xCol = function (i) { return rtl ? W - R - colW * (i + 1) : L + colW * i; };

        var svg = el('svg', { viewBox: '0 0 ' + W + ' ' + H, preserveAspectRatio: 'xMidYMid meet', focusable: 'false' });

        for (var g = 0; g <= 4; g++) {
            var v = max / 4 * g, yy = y(v);
            svg.appendChild(el('line', { class: 'grid', x1: rtl ? W - R : L, x2: rtl ? L : W - R, y1: yy, y2: yy }));
            svg.appendChild(el('text', { class: 'axis', x: rtl ? W - R + 6 : L - 6, y: yy + 4, 'text-anchor': rtl ? 'start' : 'end' }, Math.round(v)));
        }

        data.monthKeys.forEach(function (m, i) {
            var gx = xCol(i), cx = gx + colW / 2, acc = 0;
            var grp = el('g', { class: 'col', 'data-i': i });
            grp.appendChild(el('rect', { class: 'hit', x: gx, y: Tp, width: colW, height: plotH }));
            series.forEach(function (s) {
                var val = s.values[i] || 0;
                if (!val) return;
                var h = (val / max) * plotH;
                grp.appendChild(el('rect', { x: cx - barW / 2, y: y(acc + val), width: barW, height: Math.max(h, 1), fill: s.color, rx: 1 }));
                acc += val;
            });
            grp.appendChild(el('text', { class: 'axis', x: cx, y: H - 8, 'text-anchor': 'middle' }, monthLabel(m)));
            svg.appendChild(grp);
        });

        chartEl.textContent = '';
        chartEl.appendChild(svg);

        if (!series.length) {
            var msg = el('text', { class: 'axis', x: W / 2, y: H / 2, 'text-anchor': 'middle' }, '—');
            svg.appendChild(msg);
        }

        // Tooltip (mouse + touch).
        var host = chartEl.parentNode;
        function show(i, evt) {
            var rows = series.filter(function (s) { return (s.values[i] || 0) > 0; });
            tip.textContent = '';
            var b = document.createElement('b'); b.textContent = fullMonth(data.monthKeys[i]); tip.appendChild(b);
            if (!rows.length) {
                var z = document.createElement('span'); z.textContent = '0'; tip.appendChild(z);
            }
            rows.forEach(function (s) {
                var r = document.createElement('span');
                var l = document.createElement('em'); l.style.fontStyle = 'normal';
                var sw = document.createElement('i'); sw.style.background = s.color;
                l.appendChild(sw); l.appendChild(document.createTextNode(seriesName(s)));
                var c = document.createElement('strong'); c.textContent = s.values[i];
                r.appendChild(l); r.appendChild(c); tip.appendChild(r);
            });
            tip.hidden = false;
            var hb = host.getBoundingClientRect(), pt = evt.touches ? evt.touches[0] : evt;
            var left = pt.clientX - hb.left + 14, top = pt.clientY - hb.top - tip.offsetHeight - 10;
            if (left + tip.offsetWidth > hb.width - 8) left = pt.clientX - hb.left - tip.offsetWidth - 14;
            tip.style.left = Math.max(8, left) + 'px';
            tip.style.top = Math.max(8, top) + 'px';
        }
        svg.addEventListener('mousemove', function (e) { var g = e.target.closest('.col'); g ? show(+g.getAttribute('data-i'), e) : (tip.hidden = true); });
        svg.addEventListener('mouseleave', function () { tip.hidden = true; });
        svg.addEventListener('touchstart', function (e) { var t = document.elementFromPoint(e.touches[0].clientX, e.touches[0].clientY); var g = t && t.closest && t.closest('.col'); g ? show(+g.getAttribute('data-i'), e) : (tip.hidden = true); }, { passive: true });
    }

    var legend = document.getElementById('d-legend');
    if (legend) legend.addEventListener('click', function (e) {
        var btn = e.target.closest('.d-legend__btn');
        if (!btn) return;
        var k = btn.getAttribute('data-series');
        off[k] = !off[k];
        btn.setAttribute('aria-pressed', off[k] ? 'false' : 'true');
        if (tip) tip.hidden = true;
        drawChart();
    });

    /* ------------------------------------------------------------------
       3. Boot
       ------------------------------------------------------------------ */
    captureEnglish();
    applyLabels(currentLang());
    // The shell sets <html dir> on DOMContentLoaded; redraw once so the chart follows it.
    document.addEventListener('DOMContentLoaded', function () { applyLabels(currentLang()); });
    document.addEventListener('umsc:langchange', function (e) {
        applyLabels((e && e.detail && e.detail.lang) || currentLang());
    });
})();
