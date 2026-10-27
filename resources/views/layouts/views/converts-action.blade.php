@php($isDirector = \App\Services\AccessControl::hasFullAccess())
<td class="pe-4 text-end">
    <div class="btn-group shadow-sm action-group" role="group"
        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">

        <!-- View -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end view-application"
            data-bs-toggle="modal" data-bs-target="#viewModal"
            data-id="{{ $application->id }}"
            data-application="{{ json_encode($application) }}" title="View Details">
            <i class="bx bx-show-alt fs-5" style="color:#2563eb;"></i>
        </button>

        <!-- Edit -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end edit-application"
            data-bs-toggle="modal" data-bs-target="#editModal"
            data-id="{{ $application->id }}"
            data-application="{{ json_encode($application) }}" title="Edit Entry">
            <i class="bx bx-edit-alt fs-5" style="color:#16a34a;"></i>
        </button>

        @if($isDirector)
            <!-- Change Status -->
            <button type="button" class="btn btn-white btn-sm px-2 border-end update-status-btn"
                data-id="{{ $application->id }}" data-status="{{ $application->status }}"
                data-module="convert" title="Change Status">
                <i class="bx bx-refresh fs-5" style="color:#8b5cf6;"></i>
            </button>

            <!-- Download -->
            <a href="{{ url('reports/convert') }}?status={{ $application->status }}"
                class="btn btn-white btn-sm px-2 border-end" title="Download Report">
                <i class="bx bx-download fs-5" style="color:#ff5e00;"></i>
            </a>

            <!-- Delete -->
            <button type="button" class="btn btn-white btn-sm px-2 delete-application"
                data-id="{{ $application->id }}" title="Delete Application">
                <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
            </button>
        @endif

    </div>
</td>