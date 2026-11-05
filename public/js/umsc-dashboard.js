/* ==========================================================================
   UMSC Directorate of Sharia: staff dashboard (Patch 7)
   Renders the payload built by App\Services\DashboardData::payload().
   Vanilla JS + the ApexCharts bundled with the theme. The script waits for
   the library (and falls back to a pinned CDN copy) before drawing, and a
   chart that fails shows its error message instead of failing silently.
   Language follows the shell's menu (localStorage "app_language" and the
   "umsc:langchange" event fired by umsc-app.js).
   NOTE: please have a native speaker review the sw / ar wording.
   ========================================================================== */
(function () {
    'use strict';

    var root = document.getElementById('ud');
    var initialEl = document.getElementById('dash-initial');
    if (!root || !initialEl) { return; }

    /* ------------------------------------------------------------------
       1. Labels
       ------------------------------------------------------------------ */
    var LANGS = ['en', 'sw', 'ar'];
    var DICT = {
        en: {
            welcome: 'Welcome back', g_morning: 'Good morning', g_afternoon: 'Good afternoon', g_evening: 'Good evening',
            hero_sub: 'A live view of registrations, approvals and workload across the services you manage.',
            no_modules_title: 'No modules are assigned to your role yet',
            no_modules_text: 'Ask the Director to grant your role access to the services you work with. Your dashboard will fill in automatically.',
            f_period: 'Period', p_all: 'All time', p_30: 'Last 30 days', p_90: 'Last 90 days', p_365: 'Last 12 months', s_all: 'All services',
            updated: 'Updated {t}', updated_now: 'Updated now', auto: 'Auto-refresh', auto_title: 'Refresh the numbers every 2 minutes while this tab is open',
            refresh: 'Refresh', print: 'Print',
            m_nikah: 'Nikah', m_divorce: 'Divorce', m_inheritance: 'Inheritance', m_guardianship: 'Guardianship', m_convert: 'Converts', m_consultancy: 'Consultancy',
            h_services: 'Services', h_overview: 'Registrations & status', h_queue: 'Work queue', h_insights: 'Insights', h_recent: 'Recent activity', h_glance: 'Directorate at a glance',
            h_actions: 'Quick actions',
            hp_queue: 'Approval queue', hp_waiting: 'waiting', hp_clear: 'Nothing waiting', hp_completion: 'Completion', hp_oldest: 'Oldest: {n} d',
            kpi_total: 'All records', kpi_pending: 'Awaiting action', kpi_overdue: 'Overdue', kpi_done: 'Completed', kpi_fresh: 'New this week',
            kpi_turnaround: 'Avg. processing time', kpi_rejection: 'Rejection rate', kpi_trend: 'This month',
            sub_services: 'Across {n} service(s)', sub_queue_clear: 'Nothing is waiting', sub_oldest: 'Oldest has waited {n} day(s)',
            sub_overdue: 'Pending for {n}+ days', sub_done_pct: '{n}% of all records', sub_none: 'No records yet',
            sub_fresh: '{n} in the last 30 days', sub_turnaround: 'Registration to decision', sub_turnaround_none: 'No completed records yet',
            sub_rejected: '{n} rejected', sub_month_prev: '{n} last month',
            d_new: 'New', d_title: 'vs the previous period',
            al_overdue: '{n} record(s) have been waiting {d}+ days for a decision.', al_pending: '{n} record(s) are waiting for action.',
            al_busiest: '{m} has the biggest queue with {n} waiting.', al_rejection: '{n}% of decided records were rejected.',
            al_clear: 'Everything is up to date. Nothing needs your attention right now.', cta_review: 'Review',
            c_trend: 'Registration activity', c_trend_sub: 'New records by service', r_30d: '30 days', r_12m: '12 months', records: 'Records',
            c_status: 'Where records stand', c_status_sub: 'Status of everything in the selected period', status_total: 'Total',
            st_pending: 'Awaiting action', st_done: 'Completed', st_rejected: 'Rejected', st_other: 'In progress',
            foot_approval: 'Approval rate', foot_completion: 'Completion',
            c_compare: 'Service comparison', c_compare_sub: 'Completed, waiting and rejected, per service',
            c_weekday: 'Busiest days', c_weekday_sub: 'New records by weekday, last 12 weeks', c_by: 'By {x}', c_by_sub: 'Records registered, all services together',
            by_region: 'Region', by_district: 'District', by_county: 'County',
            c_pending: 'Waiting for your decision', c_pending_sub: 'Oldest first, across every service you can approve',
            th_ref: 'Reference', th_record: 'Record', th_place: 'Area', th_waiting: 'Waiting', th_action: 'Action',
            today: 'Today', day: 'day', days: 'days', review: 'Review', pending_empty: 'You are all caught up. Nothing is waiting for your decision.',
            c_aging: 'How long records have waited', c_aging_sub: 'Current pending queue, by age', ag_unit: 'days', ag_empty: 'The queue is empty.',
            a_new: 'New {m}', a_desc: 'Register a record',
            svc_new: '+{n} this month', svc_wait: '{n} waiting', svc_done: '{n} completed', svc_rej: '{n} rejected', svc_quiet: 'No new activity',
            ins_dowry: 'Dowry type', ins_mosques: 'Top mosques (Nikah)', ins_divorce_type: 'Divorce type', ins_divorce_by: 'Divorce initiated by',
            ins_guardian_type: 'Guardianship type', ins_inherit_rel: 'Applicant relationship', ins_convert_religion: 'Former religion', ins_consult_type: 'Consultation type',
            ins_sub: 'Selected period',
            c_recent: 'Latest registrations', c_recent_sub: 'Newest records across your services', recent_empty: 'No records yet.',
            c_activity: 'System activity', c_activity_sub: 'What staff have done recently', activity_empty: 'No recent activity to show.',
            g_fatwa: 'Published Fatwa', g_staff: 'Staff accounts',
            err_load: 'Could not refresh the dashboard. Showing the last data.', no_data: 'No data for this selection.', chart_fail: 'This chart could not be drawn.'
        },
        sw: {
            welcome: 'Karibu tena', g_morning: 'Habari za asubuhi', g_afternoon: 'Habari za mchana', g_evening: 'Habari za jioni',
            hero_sub: 'Muhtasari wa moja kwa moja wa usajili, idhini na kazi katika huduma unazosimamia.',
            no_modules_title: 'Bado hujapewa huduma yoyote',
            no_modules_text: 'Mwombe Mkurugenzi akupe ruhusa ya huduma unazofanyia kazi. Dashibodi yako itajaa yenyewe.',
            f_period: 'Kipindi', p_all: 'Wakati wote', p_30: 'Siku 30 zilizopita', p_90: 'Siku 90 zilizopita', p_365: 'Miezi 12 iliyopita', s_all: 'Huduma zote',
            updated: 'Imesasishwa {t}', updated_now: 'Imesasishwa sasa hivi', auto: 'Sasisha kiotomatiki', auto_title: 'Sasisha namba kila dakika 2 wakati kichupo hiki kimefunguliwa',
            refresh: 'Sasisha', print: 'Chapisha',
            m_nikah: 'Nikah', m_divorce: 'Talaka', m_inheritance: 'Mirathi', m_guardianship: 'Ulezi', m_convert: 'Waliosilimu', m_consultancy: 'Ushauri',
            h_services: 'Huduma', h_overview: 'Usajili na hali', h_queue: 'Foleni ya kazi', h_insights: 'Uchambuzi', h_recent: 'Shughuli za hivi karibuni', h_glance: 'Idara kwa muhtasari',
            h_actions: 'Vitendo vya haraka',
            hp_queue: 'Foleni ya idhini', hp_waiting: 'zinasubiri', hp_clear: 'Hakuna kinachosubiri', hp_completion: 'Zilizokamilika', hp_oldest: 'Ya zamani zaidi: siku {n}',
            kpi_total: 'Rekodi zote', kpi_pending: 'Zinasubiri hatua', kpi_overdue: 'Zilizochelewa', kpi_done: 'Zilizokamilika', kpi_fresh: 'Mpya wiki hii',
            kpi_turnaround: 'Wastani wa muda wa kushughulikia', kpi_rejection: 'Kiwango cha kukataliwa', kpi_trend: 'Mwezi huu',
            sub_services: 'Katika huduma {n}', sub_queue_clear: 'Hakuna kinachosubiri', sub_oldest: 'Ya zamani zaidi imesubiri siku {n}',
            sub_overdue: 'Zinasubiri siku {n}+', sub_done_pct: '{n}% ya rekodi zote', sub_none: 'Bado hakuna rekodi',
            sub_fresh: '{n} katika siku 30 zilizopita', sub_turnaround: 'Kuanzia usajili hadi uamuzi', sub_turnaround_none: 'Bado hakuna rekodi zilizokamilika',
            sub_rejected: '{n} zimekataliwa', sub_month_prev: '{n} mwezi uliopita',
            d_new: 'Mpya', d_title: 'ukilinganisha na kipindi kilichopita',
            al_overdue: 'Rekodi {n} zimesubiri uamuzi kwa siku {d}+.', al_pending: 'Rekodi {n} zinasubiri hatua.',
            al_busiest: '{m} ina foleni kubwa zaidi: {n} zinasubiri.', al_rejection: '{n}% ya rekodi zilizoamuliwa zilikataliwa.',
            al_clear: 'Kila kitu kiko sawa. Hakuna kinachohitaji umakini wako sasa.', cta_review: 'Kagua',
            c_trend: 'Shughuli za usajili', c_trend_sub: 'Rekodi mpya kwa huduma', r_30d: 'Siku 30', r_12m: 'Miezi 12', records: 'Rekodi',
            c_status: 'Hali ya rekodi', c_status_sub: 'Hali ya kila kitu katika kipindi kilichochaguliwa', status_total: 'Jumla',
            st_pending: 'Zinasubiri hatua', st_done: 'Zilizokamilika', st_rejected: 'Zilizokataliwa', st_other: 'Zinaendelea',
            foot_approval: 'Kiwango cha idhini', foot_completion: 'Zilizokamilika',
            c_compare: 'Ulinganisho wa huduma', c_compare_sub: 'Zilizokamilika, zinazosubiri na zilizokataliwa, kwa kila huduma',
            c_weekday: 'Siku zenye shughuli nyingi', c_weekday_sub: 'Rekodi mpya kwa siku ya wiki, wiki 12 zilizopita', c_by: 'Kwa {x}', c_by_sub: 'Rekodi zilizosajiliwa, huduma zote kwa pamoja',
            by_region: 'Mkoa', by_district: 'Wilaya', by_county: 'Kaunti',
            c_pending: 'Zinasubiri uamuzi wako', c_pending_sub: 'Za zamani kwanza, katika huduma zote unazoidhinisha',
            th_ref: 'Namba', th_record: 'Rekodi', th_place: 'Eneo', th_waiting: 'Inasubiri', th_action: 'Hatua',
            today: 'Leo', day: 'siku', days: 'siku', review: 'Kagua', pending_empty: 'Umemaliza yote. Hakuna kinachosubiri uamuzi wako.',
            c_aging: 'Muda ambao rekodi zimesubiri', c_aging_sub: 'Foleni ya sasa, kwa umri', ag_unit: 'siku', ag_empty: 'Foleni haina kitu.',
            a_new: '{m} mpya', a_desc: 'Sajili rekodi',
            svc_new: '+{n} mwezi huu', svc_wait: '{n} zinasubiri', svc_done: '{n} zimekamilika', svc_rej: '{n} zimekataliwa', svc_quiet: 'Hakuna shughuli mpya',
            ins_dowry: 'Aina ya mahari', ins_mosques: 'Misikiti inayoongoza (Nikah)', ins_divorce_type: 'Aina ya talaka', ins_divorce_by: 'Talaka imeanzishwa na',
            ins_guardian_type: 'Aina ya ulezi', ins_inherit_rel: 'Uhusiano wa mwombaji', ins_convert_religion: 'Dini ya awali', ins_consult_type: 'Aina ya ushauri',
            ins_sub: 'Kipindi kilichochaguliwa',
            c_recent: 'Usajili wa hivi karibuni', c_recent_sub: 'Rekodi mpya zaidi katika huduma zako', recent_empty: 'Bado hakuna rekodi.',
            c_activity: 'Shughuli za mfumo', c_activity_sub: 'Walichofanya wafanyakazi hivi karibuni', activity_empty: 'Hakuna shughuli za hivi karibuni.',
            g_fatwa: 'Fatwa zilizochapishwa', g_staff: 'Akaunti za wafanyakazi',
            err_load: 'Imeshindwa kusasisha dashibodi. Inaonyesha data ya mwisho.', no_data: 'Hakuna data kwa chaguo hili.', chart_fail: 'Chati hii haikuweza kuchorwa.'
        },
        ar: {
            welcome: 'مرحباً بعودتك', g_morning: 'صباح الخير', g_afternoon: 'مساء الخير', g_evening: 'مساء الخير',
            hero_sub: 'نظرة مباشرة على التسجيلات والاعتمادات وحجم العمل عبر الخدمات التي تديرها.',
            no_modules_title: 'لم تُسنَد إلى دورك أي خدمة بعد',
            no_modules_text: 'اطلب من المدير منح دورك صلاحية الخدمات التي تعمل عليها، وستمتلئ لوحتك تلقائياً.',
            f_period: 'الفترة', p_all: 'كل الأوقات', p_30: 'آخر 30 يوماً', p_90: 'آخر 90 يوماً', p_365: 'آخر 12 شهراً', s_all: 'كل الخدمات',
            updated: 'آخر تحديث {t}', updated_now: 'تم التحديث الآن', auto: 'تحديث تلقائي', auto_title: 'تحديث الأرقام كل دقيقتين أثناء فتح هذه الصفحة',
            refresh: 'تحديث', print: 'طباعة',
            m_nikah: 'النكاح', m_divorce: 'الطلاق', m_inheritance: 'المواريث', m_guardianship: 'الولاية', m_convert: 'المهتدون', m_consultancy: 'الاستشارات',
            h_services: 'الخدمات', h_overview: 'التسجيلات والحالة', h_queue: 'قائمة العمل', h_insights: 'تحليلات', h_recent: 'النشاط الأخير', h_glance: 'المديرية في لمحة',
            h_actions: 'إجراءات سريعة',
            hp_queue: 'قائمة الاعتماد', hp_waiting: 'بالانتظار', hp_clear: 'لا شيء بالانتظار', hp_completion: 'نسبة الإنجاز', hp_oldest: 'الأقدم: {n} يوم',
            kpi_total: 'جميع السجلات', kpi_pending: 'بانتظار الإجراء', kpi_overdue: 'متأخرة', kpi_done: 'المكتملة', kpi_fresh: 'جديدة هذا الأسبوع',
            kpi_turnaround: 'متوسط مدة المعالجة', kpi_rejection: 'نسبة الرفض', kpi_trend: 'هذا الشهر',
            sub_services: 'عبر {n} خدمة', sub_queue_clear: 'لا شيء بالانتظار', sub_oldest: 'الأقدم ينتظر منذ {n} يوم',
            sub_overdue: 'معلّقة منذ {n}+ يوماً', sub_done_pct: '{n}% من جميع السجلات', sub_none: 'لا توجد سجلات بعد',
            sub_fresh: '{n} خلال آخر 30 يوماً', sub_turnaround: 'من التسجيل إلى القرار', sub_turnaround_none: 'لا توجد سجلات مكتملة بعد',
            sub_rejected: '{n} مرفوضة', sub_month_prev: '{n} الشهر الماضي',
            d_new: 'جديد', d_title: 'مقارنة بالفترة السابقة',
            al_overdue: '{n} سجل ينتظر قراراً منذ {d}+ يوماً.', al_pending: '{n} سجل بانتظار الإجراء.',
            al_busiest: '{m} لديها أكبر قائمة انتظار: {n}.', al_rejection: '{n}% من السجلات المحسومة رُفضت.',
            al_clear: 'كل شيء محدّث. لا شيء يحتاج انتباهك الآن.', cta_review: 'مراجعة',
            c_trend: 'نشاط التسجيل', c_trend_sub: 'السجلات الجديدة حسب الخدمة', r_30d: '30 يوماً', r_12m: '12 شهراً', records: 'السجلات',
            c_status: 'أين وصلت السجلات', c_status_sub: 'حالة كل ما في الفترة المحددة', status_total: 'الإجمالي',
            st_pending: 'بانتظار الإجراء', st_done: 'المكتملة', st_rejected: 'المرفوضة', st_other: 'قيد المعالجة',
            foot_approval: 'نسبة الاعتماد', foot_completion: 'نسبة الإنجاز',
            c_compare: 'مقارنة الخدمات', c_compare_sub: 'المكتملة والمنتظرة والمرفوضة لكل خدمة',
            c_weekday: 'الأيام الأكثر نشاطاً', c_weekday_sub: 'السجلات الجديدة حسب يوم الأسبوع، آخر 12 أسبوعاً', c_by: 'حسب {x}', c_by_sub: 'السجلات المسجَّلة، جميع الخدمات معاً',
            by_region: 'الإقليم', by_district: 'المقاطعة', by_county: 'المحافظة',
            c_pending: 'بانتظار قرارك', c_pending_sub: 'الأقدم أولاً، عبر كل الخدمات التي يمكنك اعتمادها',
            th_ref: 'المرجع', th_record: 'السجل', th_place: 'المنطقة', th_waiting: 'مدة الانتظار', th_action: 'إجراء',
            today: 'اليوم', day: 'يوم', days: 'أيام', review: 'مراجعة', pending_empty: 'لقد أنجزت كل شيء. لا شيء بانتظار قرارك.',
            c_aging: 'مدة انتظار السجلات', c_aging_sub: 'قائمة الانتظار الحالية حسب العمر', ag_unit: 'أيام', ag_empty: 'قائمة الانتظار فارغة.',
            a_new: '{m} جديد', a_desc: 'تسجيل سجل جديد',
            svc_new: '+{n} هذا الشهر', svc_wait: '{n} بالانتظار', svc_done: '{n} مكتملة', svc_rej: '{n} مرفوضة', svc_quiet: 'لا نشاط جديد',
            ins_dowry: 'نوع المهر', ins_mosques: 'أكثر المساجد (النكاح)', ins_divorce_type: 'نوع الطلاق', ins_divorce_by: 'الطلاق بمبادرة',
            ins_guardian_type: 'نوع الولاية', ins_inherit_rel: 'صلة مقدّم الطلب', ins_convert_religion: 'الديانة السابقة', ins_consult_type: 'نوع الاستشارة',
            ins_sub: 'الفترة المحددة',
            c_recent: 'أحدث التسجيلات', c_recent_sub: 'أحدث السجلات عبر خدماتك', recent_empty: 'لا توجد سجلات بعد.',
            c_activity: 'نشاط النظام', c_activity_sub: 'ما قام به الموظفون مؤخراً', activity_empty: 'لا يوجد نشاط حديث لعرضه.',
            g_fatwa: 'الفتاوى المنشورة', g_staff: 'حسابات الموظفين',
            err_load: 'تعذّر تحديث اللوحة. يتم عرض آخر بيانات.', no_data: 'لا توجد بيانات لهذا الاختيار.', chart_fail: 'تعذّر رسم هذا المخطط.'
        }
    };

    // Labels added for the Patch 7 layout.
    var EXTRA = {
        en: { pc_30: '30d', pc_90: '90d', pc_365: '12m', pc_all: 'All', live: 'Live', f_wait: 'Waiting', f_overdue: 'Overdue', f_done: 'Completed', f_tab_all: 'All services' },
        sw: { pc_30: 'Siku 30', pc_90: 'Siku 90', pc_365: 'Miezi 12', pc_all: 'Zote', live: 'Moja kwa moja', f_wait: 'Zinasubiri', f_overdue: 'Zilizochelewa', f_done: 'Zilizokamilika', f_tab_all: 'Huduma zote' },
        ar: { pc_30: '30 يوماً', pc_90: '90 يوماً', pc_365: '12 شهراً', pc_all: 'الكل', live: 'مباشر', f_wait: 'بالانتظار', f_overdue: 'متأخرة', f_done: 'المكتملة', f_tab_all: 'كل الخدمات' }
    };
    Object.keys(EXTRA).forEach(function (l) { Object.keys(EXTRA[l]).forEach(function (k) { DICT[l][k] = EXTRA[l][k]; }); });
    DICT.en.refresh = 'Refresh'; DICT.en.print = 'Print';

    var lang = 'en';

    function t(key, params) {
        var s = (DICT[lang] && DICT[lang][key]) || DICT.en[key];
        if (s === undefined) { return key; }
        if (params) { Object.keys(params).forEach(function (k) { s = s.split('{' + k + '}').join(params[k]); }); }
        return s;
    }
    function locale() { return lang === 'ar' ? 'ar-u-nu-latn' : lang; }
    function currentLang() {
        var s = null;
        try { s = localStorage.getItem('app_language'); } catch (e) { }
        return (s && LANGS.indexOf(s) !== -1) ? s : (document.documentElement.lang || 'en').slice(0, 2);
    }

    /* ------------------------------------------------------------------
       2. State & helpers
       ------------------------------------------------------------------ */
    var DATA_URL = root.getAttribute('data-url');
    var AUTO_MS = 120000;
    var APEX_FALLBACK = root.getAttribute('data-apex') || '';   // pinned local ApexCharts 3.54.1 (MIT)
    var state = { payload: JSON.parse(initialEl.textContent), period: null, service: null, range: 'daily', charts: {}, timer: null, reqId: 0, live: true };
    state.period = state.payload.filters.period;
    state.service = state.payload.filters.service;

    var C = { green: '#136a3b', gold: '#c9a500', amber: '#E0A526', red: '#D64545', slate: '#94A3B8', axis: '#66756c', grid: '#eef2ee' };
    var TONE = { green: '#136a3b', amber: '#a97500', teal: '#0e7c86', indigo: '#4650c4', gold: '#8f7000', slate: '#55657a', rose: '#bd3560', purple: '#6c4bb0', red: '#b93030', blue: '#2a5fa8' };
    var REDUCED = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function $(sel, scope) { return (scope || root).querySelector(sel); }
    function $$(sel, scope) { return Array.prototype.slice.call((scope || root).querySelectorAll(sel)); }
    function esc(v) { return String(v === null || v === undefined ? '' : v).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#39;'); }
    function num(n, d) { if (n === null || n === undefined || isNaN(n)) { return '—'; } return Number(n).toLocaleString('en-US', { minimumFractionDigits: d || 0, maximumFractionDigits: d || 0 }); }
    function sum(a) { return (a || []).reduce(function (x, y) { return x + (Number(y) || 0); }, 0); }
    function setHtml(sel, html) { var el = typeof sel === 'string' ? $(sel) : sel; if (el) { el.innerHTML = html; } }
    function svcLabel(key, fallback) { var k = 'm_' + key; return (DICT[lang] && DICT[lang][k]) || DICT.en[k] || fallback || key; }
    function svcMeta(key) { var l = state.payload.services_available || []; for (var i = 0; i < l.length; i++) { if (l[i].key === key) { return l[i]; } } return { key: key, label: key, color: C.green, icon: 'bx-folder' }; }
    function rtl() { return lang === 'ar'; }

    function toast(msg, type) {
        var el = $('#ud-toast'); if (!el) { return; }
        el.textContent = msg; el.className = 'ud-toast on' + (type === 'error' ? ' err' : '');
        clearTimeout(toast._t); toast._t = setTimeout(function () { el.className = 'ud-toast'; }, 4500);
    }
    function fmtDate(iso, opts) { try { return new Date(iso + (iso.length === 10 ? 'T00:00:00' : '')).toLocaleDateString(locale(), opts); } catch (e) { return iso; } }
    function fmtMonth(key) { var p = key.split('-'); try { return new Date(+p[0], +p[1] - 1, 1).toLocaleDateString(locale(), { month: 'short' }); } catch (e) { return key; } }
    function relTime(iso) {
        var ms = Date.parse(iso); if (isNaN(ms) || !window.Intl || !Intl.RelativeTimeFormat) { return ''; }
        var diff = (ms - Date.now()) / 1000, a = Math.abs(diff), u, v;
        if (a < 60) { u = 'second'; v = diff; } else if (a < 3600) { u = 'minute'; v = diff / 60; } else if (a < 86400) { u = 'hour'; v = diff / 3600; } else if (a < 2592000) { u = 'day'; v = diff / 86400; } else { u = 'month'; v = diff / 2592000; }
        try { return new Intl.RelativeTimeFormat(locale(), { numeric: 'auto' }).format(Math.round(v), u); } catch (e) { return ''; }
    }
    function mixHex(h1, h2, f) {
        function p(h) { return [1, 3, 5].map(function (i) { return parseInt(h.slice(i, i + 2), 16); }); }
        var a = p(h1), b = p(h2);
        return '#' + a.map(function (v, i) { return Math.round(v + (b[i] - v) * f).toString(16).padStart(2, '0'); }).join('');
    }
    function ramp(n) {
        var stops = ['#136a3b', '#6DB36B', '#E0C247', '#EE9A3A', '#D64545'];
        if (n <= 1) { return [stops[0]]; }
        var out = [];
        for (var i = 0; i < n; i++) { var f = (i / (n - 1)) * (stops.length - 1), a = Math.floor(f), b = Math.min(stops.length - 1, a + 1); out.push(mixHex(stops[a], stops[b], f - a)); }
        return out;
    }

    /* ------------------------------------------------------------------
       3. Chart plumbing: wait for ApexCharts, fall back to a CDN copy,
          and always say why a chart failed.
       ------------------------------------------------------------------ */
    // Wait (up to ~3 s) for the theme's bundled ApexCharts, which the layout footer loads.
    var bundledWait = null;
    function whenApex(cb) {
        if (window.ApexCharts) { return cb(null); }
        if (!bundledWait) {
            bundledWait = new Promise(function (resolve) {
                var tries = 0, iv = setInterval(function () {
                    if (window.ApexCharts) { clearInterval(iv); return resolve(true); }
                    if (++tries >= 30) { clearInterval(iv); resolve(false); }
                }, 100);
            });
        }
        bundledWait.then(function (ok) {
            if (ok) { return cb(null); }
            loadFallback(function (ok2) { cb(ok2 ? null : new Error('ApexCharts did not load (theme bundle missing and fallback unavailable)')); });
        });
    }
    // The theme's copy is an older build. If it cannot draw something, switch to the pinned local build.
    var fallbackState = 'idle', fallbackWaiters = [];
    function loadFallback(cb) {
        if (fallbackState === 'ready') { return cb(true); }
        if (fallbackState === 'failed' || !APEX_FALLBACK) { return cb(false); }
        fallbackWaiters.push(cb);
        if (fallbackState === 'loading') { return; }
        fallbackState = 'loading';
        var done = function (ok) { fallbackState = ok ? 'ready' : 'failed'; fallbackWaiters.splice(0).forEach(function (f) { f(ok); }); };
        var sc = document.createElement('script');
        sc.src = APEX_FALLBACK; sc.async = true;
        sc.onload = function () { done(!!window.ApexCharts); };
        sc.onerror = function () { done(false); };
        document.head.appendChild(sc);   // replaces window.ApexCharts with the pinned build
    }
    function destroyChart(k) { var c = state.charts[k]; if (c) { try { c.destroy(); } catch (e) { } delete state.charts[k]; } }
    function destroyPrefix(p) { Object.keys(state.charts).forEach(function (k) { if (k.indexOf(p) === 0) { destroyChart(k); } }); }
    function emptyState(key, el, icon, msg, detail) {
        destroyChart(key);
        if (el) { el.innerHTML = '<div class="ud-empty"><i class="bx ' + icon + '"></i><div>' + esc(msg) + '</div>' + (detail ? '<code>' + esc(detail) + '</code>' : '') + '</div>'; el.removeAttribute('role'); }
    }
    function failed(key, el, e) {
        if (window.console) { console.error('[dashboard] chart "' + key + '" failed:', e); }
        emptyState(key, el, 'bx-error-circle', t('chart_fail'), e && e.message ? e.message : String(e));
    }
    function mount(key, el, options, label) {
        if (!el) { return; }
        destroyChart(key); el.innerHTML = '';
        var token = (el.__tok = (el.__tok || 0) + 1);
        function attempt(retried) {
            if (token !== el.__tok || !document.body.contains(el)) { return; }   // a newer render replaced this one
            function fail(e) {
                if (token !== el.__tok) { return; }
                if (!retried && fallbackState !== 'ready') {
                    if (window.console) { console.warn('[dashboard] chart "' + key + '" failed with the theme build, retrying with the pinned build:', e && e.message); }
                    return loadFallback(function (ok) { if (ok) { destroyChart(key); el.innerHTML = ''; attempt(true); } else { failed(key, el, e); } });
                }
                failed(key, el, e);
            }
            try {
                if (label) { el.setAttribute('role', 'img'); el.setAttribute('aria-label', label); }
                var ch = new window.ApexCharts(el, options);
                state.charts[key] = ch;
                var p = ch.render();
                if (p && typeof p.catch === 'function') { p.catch(fail); }
            } catch (e) { fail(e); }
        }
        whenApex(function (err) { if (err) { return failed(key, el, err); } attempt(false); });
    }
    function base(type, height, extra) {
        var c = { type: type, height: height, fontFamily: 'inherit', foreColor: C.axis, toolbar: { show: false }, animations: { enabled: !REDUCED, speed: 600 } };
        Object.keys(extra || {}).forEach(function (k) { c[k] = extra[k]; });
        return c;
    }
    var GRID = { borderColor: C.grid, strokeDashArray: 4, padding: { left: 6, right: 6 } };

    /* ------------------------------------------------------------------
       4. Renderers
       ------------------------------------------------------------------ */
    function applyStatic() {
        $$('[data-d]').forEach(function (el) { var k = el.getAttribute('data-d'); var v = (DICT[lang] && DICT[lang][k]) || DICT.en[k]; if (v !== undefined) { el.textContent = v; } });
        $$('[data-d-title]').forEach(function (el) { el.setAttribute('title', t(el.getAttribute('data-d-title'))); });
    }

    function hijri(now) {
        try {
            var loc = (lang === 'ar' ? 'ar-u-ca-islamic-umalqura-nu-latn' : lang + '-u-ca-islamic-umalqura');
            return new Intl.DateTimeFormat(loc, { day: 'numeric', month: 'long', year: 'numeric' }).format(now);
        } catch (e) { return ''; }
    }
    function renderMast(p) {
        var now = new Date(), h = now.getHours();
        setHtml('#ud-greet', esc(t(h < 12 ? 'g_morning' : (h < 17 ? 'g_afternoon' : 'g_evening'))));
        var greg = now.toLocaleDateString(locale(), { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' }), hj = hijri(now);
        setHtml('#ud-date', '<b>' + esc(greg) + '</b>' + (hj ? '<span class="sep"></span><span>' + esc(hj) + '</span>' : ''));

        var q = p.queue || {}, wait = 0;
        (p.services_available || []).forEach(function (s) { wait += s.queue || 0; });
        var comp = p.pipeline.completion, pct = comp === null || comp === undefined ? 0 : comp;
        setHtml('#ud-focus',
            '<div class="' + (wait ? 'is-warn' : '') + '"><div class="fv">' + num(wait) + '</div><div class="fl">' + esc(t('f_wait')) + '</div></div>' +
            '<div class="' + (q.overdue ? 'is-bad' : '') + '"><div class="fv">' + num(q.overdue || 0) + '</div><div class="fl">' + esc(t('f_overdue')) + '</div></div>' +
            '<div><div class="ud-ring"><svg viewBox="0 0 36 36" aria-hidden="true"><circle class="bg" cx="18" cy="18" r="15.9155"/><circle class="fg" id="ud-ring-fg" cx="18" cy="18" r="15.9155"/></svg><b>' + (comp === null || comp === undefined ? '—' : comp + '%') + '</b></div><div class="fl">' + esc(t('f_done')) + '</div></div>');
        var fg = $('#ud-ring-fg'); if (fg) { setTimeout(function () { fg.style.strokeDasharray = pct + ' 100'; }, 60); }
    }

    function renderStamp(p) {
        var d = new Date(p.meta.generated_at);
        setHtml('#ud-stamp', esc(isNaN(d) ? t('updated_now') : t('updated', { t: d.toLocaleTimeString(locale(), { hour: '2-digit', minute: '2-digit' }) })));
    }

    function renderTabs(p) {
        var list = p.services_available || [], total = 0;
        list.forEach(function (s) { total += s.queue || 0; });
        if (list.length < 2) { return setHtml('#ud-tabs', ''); }
        function tab(key, label, color, n) {
            var on = state.service === key;
            return '<button type="button" role="tab" aria-selected="' + on + '" class="ud-tab' + (on ? ' is-on' : '') + '" data-value="' + esc(key) + '" style="--c:' + esc(color) + '">' +
                '<span class="dot"></span><span>' + esc(label) + '</span><span class="n' + (n ? '' : ' zero') + '" title="' + esc(t('st_pending')) + '">' + (n > 99 ? '99+' : n) + '</span></button>';
        }
        setHtml('#ud-tabs', tab('all', t('f_tab_all'), C.green, total) + list.map(function (s) { return tab(s.key, svcLabel(s.key, s.label), s.color, s.queue || 0); }).join(''));
    }
    function syncRange() { $$('#ud-range button').forEach(function (b) { b.classList.toggle('is-on', b.getAttribute('data-value') === state.period); }); }

    function renderNotices(p) {
        var rows = p.alerts || [];
        setHtml('#ud-notices', rows.map(function (a) {
            var text = t(a.k, { n: num(a.n), d: a.d, m: a.m ? svcLabel(a.m) : '' });
            var target = null;
            if (a.m) { (p.services || []).forEach(function (s) { if (s.key === a.m) { target = s.list; } }); }
            else if (a.k === 'al_pending' || a.k === 'al_overdue') { (p.services || []).forEach(function (s) { if (!target && s.queue > 0) { target = s.list; } }); }
            var inner = '<span class="bar"></span><span class="ic"><i class="bx ' + esc(a.icon) + '"></i></span><span class="tx">' + esc(text) + '</span>' + (target ? '<span class="ud-go">' + esc(t('cta_review')) + ' ' + (rtl() ? '←' : '→') + '</span>' : '');
            return target ? '<a class="ud-notice t-' + esc(a.tone) + '" href="' + esc(target) + '">' + inner + '</a>' : '<div class="ud-notice t-' + esc(a.tone) + '">' + inner + '</div>';
        }).join(''));
    }

    function deltaHtml(d) {
        if (!d) { return ''; }
        var icon = d.direction === 'up' ? 'bx-up-arrow-alt' : (d.direction === 'down' ? 'bx-down-arrow-alt' : 'bx-minus');
        return '<span class="delta ' + esc(d.direction) + '" title="' + esc(t('d_title')) + '"><i class="bx ' + icon + '"></i>' + esc(d.percent === null ? t('d_new') : d.percent + '%') + '</span>';
    }
    function metricLink(k) {
        if (k.key === 'pending' || k.key === 'overdue') { var w = (state.payload.services || []).filter(function (s) { return s.queue > 0; })[0]; return w ? w.list : null; }
        return null;
    }
    function subText(s) { return s ? t(s.k, { n: num(s.n) }) : ''; }
    function metricHtml(k, i) {
        var has = k.value !== null && k.value !== undefined, url = metricLink(k), tag = url ? 'a' : 'div';
        return '<' + tag + (url ? ' href="' + esc(url) + '"' : '') + ' class="ud-metric t-' + esc(k.tone) + (k.pulse ? ' is-pulse' : '') + '" style="--i:' + i + '">' +
            '<div class="lb"><i class="bx ' + esc(k.icon) + '"></i><span>' + esc(t('kpi_' + k.key)) + '</span></div>' +
            '<div class="vl"><span class="num"><span class="count" data-to="' + (has ? esc(k.value) : '') + '" data-decimals="' + (k.decimals || 0) + '">' + (has ? num(k.value, k.decimals) : '—') + '</span>' +
            (has && k.suffix ? '<small>' + esc(k.suffix === 'd' ? t('days') : k.suffix) + '</small>' : '') + '</span>' + deltaHtml(k.delta) + '</div>' +
            '<div class="sb">' + esc(subText(k.sub)) + '</div>' +
            (k.progress !== undefined && k.progress !== null ? '<div class="meter"><i data-w="' + esc(k.progress) + '"></i></div>' : '') +
            (k.spark && k.spark.length > 1 && sum(k.spark) > 0 ? '<div class="spark" id="spark-' + esc(k.key) + '"></div>' : '') +
            '</' + tag + '>';
    }
    function animateCounts(scope, animate) {
        $$('.count', scope).forEach(function (el) {
            var raw = el.getAttribute('data-to'); if (raw === '' || raw === null) { return; }
            var to = parseFloat(raw), dec = parseInt(el.getAttribute('data-decimals'), 10) || 0;
            if (!animate || REDUCED) { el.textContent = num(to, dec); return; }
            var t0 = performance.now(), dur = 800;
            (function step(now) { var f = Math.min(1, (now - t0) / dur), e = 1 - Math.pow(1 - f, 3); el.textContent = num(to * e, dec); if (f < 1) { requestAnimationFrame(step); } else { el.textContent = num(to, dec); } })(t0);
        });
    }
    function renderBand(p, animate) {
        destroyPrefix('spark-');
        setHtml('#ud-band', (p.kpis || []).map(metricHtml).join(''));
        var grid = $('#ud-band'); animateCounts(grid, animate);
        $$('.meter i', grid).forEach(function (b) { setTimeout(function () { b.style.width = b.getAttribute('data-w') + '%'; }, 80); });
        (p.kpis || []).forEach(function (k) {
            if (!k.spark || k.spark.length < 2 || sum(k.spark) === 0) { return; }
            mount('spark-' + k.key, $('#spark-' + k.key), {
                chart: base('area', 38, { sparkline: { enabled: true } }), series: [{ name: t('kpi_' + k.key), data: k.spark }], colors: [TONE[k.tone] || C.green],
                stroke: { curve: 'smooth', width: 2 }, fill: { type: 'gradient', gradient: { opacityFrom: .3, opacityTo: .02 } },
                tooltip: { fixed: { enabled: false }, x: { show: false }, y: { title: { formatter: function () { return ''; } } }, marker: { show: false } }
            });
        });
    }

    function renderServices(p) {
        setHtml('#ud-svcs', (p.services || []).map(function (s) {
            var tot = s.total || 0, w = function (v) { return tot ? (v / tot * 100) : 0; }, foot = '';
            if (s.queue > 0) { foot += '<span class="ud-pill p-wait">' + esc(t('svc_wait', { n: num(s.queue) })) + '</span>'; }
            if (s.done > 0) { foot += '<span class="ud-pill p-done">' + esc(t('svc_done', { n: num(s.done) })) + '</span>'; }
            if (s.rejected > 0) { foot += '<span class="ud-pill p-rej">' + esc(t('svc_rej', { n: num(s.rejected) })) + '</span>'; }
            if (s.month > 0) { foot += '<span class="ud-pill p-new">' + esc(t('svc_new', { n: num(s.month) })) + '</span>'; }
            if (!foot) { foot = '<span class="ud-pill">' + esc(t('svc_quiet')) + '</span>'; }
            return '<a class="ud-svc" href="' + esc(s.url) + '" style="--c:' + esc(s.color) + '"><div class="ud-svc__top"><span class="ud-svc__ico"><i class="bx ' + esc(s.icon) + '"></i></span>' +
                '<div><div class="ud-svc__name">' + esc(svcLabel(s.key, s.label)) + '</div><div class="ud-svc__meta">' + esc(s.percent + '% ' + t('st_done').toLowerCase()) + '</div></div><div class="ud-svc__tot">' + num(tot) + '</div></div>' +
                '<div class="ud-svc__bar"><i style="width:' + w(s.done) + '%;background:#136a3b"></i><i style="width:' + w(s.pending) + '%;background:#E0A526"></i><i style="width:' + w(s.rejected) + '%;background:#D64545"></i></div>' +
                '<div class="ud-svc__foot">' + foot + '</div></a>';
        }).join(''));
    }

    function renderTrend() {
        var p = state.payload, el = $('#chart-trend'), tr = p.trend, series = [], total = 0, keys = Object.keys(tr.daily.by);
        var src = state.range === 'daily' ? tr.daily : tr.monthly;
        var cats = state.range === 'daily'
            ? src.dates.map(function (d) { return fmtDate(d, { day: 'numeric', month: 'short' }); })
            : src.keys.map(function (k) { return fmtMonth(k) + ' ' + k.slice(2, 4); });
        keys.forEach(function (k) { var data = src.by[k] || []; total += sum(data); series.push({ name: svcLabel(k, svcMeta(k).label), data: data, color: svcMeta(k).color }); });
        if (!total) { return emptyState('trend', el, 'bx-bar-chart-alt-2', t('no_data')); }
        mount('trend', el, {
            chart: base('bar', 320, { stacked: true }), series: series, colors: series.map(function (s) { return s.color; }),
            plotOptions: { bar: { columnWidth: state.range === 'daily' ? '72%' : '55%' } }, dataLabels: { enabled: false },
            xaxis: { categories: cats, labels: { rotate: 0, style: { colors: C.axis, fontSize: '11px' }, formatter: function (v) { var step = state.range === 'daily' ? 4 : 1; return cats.indexOf(v) % step === 0 ? v : ''; } }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { min: 0, forceNiceScale: true, opposite: rtl(), labels: { formatter: function (v) { return num(Math.round(v)); }, style: { colors: C.axis } } },
            grid: GRID, legend: { position: 'top', horizontalAlign: rtl() ? 'left' : 'right' }, tooltip: { shared: true, intersect: false }
        }, t('c_trend'));
    }

    function renderStatus(p) {
        var tt = p.pipeline.totals, el = $('#chart-status');
        if (!tt.total) { emptyState('status', el, 'bx-pie-chart-alt', t('no_data')); setHtml('#status-foot', ''); return; }
        mount('status', el, {
            chart: base('donut', 290), series: [tt.pending, tt.done, tt.rejected, tt.other], labels: [t('st_pending'), t('st_done'), t('st_rejected'), t('st_other')], colors: [C.amber, C.green, C.red, C.slate],
            stroke: { width: 3, colors: ['#fff'] }, dataLabels: { enabled: false }, legend: { position: 'bottom', fontSize: '12.5px' },
            plotOptions: { pie: { expandOnClick: false, donut: { size: '70%', labels: { show: true, value: { show: true, fontSize: '26px', fontWeight: 800, color: '#10231a', formatter: function (v) { return num(v); } },
                total: { show: true, showAlways: true, label: t('status_total'), fontSize: '12px', color: C.axis, formatter: function () { return num(tt.total); } } } } } },
            tooltip: { y: { formatter: function (v) { return num(v); } } }
        }, t('c_status'));
        var ap = p.pipeline.approval_rate;
        setHtml('#status-foot', '<span>' + esc(t('foot_completion')) + ' <strong>' + (p.pipeline.completion === null ? '—' : p.pipeline.completion + '%') + '</strong></span><span>' + esc(t('foot_approval')) + ' <strong>' + (ap === null ? '—' : ap + '%') + '</strong></span>');
    }

    function renderCompare(p) {
        var el = $('#chart-compare'), list = p.services || [];
        if (!list.length || !sum(list.map(function (s) { return s.total; }))) { return emptyState('compare', el, 'bx-bar-chart-alt-2', t('no_data')); }
        mount('compare', el, {
            chart: base('bar', Math.max(240, list.length * 56 + 70), { stacked: true }),
            series: [{ name: t('st_done'), data: list.map(function (s) { return s.done; }) }, { name: t('st_pending'), data: list.map(function (s) { return s.pending; }) },
                     { name: t('st_rejected'), data: list.map(function (s) { return s.rejected; }) }, { name: t('st_other'), data: list.map(function (s) { return s.other; }) }],
            colors: [C.green, C.amber, C.red, C.slate], plotOptions: { bar: { horizontal: true, barHeight: '58%' } }, dataLabels: { enabled: false },
            xaxis: { categories: list.map(function (s) { return svcLabel(s.key, s.label); }), labels: { formatter: function (v) { return num(Math.round(v)); }, style: { colors: C.axis } }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { opposite: rtl(), labels: { style: { colors: C.axis, fontSize: '12.5px' } } }, grid: GRID,
            legend: { position: 'top', horizontalAlign: rtl() ? 'left' : 'right' }, tooltip: { shared: true, intersect: false }
        }, t('c_compare'));
    }

    function renderBreak(p) {
        var el = $('#chart-break'), b = p.breakdown;
        if (b && b.rows && b.rows.length) {
            setHtml('#break-title', esc(t('c_by', { x: t('by_' + b.key) }))); setHtml('#break-sub', esc(t('c_by_sub')));
            return mount('break', el, {
                chart: base('bar', Math.max(240, b.rows.length * 40 + 60)), series: [{ name: t('records'), data: b.rows.map(function (r) { return r.value; }) }], colors: [C.green],
                plotOptions: { bar: { horizontal: true, barHeight: '60%' } }, dataLabels: { enabled: true, style: { fontSize: '11px' } },
                xaxis: { categories: b.rows.map(function (r) { return r.name; }), labels: { formatter: function (v) { return num(Math.round(v)); } }, axisBorder: { show: false }, axisTicks: { show: false } },
                yaxis: { opposite: rtl(), labels: { style: { colors: C.axis } } }, grid: GRID, legend: { show: false }, tooltip: { y: { formatter: function (v) { return num(v); } } }
            }, t('c_by', { x: t('by_' + b.key) }));
        }
        setHtml('#break-title', esc(t('c_weekday'))); setHtml('#break-sub', esc(t('c_weekday_sub')));
        var wd = p.weekday || [], names = [];
        for (var i = 0; i < 7; i++) { names.push(new Date(2024, 0, 1 + i).toLocaleDateString(locale(), { weekday: 'short' })); }   // 1 Jan 2024 was a Monday
        if (!sum(wd)) { return emptyState('break', el, 'bx-calendar', t('no_data')); }
        var max = Math.max.apply(null, wd);
        mount('break', el, {
            chart: base('bar', 280), series: [{ name: t('records'), data: wd }], colors: wd.map(function (v) { return mixHex('#cfe6d6', '#136a3b', max ? v / max : 0); }),
            plotOptions: { bar: { columnWidth: '58%', distributed: true } }, dataLabels: { enabled: false },
            xaxis: { categories: names, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { min: 0, forceNiceScale: true, opposite: rtl(), labels: { formatter: function (v) { return num(Math.round(v)); } } }, grid: GRID, legend: { show: false }
        }, t('c_weekday'));
    }

    function renderPending(p) {
        var rows = p.pending || [];
        if (!rows.length) { return setHtml('#pending-table', '<div class="ud-empty"><i class="bx bx-check-circle"></i><div>' + esc(t('pending_empty')) + '</div></div>'); }
        setHtml('#pending-table', '<table class="ud-table"><thead><tr><th>' + esc(t('th_ref')) + '</th><th>' + esc(t('th_record')) + '</th><th>' + esc(t('th_place')) + '</th><th>' + esc(t('th_waiting')) + '</th><th></th></tr></thead><tbody>' +
            rows.map(function (r) {
                var cls = r.days >= 14 ? ' late' : (r.days >= 7 ? ' warn' : ''), wait = r.days === 0 ? t('today') : (r.days + ' ' + t(r.days === 1 ? 'day' : 'days'));
                return '<tr><td class="ud-mono">' + esc(r.ref) + '</td><td><span class="ud-rec">' + esc(r.title) + '</span><span class="ud-tag" style="--c:' + esc(r.color) + '">' + esc(svcLabel(r.module, r.label)) + '</span></td>' +
                    '<td>' + esc(r.place || '—') + '</td><td><span class="ud-age' + cls + '">' + esc(wait) + '</span></td><td class="end"><a class="ud-go" href="' + esc(r.url) + '">' + esc(t('review')) + ' ' + (rtl() ? '←' : '→') + '</a></td></tr>';
            }).join('') + '</tbody></table>');
    }

    function renderAging(p) {
        var el = $('#chart-aging'), b = (p.queue && p.queue.buckets) || [0, 0, 0, 0];
        if (!sum(b)) { return emptyState('aging', el, 'bx-check-circle', t('ag_empty')); }
        var od = p.meta.overdue_days || 14;
        mount('aging', el, {
            chart: base('bar', 250), series: [{ name: t('records'), data: b }], colors: ramp(4), plotOptions: { bar: { columnWidth: '55%', distributed: true } }, dataLabels: { enabled: true, style: { fontSize: '12px' } },
            xaxis: { categories: ['0–3', '4–7', '8–' + (od - 1), od + '+'], title: { text: t('ag_unit'), style: { color: C.axis, fontWeight: 600 } }, axisBorder: { show: false }, axisTicks: { show: false } },
            yaxis: { min: 0, forceNiceScale: true, opposite: rtl(), labels: { formatter: function (v) { return num(Math.round(v)); } } }, grid: GRID, legend: { show: false }
        }, t('c_aging'));
    }

    function renderActions(p) {
        var a = p.actions || [];
        setHtml('#actions', a.map(function (x) {
            return '<a class="ud-shortcut" href="' + esc(x.url) + '"><span class="ai"><i class="bx ' + esc(x.icon) + '"></i></span><span style="min-width:0"><b>' + esc(t('a_new', { m: svcLabel(String(x.label).toLowerCase() === 'converts' ? 'convert' : String(x.label).toLowerCase(), x.label) })) + '</b><span class="sm">' + esc(t('a_desc')) + '</span></span></a>';
        }).join(''));
        var show = a.length ? '' : 'none'; var box = $('#actions'), head = $('#actions-head');
        if (box) { box.style.display = show; } if (head) { head.style.display = show; }
    }

    function renderInsights(p) {
        destroyPrefix('ins-');
        var list = p.insights || [], sec = $('#insights-section');
        if (!list.length) { if (sec) { sec.hidden = true; } return; }
        sec.hidden = false;
        setHtml('#insights', list.map(function (ins, i) {
            return '<div class="ud-panel ud-c4"><div class="ud-panel__head"><div><h3 class="ud-panel__title">' + esc(t('ins_' + ins.key)) + '</h3><p class="ud-panel__sub">' + esc(svcLabel(ins.module)) + ' · ' + esc(t('ins_sub')) + '</p></div></div><div class="ud-panel__body"><div id="ins-' + i + '" class="ud-chart" style="min-height:240px"></div></div></div>';
        }).join(''));
        var palette = ['#136a3b', '#c9a500', '#2a5fa8', '#6c4bb0', '#bd3560', '#0e7c86'];
        list.forEach(function (ins, i) {
            var el = $('#ins-' + i), title = t('ins_' + ins.key);
            if (ins.type === 'bar') {
                mount('ins-' + i, el, { chart: base('bar', Math.max(240, ins.labels.length * 40 + 50)), series: [{ name: t('records'), data: ins.values }], colors: [ins.color],
                    plotOptions: { bar: { horizontal: true, barHeight: '58%' } }, dataLabels: { enabled: true, style: { fontSize: '11px' } },
                    xaxis: { categories: ins.labels, labels: { formatter: function (v) { return num(Math.round(v)); } }, axisBorder: { show: false }, axisTicks: { show: false } },
                    yaxis: { opposite: rtl(), labels: { style: { colors: C.axis } } }, grid: GRID, legend: { show: false } }, title);
            } else {
                var tot = sum(ins.values);
                mount('ins-' + i, el, { chart: base('donut', 260), series: ins.values, labels: ins.labels, colors: palette.slice(0, ins.values.length), stroke: { width: 3, colors: ['#fff'] }, dataLabels: { enabled: false },
                    legend: { position: 'bottom', fontSize: '12px' },
                    plotOptions: { pie: { expandOnClick: false, donut: { size: '68%', labels: { show: true, name: { show: false }, value: { show: true, fontSize: '24px', fontWeight: 800, color: '#10231a', formatter: function (v) { return num(v); } },
                        total: { show: true, showAlways: true, label: t('status_total'), fontSize: '12px', color: C.axis, formatter: function () { return num(tot); } } } } } } }, title);
            }
        });
    }

    function stateTone(s) { return s === 'done' ? 'green' : (s === 'rejected' ? 'red' : (s === 'pending' ? 'amber' : 'slate')); }
    function renderRecent(p) {
        var rows = p.recent || [];
        if (!rows.length) { return setHtml('#recent', '<div class="ud-empty"><i class="bx bx-folder-open"></i><div>' + esc(t('recent_empty')) + '</div></div>'); }
        setHtml('#recent', '<ul class="ud-feed">' + rows.map(function (r) {
            var st = r.state === 'done' ? 'st_done' : (r.state === 'rejected' ? 'st_rejected' : (r.state === 'pending' ? 'st_pending' : 'st_other'));
            return '<li class="t-' + stateTone(r.state) + '"><a href="' + esc(r.url) + '"><span class="ic"><i class="bx ' + esc(r.icon) + '"></i></span><span style="min-width:0"><div class="tt">' + esc(r.title) + '</div><div class="mt">' +
                esc(svcLabel(r.module, r.label) + ' · ' + r.ref + ' · ' + t(st)) + '</div></span><span class="tm">' + esc(relTime(r.iso)) + '</span></a></li>';
        }).join('') + '</ul>');
    }
    function renderActivity(p) {
        var rows = p.activity || [];
        if (!rows.length) { return setHtml('#activity', '<div class="ud-empty"><i class="bx bx-pulse"></i><div>' + esc(t('activity_empty')) + '</div></div>'); }
        setHtml('#activity', '<ul class="ud-feed">' + rows.map(function (a) {
            return '<li class="t-' + (a.ok ? 'green' : 'red') + '"><span class="ic"><i class="bx ' + (a.ok ? 'bx-check' : 'bx-error') + '"></i></span><span style="min-width:0"><div class="tt">' + esc(a.text) + '</div></span><span class="tm">' + esc(relTime(a.iso)) + '</span></li>';
        }).join('') + '</ul>');
    }
    function renderGlance(p) {
        var g = p.glance || [], sec = $('#glance-section');
        if (!g.length) { if (sec) { sec.hidden = true; } return; }
        sec.hidden = false;
        setHtml('#glance', g.map(function (x) { return '<a class="ud-fact" href="' + esc(x.url) + '"><i class="bx ' + esc(x.icon) + '"></i><b>' + num(x.value) + '</b><span>' + esc(t('g_' + x.key)) + '</span></a>'; }).join(''));
    }

    function renderAll(animate) {
        var p = state.payload;
        applyStatic(); renderMast(p); renderStamp(p); renderTabs(p); syncRange(); renderNotices(p); renderBand(p, animate); renderServices(p);
        renderTrend(); renderStatus(p); renderCompare(p); renderBreak(p); renderPending(p); renderAging(p); renderActions(p);
        renderInsights(p); renderRecent(p); renderActivity(p); renderGlance(p);
    }

    /* ------------------------------------------------------------------
       5. Data loading, controls, auto-refresh
       ------------------------------------------------------------------ */
    function setLoading(on) { root.classList.toggle('is-loading', !!on); }
    function load(fresh) {
        var id = ++state.reqId; setLoading(true);
        var url = DATA_URL + '?period=' + encodeURIComponent(state.period) + '&service=' + encodeURIComponent(state.service) + (fresh ? '&fresh=1' : '');
        fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, credentials: 'same-origin' })
            .then(function (r) { if (!r.ok) { throw new Error('HTTP ' + r.status); } return r.json(); })
            .then(function (data) {
                if (id !== state.reqId) { return; }
                state.payload = data; state.period = data.filters.period; state.service = data.filters.service;
                renderAll(false);
                try { history.replaceState(null, '', location.pathname + '?period=' + state.period + '&service=' + state.service); } catch (e) { }
            })
            .catch(function (e) { if (window.console) { console.error(e); } toast(t('err_load'), 'error'); })
            .then(function () { if (id === state.reqId) { setLoading(false); } });
    }
    function schedule() {
        clearInterval(state.timer);
        var btn = $('#ud-live'); if (btn) { btn.setAttribute('aria-pressed', state.live ? 'true' : 'false'); }
        if (state.live) { state.timer = setInterval(function () { if (!document.hidden) { load(false); } }, AUTO_MS); }
    }

    var tabs = $('#ud-tabs'); if (tabs) { tabs.addEventListener('click', function (e) { var b = e.target.closest('.ud-tab'); if (!b) { return; } state.service = b.getAttribute('data-value'); renderTabs(state.payload); load(false); }); }
    var rg = $('#ud-range'); if (rg) { rg.addEventListener('click', function (e) { var b = e.target.closest('button'); if (!b) { return; } state.period = b.getAttribute('data-value'); syncRange(); load(false); }); }
    var tr = $('#ud-trange'); if (tr) { tr.addEventListener('click', function (e) { var b = e.target.closest('button'); if (!b) { return; } state.range = b.getAttribute('data-value'); $$('button', tr).forEach(function (x) { x.classList.toggle('is-on', x === b); }); renderTrend(); }); }
    var br = $('#btn-refresh'); if (br) { br.addEventListener('click', function () { load(true); }); }
    var bp = $('#btn-print'); if (bp) { bp.addEventListener('click', function () { window.print(); }); }
    var lv = $('#ud-live'); if (lv) { lv.addEventListener('click', function () { state.live = !state.live; schedule(); }); }

    var renderTimer = null;
    function setLang(l) {
        lang = LANGS.indexOf(l) === -1 ? 'en' : l;
        clearTimeout(renderTimer);
        renderTimer = setTimeout(function () { renderAll(false); }, 30);   // coalesce bursts so a chart is never torn down mid-draw
    }
    document.addEventListener('umsc:langchange', function (e) { setLang((e && e.detail && e.detail.lang) || currentLang()); });

    lang = currentLang();
    var startDir = document.documentElement.dir;
    renderAll(true);
    schedule();
    // The shell may set <html lang/dir> after this script runs; redraw only if that changed anything.
    window.addEventListener('load', function () {
        if (currentLang() !== lang || document.documentElement.dir !== startDir) { setLang(currentLang()); }
    });
})();
