<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        setLanguage('en');

        document.querySelectorAll('.lang-btn').forEach(btn => {
            btn.classList.toggle('active', btn.dataset.lang === 'en');
        });
    });

    document.querySelectorAll('.lang-btn').forEach(button => {
        button.addEventListener('click', function() {
            const lang = this.dataset.lang;

            document.querySelectorAll('.lang-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            document.querySelectorAll('[data-i18n]').forEach(el => {
                const key = el.getAttribute('data-i18n');
                if (translations[lang] && translations[lang][key]) {
                    el.innerHTML = translations[lang][key];
                }
            });

            document.documentElement.dir = (lang === 'ar') ? 'rtl' : 'ltr';
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            allowClear: true,
            width: '100%'
        });
    });
</script>

<script>
    document.getElementById('backToDashboard').addEventListener('click', function(e) {
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
</script>

</body>

</html>
