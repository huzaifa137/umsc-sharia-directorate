{{-- Shared Change-Status modal (Director only).
     Works for Divorce, Inheritance, Guardianship and Converts by reading
     data-module and data-id from the button that was clicked. --}}

<div class="modal fade" id="sharedUpdateStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 420px;">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,.2);">

            <div class="modal-header text-white" style="background: #00580f; border-radius: 16px 16px 0 0;">
                <div>
                    <h5 class="modal-title fw-bold mb-0">
                        <i class="bx bx-refresh me-2"></i>Update Status
                    </h5>
                    <small class="opacity-75" id="sharedStatusAppId"></small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-4">
                <p class="text-muted mb-3">
                    Current status: <strong id="sharedCurrentStatus"></strong>
                </p>
                <p class="fw-bold mb-3">Select new status:</p>

                <div class="d-flex flex-wrap gap-2" id="sharedStatusOptions">
                    <!-- Populated by JS based on module -->
                </div>
            </div>

        </div>
    </div>
</div>

<script>
(function () {
    const moduleStatuses = {
        divorce: [
            { value: 'submitted',    label: 'Submitted',    color: '#b58900' },
            { value: 'accomplished', label: 'Accomplished', color: '#059568' },
            { value: 'rejected',     label: 'Rejected',     color: '#dc2626' },
        ],
        inheritance: [
            { value: 'submitted',    label: 'Submitted',    color: '#b58900' },
            { value: 'accomplished', label: 'Accomplished', color: '#059568' },
            { value: 'rejected',     label: 'Rejected',     color: '#dc2626' },
        ],
        guardianship: [
            { value: 'submitted',    label: 'Submitted',    color: '#b58900' },
            { value: 'active',       label: 'Active',       color: '#2563eb' },
            { value: 'accomplished', label: 'Accomplished', color: '#059568' },
            { value: 'rejected',     label: 'Rejected',     color: '#dc2626' },
        ],
        convert: [
            { value: 'pending',      label: 'Pending',      color: '#b58900' },
            { value: 'accomplished', label: 'Accomplished', color: '#059568' },
            { value: 'rejected',     label: 'Rejected',     color: '#dc2626' },
        ],
    };

    const urlMap = {
        divorce:     '/divorce-status-update',
        inheritance: '/inheritance-status-update',
        guardianship:'/guardianship-status-update',
        convert:     '/convert-status-update',
    };

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.update-status-btn');
        if (!btn) return;

        e.preventDefault();

        const id     = btn.dataset.id;
        const module = btn.dataset.module;
        const current= btn.dataset.status ?? '';

        document.getElementById('sharedStatusAppId').textContent  = 'Application ID: ' + id;
        document.getElementById('sharedCurrentStatus').textContent = current.charAt(0).toUpperCase() + current.slice(1);

        const optContainer = document.getElementById('sharedStatusOptions');
        optContainer.innerHTML = '';

        (moduleStatuses[module] ?? []).forEach(opt => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn fw-bold flex-fill';
            button.style.cssText = `background:${opt.color}18; color:${opt.color}; border:1px solid ${opt.color}40;`;
            button.textContent = opt.label;
            button.dataset.value = opt.value;
            optContainer.appendChild(button);
        });

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('sharedUpdateStatusModal')
        ).show();

        optContainer.addEventListener('click', function handler(ev) {
            const picked = ev.target.closest('button[data-value]');
            if (!picked) return;

            const newStatus = picked.dataset.value;

            Swal.fire({
                title: 'Confirm Status Change',
                text: `Set status to "${newStatus}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#00580f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, update',
            }).then(result => {
                if (!result.isConfirmed) return;

                optContainer.removeEventListener('click', handler);

                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

                fetch(`${urlMap[module]}/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: newStatus }),
                })
                .then(async res => {
                    const text = await res.text();
                    let data;
                    try { data = JSON.parse(text); } catch { data = { success: false, message: text }; }
                    return data;
                })
                .then(data => {
                    bootstrap.Modal.getInstance(
                        document.getElementById('sharedUpdateStatusModal')
                    )?.hide();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: data.message ?? 'Status updated successfully.',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => location.reload());
                    } else {
                        Swal.fire('Error', data.message ?? 'Update failed.', 'error');
                    }
                })
                .catch(err => {
                    Swal.fire('Error', 'Could not connect to the server.', 'error');
                    console.error(err);
                });
            });
        }, { once: true });
    });
}());
</script>
