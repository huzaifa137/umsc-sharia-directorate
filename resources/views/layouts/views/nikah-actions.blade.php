@php($isDirector = \App\Services\AccessControl::hasFullAccess())
<td class="pe-4 text-end">
    <div class="btn-group shadow-sm action-group" role="group"
        style="border-radius: 8px; overflow: hidden; border: 1px solid #e2e8f0;">

        <!-- Full record -->
        <a href="{{ url('records/nikah/' . $application->id) }}" class="btn btn-white btn-sm px-2 border-end" title="Open full record">
            <i class="bx bx-folder-open fs-5" style="color:#136a3b;"></i>
        </a>

        <!-- View -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end view-application"
            data-id="{{ $application->id }}" title="View Application">
            <i class="bx bx-show-alt fs-5" style="color:#2563eb;"></i>
        </button>

        <!-- Edit -->
        <button type="button" class="btn btn-white btn-sm px-2 border-end edit-application"
            data-id="{{ $application->id }}" title="Edit Entry">
            <i class="bx bx-edit-alt fs-5" style="color:#16a34a;"></i>
        </button>

        @if($isDirector)
            <!-- Change Status -->
            <button type="button" class="btn btn-white btn-sm px-2 border-end update-status-btn"
                data-id="{{ $application->id }}" data-status="{{ $application->status === 'submitted' ? 'pending' : $application->status }}"
                data-module="nikah" title="Change Status">
                <i class="bx bx-refresh fs-5" style="color:#8b5cf6;"></i>
            </button>

            <!-- Download certificate -->
            <button type="button" class="btn btn-white btn-sm px-2 border-end download-certificate"
                data-id="{{ $application->id }}" title="Download Certificate">
                <i class="bx bx-download fs-5" style="color:#ff5e00;"></i>
            </button>

            <!-- Delete -->
            <a href="javascript:void(0)" class="btn btn-white btn-sm px-2 border-end delete-application"
                data-id="{{ $application->id }}" title="Delete Application">
                <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
            </a>
        @endif

    </div>
</td>
