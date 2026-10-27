<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $('.select2').select2({
            allowClear: true,
            width: '100%'
        });
    });
</script>

<script>
    // Shared language switcher for all application forms.
    // Requires each form to define its own `translations = { en:{}, ar:{}, sw:{} }`
    // object and tag translatable elements with data-i18n="key" (supports "a.b.c" dot-paths
    // for nested translation objects, e.g. data-i18n="property_type_options.land").
    let currentLanguage = localStorage.getItem('app_language') || 'en';

    function resolveTranslationKey(dict, key) {
        return key.split('.').reduce(function (obj, part) {
            return (obj && obj[part] !== undefined) ? obj[part] : undefined;
        }, dict);
    }

    function changeLanguage(lang) {
        if (typeof translations === 'undefined' || !translations[lang]) return;

        currentLanguage = lang;
        localStorage.setItem('app_language', lang);
        document.documentElement.lang = lang;
        document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';

        document.querySelectorAll('[data-i18n]').forEach(function (el) {
            const key = el.getAttribute('data-i18n');
            const value = resolveTranslationKey(translations[lang], key);
            if (value === undefined) return; // leave default text if key missing

            // Inputs/textareas: translate placeholder, not textContent
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.setAttribute('placeholder', value);
            } else {
                el.textContent = value;
            }
        });

        // Legacy support: some forms used a separate data-i18n-placeholder attribute
        document.querySelectorAll('[data-i18n-placeholder]').forEach(function (el) {
            const key = el.getAttribute('data-i18n-placeholder');
            const value = resolveTranslationKey(translations[lang], key);
            if (value !== undefined) el.setAttribute('placeholder', value);
        });

        document.querySelectorAll('.lang-btn').forEach(function (btn) {
            btn.classList.toggle('active', btn.dataset.lang === lang);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.lang-btn').forEach(function (btn) {
            btn.addEventListener('click', function () {
                changeLanguage(this.dataset.lang);
            });
        });

        if (currentLanguage !== 'en') {
            changeLanguage(currentLanguage);
        }
    });
</script>

<script>
    const backToDashboardBtn = document.getElementById('backToDashboard');
    if (backToDashboardBtn) {
        backToDashboardBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const url = this.href;

        Swal.fire({
            title: 'Are you sure?',
            text: 'Any unsaved changes may be lost.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, continue',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
        });
    }
</script>

</body>

</html>