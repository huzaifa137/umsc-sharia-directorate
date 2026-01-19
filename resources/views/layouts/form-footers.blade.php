<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    document.getElementById('backToDashboard').addEventListener('click', function (e) {
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