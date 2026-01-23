<td class="pe-4 text-end">
    <div class="btn-group shadow-sm action-group" role="group"
        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">

        <!-- View -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end view-application"
            data-id="{{ $application->id }}" title="View Details">
            <i class="bx bx-show-alt fs-5" style="color:#2563eb;"></i>
        </button>

        <!-- Edit -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end edit-application"
            data-id="{{ $application->id }}" title="Edit Entry">
            <i class="bx bx-edit-alt fs-5" style="color:#16a34a;"></i>
        </button>

        <!-- Download -->
        <a href="#" class="btn btn-white btn-sm px-2 border-end" title="Download Application">
            <i class="bx bx-download fs-5" style="color:#ff5e00;"></i>
        </a>

        <!-- Update Status -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end update-status"
            data-id="{{ $application->id }}" title="Update Status">
            <i class="bx bx-refresh fs-5" style="color:#8b5cf6;"></i>
        </button>

        <!-- Delete -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end delete-application"
            data-id="{{ $application->id }}" title="Delete Application">
            <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
        </button>

    </div>
</td>