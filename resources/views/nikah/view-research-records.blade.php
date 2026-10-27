@extends('layouts.app')

@section('content')
    <style>
        .action-group .btn {
            background: #ffffff;
            padding-top: 6px;
            padding-bottom: 6px;
            transition: all 0.2s;
            border: none;
        }

        .action-group .btn:hover {
            background: #f8fafc;
            color: #059568 !important;
        }

        .action-group .btn-white i {
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(5, 149, 104, 0.02) !important;
        }
    </style>


    <style>
        /* Custom Modal Styling */
        .modal-content {
            border-radius: 20px !important;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: #008F4C;
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 1.5rem 2rem;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .modal-footer {
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
            padding: 1rem 2rem;
        }

        /* Section Styling */
        .section-title {
            color: #4a5568;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 60px;
            height: 2px;
            background: #667eea;
        }

        /* Card Styling */
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Person Card */
        .person-card {
            border-left: 4px solid #667eea;
        }

        .bride-card {
            border-left-color: #ed64a6;
        }

        .photo-container {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fed7d7;
            color: #c53030;
        }

        .status-approved {
            background: #c6f6d5;
            color: #276749;
        }

        .status-rejected {
            background: #fed7d7;
            color: #c53030;
        }

        .status-completed {
            background: #bee3f8;
            color: #2c5282;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-item {
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 8px;
            border-left: 3px solid #cbd5e0;
        }

        .info-item label {
            display: block;
            font-size: 0.8rem;
            color: #718096;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item .value {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95rem;
        }

        /* Contact Styling */
        .contact-item {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0;
        }

        /* Parent Card */
        .parent-card {
            border-left: 3px solid #48bb78;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f0fff4;
        }

        /* Witness Card */
        .witness-card {
            border-left: 3px solid #ed8936;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fffaf0;
        }

        /* Imam Styling */
        .imam-assigned {
            color: #2b6cb0;
            font-weight: 600;
            padding: 0.75rem;
            background: #ebf8ff;
            border-radius: 8px;
            display: inline-block;
        }

        .imam-not-assigned {
            color: #718096;
            font-style: italic;
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 8px;
            display: inline-block;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 1rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .photo-container {
                margin: 0 auto 1rem;
            }
        }

        .modal-dialog-scrollable .modal-content {
            max-height: 85vh;
            overflow: hidden;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            max-height: calc(85vh - 120px);
        }
    </style>

    <style>
        /* Custom Modal Styling */
        .modal-content {
            border-radius: 20px !important;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background: #008F4C;
            color: white;
            border-radius: 20px 20px 0 0 !important;
            padding: 1.5rem 2rem;
        }

        .modal-header .btn-close {
            filter: invert(1);
            opacity: 0.8;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 2rem;
            background: #f8f9fa;
        }

        .modal-footer {
            background: #f8f9fa;
            border-radius: 0 0 20px 20px;
            padding: 1rem 2rem;
        }

        /* Section Styling */
        .section-title {
            color: #4a5568;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 60px;
            height: 2px;
            background: #667eea;
        }

        /* Card Styling */
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Person Card */
        .person-card {
            border-left: 4px solid #667eea;
        }

        .bride-card {
            border-left-color: #ed64a6;
        }

        .photo-container {
            width: 120px;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .photo-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 0.35rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background: #fed7d7;
            color: #c53030;
        }

        .status-approved {
            background: #c6f6d5;
            color: #276749;
        }

        .status-rejected {
            background: #fed7d7;
            color: #c53030;
        }

        .status-completed {
            background: #bee3f8;
            color: #2c5282;
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .info-item {
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 8px;
            border-left: 3px solid #cbd5e0;
        }

        .info-item label {
            display: block;
            font-size: 0.8rem;
            color: #718096;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-item .value {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.95rem;
        }

        /* Contact Styling */
        .contact-item {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0;
        }

        /* Parent Card */
        .parent-card {
            border-left: 3px solid #48bb78;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f0fff4;
        }

        /* Witness Card */
        .witness-card {
            border-left: 3px solid #ed8936;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fffaf0;
        }

        /* Imam Styling */
        .imam-assigned {
            color: #2b6cb0;
            font-weight: 600;
            padding: 0.75rem;
            background: #ebf8ff;
            border-radius: 8px;
            display: inline-block;
        }

        .imam-not-assigned {
            color: #718096;
            font-style: italic;
            padding: 0.75rem;
            background: #f7fafc;
            border-radius: 8px;
            display: inline-block;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .modal-dialog {
                margin: 1rem;
            }

            .modal-body {
                padding: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .photo-container {
                margin: 0 auto 1rem;
            }
        }

        .modal-dialog-scrollable .modal-content {
            max-height: 85vh;
            overflow: hidden;
        }

        .modal-dialog-scrollable .modal-body {
            overflow-y: auto;
            max-height: calc(85vh - 120px);
        }
    </style>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
            <div>
                <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;color:#059580;">Nikah APPLICATIONS</h2>
            </div>
            <div class="avatar-group">
                <div class="bg-light p-2 rounded-3">
                    <i class="bx bx-calendar text-success me-2"></i>
                    <span id="currentDateFull" class="small fw-medium"></span>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 16px;">

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-muted small fw-bold text-center">
                                    ACTIVITY & ID
                                </th>
                                <th class="border-0 text-muted small fw-bold text-center">
                                    DESCRIPTION
                                </th>
                                <th class="border-0 text-muted small fw-bold text-center">
                                    TIMELINE
                                </th>
                                <th class="border-0 text-muted small fw-bold text-center">
                                    STATUS
                                </th>
                                <th class="pe-4 border-0 text-muted small fw-bold text-center" style="width: 150px;">
                                    MANAGEMENT
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $application)
                                <tr class="border-bottom border-light application-row" data-search="
                                                                        {{ strtolower($application->application_id) }}
                                                                        {{ strtolower($application->groom_given_name) }}
                                                                        {{ strtolower($application->groom_surname) }}
                                                                        {{ strtolower($application->bride_given_name) }}
                                                                        {{ strtolower($application->bride_surname) }}
                                                                        {{ strtolower($application->status) }}
                                                                    ">

                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                                style="background: #05956820; width: 40px; height: 40px;">
                                                <i class="bx bx-heart fs-4" style="color: #059568;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Nikah</h6>
                                                <small class="text-muted text-uppercase"
                                                    style="font-size: 10px; letter-spacing: 0.5px;">
                                                    #{{ $application->application_id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">
                                            {{ trim($application->groom_given_name . ' ' . $application->groom_surname) }}
                                            &
                                            {{ trim($application->bride_given_name . ' ' . $application->bride_surname) }}
                                        </p>
                                        <small class="text-muted">Bride & Groom Names</small>
                                    </td>


                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="small fw-bold text-dark">
                                                {{ $application->created_at }}
                                            </span>
                                            <span class="text-muted" style="font-size: 11px;">
                                                <p>Date & Time</p>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @php
                                            $statusColors = [
                                                'approved' => ['#05956815', '#059568'], // green
                                                'pending' => ['#FFF7E6', '#FF9F43'], // yellow
                                                'rejected' => ['#FFE5E5', '#EA5455'], // red
                                            ];

                                            // Map 'submitted' to 'pending' for color purposes
                                            $statusKey =
                                                $application->status === 'submitted' ? 'pending' : $application->status;

                                            $bg = $statusColors[$statusKey][0] ?? '#E7F3FF';
                                            $color = $statusColors[$statusKey][1] ?? '#0D6EFD';
                                        @endphp

                                        <span class="badge rounded-pill px-3"
                                            style="background: {{ $bg }}; color: {{ $color }}; border: 1px solid {{ $color }}30;">
                                            {{ $application->status === 'submitted' ? 'Pending' : ucfirst($application->status) }}
                                        </span>


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
                                            <a href="#" class="btn btn-white btn-sm px-2 border-end"
                                                title="Download Application">
                                                <i class="bx bx-download fs-5" style="color:#ff5e00;"></i>
                                            </a>

                                            <!-- Update Status -->
                                            <button type="button" class="btn btn-white btn-sm px-2 border-end update-status"
                                                data-id="{{ $application->id }}" title="Update Status">
                                                <i class="bx bx-refresh fs-5" style="color:#8b5cf6;"></i>
                                            </button>

                                            <!-- Delete -->
                                            <button type="button"
                                                class="btn btn-white btn-sm px-2 border-end delete-application"
                                                data-id="{{ $application->id }}" title="Delete Application">
                                                <i class="bx bx-trash-alt fs-5" style="color:#dc2626;"></i>
                                            </button>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bx bx-folder-open fs-1 mb-2"></i>
                                        <p class="mb-0">No Nikah applications found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4 me-4">
                        {{-- {{ $applications->links('pagination::bootstrap-5') }} --}}
                    </div>

                    <!-- Update Status Modal -->
                    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title text-white" id="updateStatusModalLabel">Update Application
                                        Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Current Status: <strong id="currentStatusText"></strong></p>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-warning status-option" data-status="pending">
                                            <i class="bx bx-time me-1"></i> Pending
                                        </button>
                                        <button type="button" class="btn btn-success status-option" data-status="approved">
                                            <i class="bx bx-check-circle me-1"></i> Approved
                                        </button>
                                        <button type="button" class="btn btn-danger status-option" data-status="rejected">
                                            <i class="bx bx-x-circle me-1"></i> Terminate
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="editApplicationModal" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">

                                <!-- HEADER -->
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title text-white">Edit Nikah Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form id="editApplicationForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="edit_id">

                                    <div class="modal-body">

                                        <!-- ================= GROOM ================= -->
                                        <h6 class="fw-bold text-success">Groom Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label>Given Name</label>
                                                <input type="text" name="groom_given_name" id="groom_given_name"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Surname</label>
                                                <input type="text" name="groom_surname" id="groom_surname"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>NIN</label>
                                                <input type="text" name="groomNIN" id="groomNIN" class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label>DOB Day</label>
                                                <input type="number" name="groom_day_date_of_birth"
                                                    id="groom_day_date_of_birth" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>DOB Month</label>
                                                <input type="number" name="groom_month_date_of_birth"
                                                    id="groom_month_date_of_birth" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>DOB Year</label>
                                                <input type="number" name="groom_year_date_of_birth"
                                                    id="groom_year_date_of_birth" class="form-control">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Country</label>
                                                <input type="text" name="groom_country" id="groom_country"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Telephone</label>
                                                <input type="text" name="groom_telephone" id="groom_telephone"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Email</label>
                                                <input type="email" name="groom_email" id="groom_email"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Tribe</label>
                                                <input type="text" name="groom_tribe" id="groom_tribe" class="form-control">
                                            </div>

                                            <div class="col-md-3"><label>District</label><input type="text"
                                                    name="groom_district" id="groom_district" class="form-control"></div>
                                            <div class="col-md-3"><label>County</label><input type="text"
                                                    name="groom_county" id="groom_county" class="form-control"></div>
                                            <div class="col-md-3"><label>Sub County</label><input type="text"
                                                    name="groom_sub_county" id="groom_sub_county" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>Parish</label><input type="text"
                                                    name="groom_parish" id="groom_parish" class="form-control"></div>
                                            <div class="col-md-3"><label>Village</label><input type="text"
                                                    name="groom_village" id="groom_village" class="form-control"></div>
                                            <div class="col-md-3"><label>Plot</label><input type="text" name="groom_plot"
                                                    id="groom_plot" class="form-control"></div>
                                        </div>

                                        <hr>

                                        <!-- ================= BRIDE ================= -->
                                        <h6 class="fw-bold text-danger">Bride Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label>Given Name</label><input type="text"
                                                    name="bride_given_name" id="bride_given_name" class="form-control">
                                            </div>
                                            <div class="col-md-4"><label>Surname</label><input type="text"
                                                    name="bride_surname" id="bride_surname" class="form-control"></div>
                                            <div class="col-md-4"><label>NIN</label><input type="text" name="brideNIN"
                                                    id="brideNIN" class="form-control"></div>

                                            <div class="col-md-2"><label>DOB Day</label><input type="number"
                                                    name="bride_day_date_of_birth" id="bride_day_date_of_birth"
                                                    class="form-control"></div>
                                            <div class="col-md-2"><label>DOB Month</label><input type="number"
                                                    name="bride_month_date_of_birth" id="bride_month_date_of_birth"
                                                    class="form-control"></div>
                                            <div class="col-md-2"><label>DOB Year</label><input type="number"
                                                    name="bride_year_date_of_birth" id="bride_year_date_of_birth"
                                                    class="form-control"></div>

                                            <div class="col-md-3"><label>Country</label><input type="text"
                                                    name="bride_country" id="bride_country" class="form-control"></div>
                                            <div class="col-md-3"><label>Telephone</label><input type="text"
                                                    name="bride_telephone" id="bride_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>Email</label><input type="email" name="bride_email"
                                                    id="bride_email" class="form-control"></div>

                                            <div class="col-md-3"><label>Tribe</label><input type="text" name="bride_tribe"
                                                    id="bride_tribe" class="form-control"></div>

                                            <div class="col-md-3"><label>District</label><input type="text"
                                                    name="bride_district" id="bride_district" class="form-control"></div>
                                            <div class="col-md-3"><label>County</label><input type="text"
                                                    name="bride_county" id="bride_county" class="form-control"></div>
                                            <div class="col-md-3"><label>Sub County</label><input type="text"
                                                    name="bride_sub_county" id="bride_sub_county" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>Parish</label><input type="text"
                                                    name="bride_parish" id="bride_parish" class="form-control"></div>
                                            <div class="col-md-3"><label>Village</label><input type="text"
                                                    name="bride_village" id="bride_village" class="form-control"></div>
                                            <div class="col-md-3"><label>Plot</label><input type="text" name="bride_plot"
                                                    id="bride_plot" class="form-control"></div>
                                        </div>

                                        <hr>

                                        <!-- ================= WITNESSES ================= -->
                                        <h6 class="fw-bold text-warning">Witnesses</h6>
                                        <div class="row g-3">
                                            <div class="col-md-3"><label>Witness 1 Given</label><input type="text"
                                                    name="witness1_given_name" id="witness1_given_name"
                                                    class="form-control"></div>
                                            <div class="col-md-3"><label>Witness 1 Surname</label><input type="text"
                                                    name="witness1_surname" id="witness1_surname" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>NIN</label><input type="text" name="witness1_nin"
                                                    id="witness1_nin" class="form-control"></div>
                                            <div class="col-md-3"><label>Telephone</label><input type="text"
                                                    name="witness1_telephone" id="witness1_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>Address</label><input type="text"
                                                    name="witness1_address" id="witness1_address" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>District</label><input type="text"
                                                    name="witness1District" id="witness1District" class="form-control">
                                            </div>

                                            <div class="col-md-3"><label>Witness 2 Given</label><input type="text"
                                                    name="witness2_given_name" id="witness2_given_name"
                                                    class="form-control"></div>
                                            <div class="col-md-3"><label>Witness 2 Surname</label><input type="text"
                                                    name="witness2_surname" id="witness2_surname" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>NIN</label><input type="text" name="witness2_nin"
                                                    id="witness2_nin" class="form-control"></div>
                                            <div class="col-md-3"><label>Telephone</label><input type="text"
                                                    name="witness2_telephone" id="witness2_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>Address</label><input type="text"
                                                    name="witness2_address" id="witness2_address" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>District</label><input type="text"
                                                    name="witness2District" id="witness2District" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- ================= IMAM ================= -->
                                        <h6 class="fw-bold text-primary">Imam</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label>Imam Name</label>
                                                <input type="text" name="imam_name" id="imam_name" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- FOOTER -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle-fill me-2"></i> Close
                                        </button>

                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="bi bi-check-circle-fill me-2"></i> Update Application
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- View Application Modal -->
                    <div class="modal fade" id="viewApplicationModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title fw-bold text-white"><i
                                                class="fas fa-file-contract me-2"></i>Marriage
                                            Application Details</h5>
                                        <p class="small mb-0 opacity-75">Complete application information</p>
                                    </div>
                                    <button type="button" style="
                        background-color: #4e8d5e;
                        color: #ffffff;
                        border: none;
                        font-size: 1.7rem;
                        line-height: 1;
                        padding: 0.25rem 0.5rem;
                        border-radius: 0.25rem;
                        cursor: pointer;
                    " data-bs-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <!-- Application Info Card -->
                                    <div class="info-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="section-title mb-0">Application Information</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application ID</label>
                                                    <div class="value" id="view_application_id"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application Date</label>
                                                    <div class="value" id="view_date"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application Status</label>
                                                    <div class="value" id="view_status"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Couple Information -->
                                    <h6 class="section-title mt-4">Couple Information</h6>
                                    <div class="row">
                                        <!-- Groom Card -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="info-card person-card">
                                                <div class="d-flex align-items-start">
                                                    <div class="photo-container me-3">
                                                        <img id="view_groom_photo" src="" alt="Groom Photo"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2 text-primary">
                                                            <i class="fas fa-user-tie me-2"></i>Groom
                                                        </h6>
                                                        <h5 class="mb-3" id="view_groom"></h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <label>NIN</label>
                                                                <div class="value" id="view_groomNIN"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Date of Birth</label>
                                                                <div class="value" id="view_groom_dob"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Contact</label>
                                                                <div class="value" id="view_groom_contact"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Tribe & Country</label>
                                                                <div class="value" id="view_groom_tribe_country"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="text-muted small">Address</label>
                                                            <p class="mb-0" id="view_groom_address"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride Card -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="info-card person-card bride-card">
                                                <div class="d-flex align-items-start">
                                                    <div class="photo-container me-3">
                                                        <img id="view_bride_photo" src="" alt="Bride Photo"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2 text-pink">
                                                            <i class="fas fa-user-dress me-2"></i>Bride
                                                        </h6>
                                                        <h5 class="mb-3" id="view_bride"></h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <label>NIN</label>
                                                                <div class="value" id="view_brideNIN"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Date of Birth</label>
                                                                <div class="value" id="view_bride_dob"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Contact</label>
                                                                <div class="value" id="view_bride_contact"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Tribe & Country</label>
                                                                <div class="value" id="view_bride_tribe_country"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="text-muted small">Address</label>
                                                            <p class="mb-0" id="view_bride_address"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Parents Information -->
                                    <h6 class="section-title mt-4">Parents Information</h6>
                                    <div class="row">
                                        <!-- Groom's Parents -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="parent-card">
                                                <h6 class="fw-bold text-success mb-3">
                                                    <i class="fas fa-people-roof me-2"></i>Groom's Parents
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Father</label>
                                                            <p class="fw-bold mb-1" id="view_groom_father"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_groomFatherStatus"></span>
                                                                NIN: <span id="view_groom_father_nin"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_groomFatherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Tribe: <span id="view_groomFatherTribe"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Mother</label>
                                                            <p class="fw-bold mb-1" id="view_groom_mother"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_groomMotherStatus"></span>
                                                                NIN: <span id="view_groomMotherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_groomMotherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Maiden Name: <span id="view_groomMotherMaidenName"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's Parents -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="parent-card">
                                                <h6 class="fw-bold text-success mb-3">
                                                    <i class="fas fa-people-roof me-2"></i>Bride's Parents
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Father</label>
                                                            <p class="fw-bold mb-1" id="view_bride_father"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_brideFatherStatus"></span>
                                                                NIN: <span id="view_brideFatherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_brideFatherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Tribe: <span id="view_brideFatherTribe"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Mother</label>
                                                            <p class="fw-bold mb-1" id="view_bride_mother"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_brideMotherStatus"></span>
                                                                NIN: <span id="view_brideMotherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_brideMotherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Maiden Name: <span id="view_brideMotherMaidenName"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Witnesses -->
                                    <h6 class="section-title mt-4">Witnesses</h6>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="witness-card">
                                                <h6 class="fw-bold text-warning mb-3">
                                                    <i class="fas fa-user-check me-2"></i>Witness 1
                                                </h6>
                                                <p class="fw-bold mb-2" id="view_witness1_name"></p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-id-card me-2"></i>
                                                            NIN: <span id="view_witness1_nin"></span>
                                                        </p>
                                                        <p class="small mb-1">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Phone: <span id="view_witness1_phone"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-map-marker-alt me-2"></i>
                                                            District: <span id="view_witness1_district"></span>
                                                        </p>
                                                        <p class="small mb-0">
                                                            <i class="fas fa-home me-2"></i>
                                                            Address: <span id="view_witness1_address"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="witness-card">
                                                <h6 class="fw-bold text-warning mb-3">
                                                    <i class="fas fa-user-check me-2"></i>Witness 2
                                                </h6>
                                                <p class="fw-bold mb-2" id="view_witness2_name"></p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-id-card me-2"></i>
                                                            NIN: <span id="view_witness2_nin"></span>
                                                        </p>
                                                        <p class="small mb-1">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Phone: <span id="view_witness2_phone"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-map-marker-alt me-2"></i>
                                                            District: <span id="view_witness2_district"></span>
                                                        </p>
                                                        <p class="small mb-0">
                                                            <i class="fas fa-home me-2"></i>
                                                            Address: <span id="view_witness2_address"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Imam Assignment -->
                                    <div class="info-card mt-4">
                                        <h6 class="section-title mb-0">Wedding Imam</h6>
                                        <div class="d-flex align-items-center mt-3">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1" id="view_imam_name"></h5>
                                                <p class="small text-muted mb-0">Imam assigned to conduct the marriage
                                                    ceremony</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-user-circle fa-3x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="editApplicationModal" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">

                                <!-- HEADER -->
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title text-white">Edit Nikah Application</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form id="editApplicationForm" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="edit_id">

                                    <div class="modal-body">

                                        <!-- ================= GROOM ================= -->
                                        <h6 class="fw-bold text-success">Groom Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label>Given Name</label>
                                                <input type="text" name="groom_given_name" id="groom_given_name"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>Surname</label>
                                                <input type="text" name="groom_surname" id="groom_surname"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label>NIN</label>
                                                <input type="text" name="groomNIN" id="groomNIN" class="form-control">
                                            </div>

                                            <div class="col-md-2">
                                                <label>DOB Day</label>
                                                <input type="number" name="groom_day_date_of_birth"
                                                    id="groom_day_date_of_birth" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>DOB Month</label>
                                                <input type="number" name="groom_month_date_of_birth"
                                                    id="groom_month_date_of_birth" class="form-control">
                                            </div>
                                            <div class="col-md-2">
                                                <label>DOB Year</label>
                                                <input type="number" name="groom_year_date_of_birth"
                                                    id="groom_year_date_of_birth" class="form-control">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Country</label>
                                                <input type="text" name="groom_country" id="groom_country"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Telephone</label>
                                                <input type="text" name="groom_telephone" id="groom_telephone"
                                                    class="form-control">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Email</label>
                                                <input type="email" name="groom_email" id="groom_email"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-3">
                                                <label>Tribe</label>
                                                <input type="text" name="groom_tribe" id="groom_tribe" class="form-control">
                                            </div>

                                            <div class="col-md-3"><label>District</label><input type="text"
                                                    name="groom_district" id="groom_district" class="form-control"></div>
                                            <div class="col-md-3"><label>County</label><input type="text"
                                                    name="groom_county" id="groom_county" class="form-control"></div>
                                            <div class="col-md-3"><label>Sub County</label><input type="text"
                                                    name="groom_sub_county" id="groom_sub_county" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>Parish</label><input type="text"
                                                    name="groom_parish" id="groom_parish" class="form-control"></div>
                                            <div class="col-md-3"><label>Village</label><input type="text"
                                                    name="groom_village" id="groom_village" class="form-control"></div>
                                            <div class="col-md-3"><label>Plot</label><input type="text" name="groom_plot"
                                                    id="groom_plot" class="form-control"></div>
                                        </div>

                                        <hr>

                                        <!-- ================= BRIDE ================= -->
                                        <h6 class="fw-bold text-danger">Bride Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-4"><label>Given Name</label><input type="text"
                                                    name="bride_given_name" id="bride_given_name" class="form-control">
                                            </div>
                                            <div class="col-md-4"><label>Surname</label><input type="text"
                                                    name="bride_surname" id="bride_surname" class="form-control"></div>
                                            <div class="col-md-4"><label>NIN</label><input type="text" name="brideNIN"
                                                    id="brideNIN" class="form-control"></div>

                                            <div class="col-md-2"><label>DOB Day</label><input type="number"
                                                    name="bride_day_date_of_birth" id="bride_day_date_of_birth"
                                                    class="form-control"></div>
                                            <div class="col-md-2"><label>DOB Month</label><input type="number"
                                                    name="bride_month_date_of_birth" id="bride_month_date_of_birth"
                                                    class="form-control"></div>
                                            <div class="col-md-2"><label>DOB Year</label><input type="number"
                                                    name="bride_year_date_of_birth" id="bride_year_date_of_birth"
                                                    class="form-control"></div>

                                            <div class="col-md-3"><label>Country</label><input type="text"
                                                    name="bride_country" id="bride_country" class="form-control"></div>
                                            <div class="col-md-3"><label>Telephone</label><input type="text"
                                                    name="bride_telephone" id="bride_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>Email</label><input type="email" name="bride_email"
                                                    id="bride_email" class="form-control"></div>

                                            <div class="col-md-3"><label>Tribe</label><input type="text" name="bride_tribe"
                                                    id="bride_tribe" class="form-control"></div>

                                            <div class="col-md-3"><label>District</label><input type="text"
                                                    name="bride_district" id="bride_district" class="form-control"></div>
                                            <div class="col-md-3"><label>County</label><input type="text"
                                                    name="bride_county" id="bride_county" class="form-control"></div>
                                            <div class="col-md-3"><label>Sub County</label><input type="text"
                                                    name="bride_sub_county" id="bride_sub_county" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>Parish</label><input type="text"
                                                    name="bride_parish" id="bride_parish" class="form-control"></div>
                                            <div class="col-md-3"><label>Village</label><input type="text"
                                                    name="bride_village" id="bride_village" class="form-control"></div>
                                            <div class="col-md-3"><label>Plot</label><input type="text" name="bride_plot"
                                                    id="bride_plot" class="form-control"></div>
                                        </div>

                                        <hr>

                                        <!-- ================= WITNESSES ================= -->
                                        <h6 class="fw-bold text-warning">Witnesses</h6>
                                        <div class="row g-3">
                                            <div class="col-md-3"><label>Witness 1 Given</label><input type="text"
                                                    name="witness1_given_name" id="witness1_given_name"
                                                    class="form-control"></div>
                                            <div class="col-md-3"><label>Witness 1 Surname</label><input type="text"
                                                    name="witness1_surname" id="witness1_surname" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>NIN</label><input type="text" name="witness1_nin"
                                                    id="witness1_nin" class="form-control"></div>
                                            <div class="col-md-3"><label>Telephone</label><input type="text"
                                                    name="witness1_telephone" id="witness1_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>Address</label><input type="text"
                                                    name="witness1_address" id="witness1_address" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>District</label><input type="text"
                                                    name="witness1District" id="witness1District" class="form-control">
                                            </div>

                                            <div class="col-md-3"><label>Witness 2 Given</label><input type="text"
                                                    name="witness2_given_name" id="witness2_given_name"
                                                    class="form-control"></div>
                                            <div class="col-md-3"><label>Witness 2 Surname</label><input type="text"
                                                    name="witness2_surname" id="witness2_surname" class="form-control">
                                            </div>
                                            <div class="col-md-3"><label>NIN</label><input type="text" name="witness2_nin"
                                                    id="witness2_nin" class="form-control"></div>
                                            <div class="col-md-3"><label>Telephone</label><input type="text"
                                                    name="witness2_telephone" id="witness2_telephone" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>Address</label><input type="text"
                                                    name="witness2_address" id="witness2_address" class="form-control">
                                            </div>
                                            <div class="col-md-6"><label>District</label><input type="text"
                                                    name="witness2District" id="witness2District" class="form-control">
                                            </div>
                                        </div>

                                        <hr>

                                        <!-- ================= IMAM ================= -->
                                        <h6 class="fw-bold text-primary">Imam</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label>Imam Name</label>
                                                <input type="text" name="imam_name" id="imam_name" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <!-- FOOTER -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle-fill me-2"></i> Close
                                        </button>

                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="bi bi-check-circle-fill me-2"></i> Update Application
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- View Application Modal -->
                    <div class="modal fade" id="viewApplicationModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <div>
                                        <h5 class="modal-title fw-bold text-white"><i
                                                class="fas fa-file-contract me-2"></i>Marriage
                                            Application Details</h5>
                                        <p class="small mb-0 opacity-75">Complete application information</p>
                                    </div>
                                    <button type="button" style="
                        background-color: #4e8d5e;
                        color: #ffffff;
                        border: none;
                        font-size: 1.7rem;
                        line-height: 1;
                        padding: 0.25rem 0.5rem;
                        border-radius: 0.25rem;
                        cursor: pointer;
                    " data-bs-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <!-- Application Info Card -->
                                    <div class="info-card">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="section-title mb-0">Application Information</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application ID</label>
                                                    <div class="value" id="view_application_id"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application Date</label>
                                                    <div class="value" id="view_date"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="info-item">
                                                    <label>Application Status</label>
                                                    <div class="value" id="view_status"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Couple Information -->
                                    <h6 class="section-title mt-4">Couple Information</h6>
                                    <div class="row">
                                        <!-- Groom Card -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="info-card person-card">
                                                <div class="d-flex align-items-start">
                                                    <div class="photo-container me-3">
                                                        <img id="view_groom_photo" src="" alt="Groom Photo"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2 text-primary">
                                                            <i class="fas fa-user-tie me-2"></i>Groom
                                                        </h6>
                                                        <h5 class="mb-3" id="view_groom"></h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <label>NIN</label>
                                                                <div class="value" id="view_groomNIN"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Date of Birth</label>
                                                                <div class="value" id="view_groom_dob"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Contact</label>
                                                                <div class="value" id="view_groom_contact"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Tribe & Country</label>
                                                                <div class="value" id="view_groom_tribe_country"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="text-muted small">Address</label>
                                                            <p class="mb-0" id="view_groom_address"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride Card -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="info-card person-card bride-card">
                                                <div class="d-flex align-items-start">
                                                    <div class="photo-container me-3">
                                                        <img id="view_bride_photo" src="" alt="Bride Photo"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="fw-bold mb-2 text-pink">
                                                            <i class="fas fa-user-dress me-2"></i>Bride
                                                        </h6>
                                                        <h5 class="mb-3" id="view_bride"></h5>
                                                        <div class="info-grid">
                                                            <div class="info-item">
                                                                <label>NIN</label>
                                                                <div class="value" id="view_brideNIN"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Date of Birth</label>
                                                                <div class="value" id="view_bride_dob"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Contact</label>
                                                                <div class="value" id="view_bride_contact"></div>
                                                            </div>
                                                            <div class="info-item">
                                                                <label>Tribe & Country</label>
                                                                <div class="value" id="view_bride_tribe_country"></div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">
                                                            <label class="text-muted small">Address</label>
                                                            <p class="mb-0" id="view_bride_address"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Parents Information -->
                                    <h6 class="section-title mt-4">Parents Information</h6>
                                    <div class="row">
                                        <!-- Groom's Parents -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="parent-card">
                                                <h6 class="fw-bold text-success mb-3">
                                                    <i class="fas fa-people-roof me-2"></i>Groom's Parents
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Father</label>
                                                            <p class="fw-bold mb-1" id="view_groom_father"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_groomFatherStatus"></span>
                                                                NIN: <span id="view_groom_father_nin"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_groomFatherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Tribe: <span id="view_groomFatherTribe"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Mother</label>
                                                            <p class="fw-bold mb-1" id="view_groom_mother"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_groomMotherStatus"></span>
                                                                NIN: <span id="view_groomMotherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_groomMotherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Maiden Name: <span id="view_groomMotherMaidenName"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bride's Parents -->
                                        <div class="col-lg-6 mb-4">
                                            <div class="parent-card">
                                                <h6 class="fw-bold text-success mb-3">
                                                    <i class="fas fa-people-roof me-2"></i>Bride's Parents
                                                </h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Father</label>
                                                            <p class="fw-bold mb-1" id="view_bride_father"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_brideFatherStatus"></span>
                                                                NIN: <span id="view_brideFatherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_brideFatherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Tribe: <span id="view_brideFatherTribe"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="text-muted small">Mother</label>
                                                            <p class="fw-bold mb-1" id="view_bride_mother"></p>
                                                            <p class="small mb-0">
                                                                <span class="badge bg-light text-dark me-2"
                                                                    id="view_brideMotherStatus"></span>
                                                                NIN: <span id="view_brideMotherNIN"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                District: <span id="view_brideMotherDistrict"></span>
                                                            </p>
                                                            <p class="small mb-0">
                                                                Maiden Name: <span id="view_brideMotherMaidenName"></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Witnesses -->
                                    <h6 class="section-title mt-4">Witnesses</h6>
                                    <div class="row">
                                        <div class="col-lg-6 mb-4">
                                            <div class="witness-card">
                                                <h6 class="fw-bold text-warning mb-3">
                                                    <i class="fas fa-user-check me-2"></i>Witness 1
                                                </h6>
                                                <p class="fw-bold mb-2" id="view_witness1_name"></p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-id-card me-2"></i>
                                                            NIN: <span id="view_witness1_nin"></span>
                                                        </p>
                                                        <p class="small mb-1">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Phone: <span id="view_witness1_phone"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-map-marker-alt me-2"></i>
                                                            District: <span id="view_witness1_district"></span>
                                                        </p>
                                                        <p class="small mb-0">
                                                            <i class="fas fa-home me-2"></i>
                                                            Address: <span id="view_witness1_address"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 mb-4">
                                            <div class="witness-card">
                                                <h6 class="fw-bold text-warning mb-3">
                                                    <i class="fas fa-user-check me-2"></i>Witness 2
                                                </h6>
                                                <p class="fw-bold mb-2" id="view_witness2_name"></p>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-id-card me-2"></i>
                                                            NIN: <span id="view_witness2_nin"></span>
                                                        </p>
                                                        <p class="small mb-1">
                                                            <i class="fas fa-phone me-2"></i>
                                                            Phone: <span id="view_witness2_phone"></span>
                                                        </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="small mb-1">
                                                            <i class="fas fa-map-marker-alt me-2"></i>
                                                            District: <span id="view_witness2_district"></span>
                                                        </p>
                                                        <p class="small mb-0">
                                                            <i class="fas fa-home me-2"></i>
                                                            Address: <span id="view_witness2_address"></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Imam Assignment -->
                                    <div class="info-card mt-4">
                                        <h6 class="section-title mb-0">Wedding Imam</h6>
                                        <div class="d-flex align-items-center mt-3">
                                            <div class="flex-grow-1">
                                                <h5 class="mb-1" id="view_imam_name"></h5>
                                                <p class="small text-muted mb-0">Imam assigned to conduct the marriage
                                                    ceremony</p>
                                            </div>
                                            <div>
                                                <i class="fas fa-user-circle fa-3x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-2"></i>Close
                                    </button>
                                    {{-- <button type="button" class="btn btn-primary px-4">
                                        <i class="fas fa-print me-2"></i>Print
                                    </button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dateElement = document.getElementById('currentDateFull');
        const now = new Date();

        const formattedDate = now.toLocaleDateString('en-US', {
            weekday: 'long',
            month: 'short',
            day: 'numeric',
            year: 'numeric'
        });

        dateElement.textContent = formattedDate;
        document.getElementById('smartSearch').addEventListener('focus', function () {
            var suggestions = document.getElementById('searchSuggestions');
            suggestions.classList.add('show');
        });

        document.getElementById('smartSearch').addEventListener('blur', function () {
            setTimeout(function () {
                var suggestions = document.getElementById('searchSuggestions');
                suggestions.classList.remove('show');
            }, 200);
        });
    </script>

    <script>
        document.getElementById('clearSearch').addEventListener('click', function () {
            const input = document.getElementById('searchInput');
            input.value = '';
            input.dispatchEvent(new Event('keyup'));
        });
    </script>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            const query = this.value.toLowerCase();
            const rows = document.querySelectorAll('.application-row');

            rows.forEach(row => {
                const searchableText = row.getAttribute('data-search');
                if (searchableText.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('viewApplicationModal'));

            document.querySelectorAll('.view-application').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.dataset.id;

                    fetch(`/nikah/applications/${id}`)
                        .then(res => res.json())
                        .then(data => {
                            // Clear previous data
                            clearModalData();

                            // Application Info Card
                            document.getElementById('view_application_id').textContent = data
                                .application_id;
                            document.getElementById('view_status').innerHTML =
                                `<span class="status-badge status-${data.status}">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</span>`;
                            document.getElementById('view_date').textContent = new Date(data
                                .created_at).toLocaleDateString('en-US', {
                                    weekday: 'long',
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                            // Groom & Bride Cards
                            populatePersonCard('groom', data, true);
                            populatePersonCard('bride', data, false);

                            // Parents Information
                            populateParentCard('groom', data, true);
                            populateParentCard('bride', data, false);

                            // Witnesses
                            populateWitnessCard('witness1', data);
                            populateWitnessCard('witness2', data);

                            // Imam
                            document.getElementById('view_imam_name').textContent = data
                                .imam_name || 'Not Assigned Yet';
                            document.getElementById('view_imam_name').className = data
                                .imam_name ? 'imam-assigned' : 'imam-not-assigned';

                            modal.show();
                        })
                        .catch(() => {
                            showError('Failed to load application details.');
                        });
                });
            });

            function clearModalData() {
                // Clear all image sources to prevent showing old images
                document.getElementById('view_groom_photo').src = '';
                document.getElementById('view_bride_photo').src = '';
            }

            function populatePersonCard(type, data, isGroom) {
                const prefix = isGroom ? 'groom' : 'bride';
                const title = isGroom ? 'Groom' : 'Bride';

                // Update photo
                const photoElement = document.getElementById(`view_${prefix}_photo`);
                if (data[`${prefix}_photo_path`]) {
                    photoElement.src = `/storage/${data[`${prefix}_photo_path`]}`;
                    photoElement.style.display = 'block';
                } else {
                    photoElement.style.display = 'none';
                }

                // Update details
                document.getElementById(`view_${prefix}`).textContent =
                    `${data[`${prefix}_given_name`]} ${data[`${prefix}_surname`]}`;
                document.getElementById(`view_${prefix}NIN`).textContent = data[`${prefix}NIN`] || 'Not provided';
                document.getElementById(`view_${prefix}_dob`).textContent = formatDOB(data, prefix);
                document.getElementById(`view_${prefix}_contact`).innerHTML = formatContact(data[
                    `${prefix}_telephone`], data[`${prefix}_email`]);
                document.getElementById(`view_${prefix}_address`).textContent = formatAddress(data, prefix);
                document.getElementById(`view_${prefix}_tribe_country`).textContent =
                    `${data[`${prefix}_tribe`] || 'Not specified'}, ${data[`${prefix}_country`] || 'Not specified'}`;
            }

            function populateParentCard(type, data, isGroom) {
                const prefix = isGroom ? 'groom' : 'bride';

                // Father
                document.getElementById(`view_${prefix}_father`).textContent = data[
                    `${prefix}_father_given_name`] && data[`${prefix}_father_surname`] ?
                    `${data[`${prefix}_father_given_name`]} ${data[`${prefix}_father_surname`]}` :
                    'Not provided';
                document.getElementById(`view_${prefix}FatherStatus`).textContent = data[`${prefix}FatherStatus`] ||
                    'Not specified';
                document.getElementById(`view_${prefix}FatherDistrict`).textContent = data[
                    `${prefix}FatherDistrict`] || 'Not specified';
                document.getElementById(`view_${prefix}FatherTribe`).textContent = data[`${prefix}FatherTribe`] ||
                    'Not specified';

                // Mother
                document.getElementById(`view_${prefix}_mother`).textContent = data[
                    `${prefix}_mother_given_name`] && data[`${prefix}_mother_surname`] ?
                    `${data[`${prefix}_mother_given_name`]} ${data[`${prefix}_mother_surname`]}` :
                    'Not provided';
                document.getElementById(`view_${prefix}MotherStatus`).textContent = data[`${prefix}MotherStatus`] ||
                    'Not specified';
                document.getElementById(`view_${prefix}MotherDistrict`).textContent = data[
                    `${prefix}MotherDistrict`] || 'Not specified';
                document.getElementById(`view_${prefix}MotherMaidenName`).textContent = data[
                    `${prefix}MotherMaidenName`] || 'Not specified';
            }

            function populateWitnessCard(witnessNum, data) {
                const name = `${data[`${witnessNum}_given_name`] || ''} ${data[`${witnessNum}_surname`] || ''}`
                    .trim();
                document.getElementById(`view_${witnessNum}_name`).textContent = name || 'Not provided';
                document.getElementById(`view_${witnessNum}_nin`).textContent = data[`${witnessNum}_nin`] ||
                    'Not provided';
                document.getElementById(`view_${witnessNum}_phone`).textContent = data[`${witnessNum}_telephone`] ||
                    'Not provided';
                document.getElementById(`view_${witnessNum}_address`).textContent = data[`${witnessNum}_address`] ||
                    'Not provided';
                document.getElementById(`view_${witnessNum}_district`).textContent = data[
                    `${witnessNum}District`] || 'Not specified';
            }

            function formatDOB(data, prefix) {
                const day = data[`${prefix}_day_date_of_birth`];
                const month = data[`${prefix}_month_date_of_birth`];
                const year = data[`${prefix}_year_date_of_birth`];

                if (day && month && year) {
                    const date = new Date(year, month - 1, day);
                    return date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                }
                return 'Not specified';
            }

            function formatContact(phone, email) {
                let html = '';
                if (phone) {
                    html += `<span class="contact-item"><i class="fas fa-phone me-2"></i>${phone}</span>`;
                }
                if (email) {
                    if (phone) html += '<br>';
                    html += `<span class="contact-item"><i class="fas fa-envelope me-2"></i>${email}</span>`;
                }
                return html || 'Not provided';
            }

            function formatAddress(data, prefix) {
                const parts = [
                    data[`${prefix}_village`],
                    data[`${prefix}_parish`],
                    data[`${prefix}_sub_county`],
                    data[`${prefix}_county`],
                    data[`${prefix}_district`]
                ].filter(part => part && part.trim() !== '');

                return parts.length > 0 ? parts.join(', ') : 'Not provided';
            }

            function showError(message) {
                // You can replace this with a toast notification
                alert(message);
            }
        });
    </script>

    <script>
        $(document).on('click', '.edit-application', function () {
            let id = $(this).data('id');


            $.ajax({
                url: `/nikah/${id}/edit`,
                type: 'GET',
                dataType: 'json',
                success: function (res) {

                    if (!res.success) {
                        Swal.fire('Error', 'Failed to load application', 'error');
                        return;
                    }

                    let data = res.data;

                    // Store ID
                    $('#edit_id').val(data.id);

                    /**
                     * 🔁 AUTO-FILL ALL INPUTS
                     * Field ID MUST match column name
                     */
                    Object.keys(data).forEach(function (key) {
                        let field = $('#' + key);

                        if (field.length) {
                            field.val(data[key] ?? '');
                        }
                    });

                    /**
                     * Open modal AFTER data is bound
                     */
                    $('#editApplicationModal').modal('show');
                },
                error: function (data) {
                    $('body').html(data.responseText);
                }
            });
        });
    </script>


    <script>
        $('#editApplicationForm').submit(function (e) {
            e.preventDefault();

            let id = $('#edit_id').val();
            let formData = new FormData(this);

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you want to update this application?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, update it',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/nikah/${id}/update`,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Swal.fire({
                                title: 'Updated!',
                                text: res.message,
                                icon: 'success',
                                timer: 3000,
                                timerProgressBar: true,
                                showConfirmButton: false
                            });

                            setTimeout(() => {
                                $('#editApplicationModal').modal('hide');
                                location.reload();
                            }, 3000);
                        },
                        error: function (data) {
                            $('body').html(data.responseText);
                        }
                    });
                }
            });
        });
    </script>


    <script>
        // Add this to your JS file or script tag
        document.addEventListener('DOMContentLoaded', function () {
            const editModal = document.getElementById('editApplicationModal');

            if (editModal) {
                editModal.addEventListener('show.bs.modal', function () {
                    // Ensure modal body is scrollable
                    const modalBody = this.querySelector('.modal-body');
                    if (modalBody) {
                        modalBody.style.maxHeight = '60vh';
                        modalBody.style.overflowY = 'auto';
                    }
                });
            }
        });
    </script>


    <script>
        $(document).on('click', '.delete-application', function () {
            let id = $(this).data('id');
            let row = $(this).closest('tr');

            Swal.fire({
                title: 'Delete Application?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: `/nikah/${id}`,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (res) {

                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Application deleted successfully.',
                                icon: 'success',
                                confirmButtonColor: '#16a34a'
                            }).then(() => {
                                row.fadeOut(300, function () {
                                    $(this).remove();
                                });
                            });

                        },
                        // error: function() {
                        //     Swal.fire(
                        //         'Error!',
                        //         'Something went wrong. Try again.',
                        //         'error'
                        //     );
                        // }
                        error: function (data) {
                            $('body').html(data.responseText);
                        }
                    });

                }
            });
        });
    </script>


    <script>
        $(document).ready(function () {
            let selectedApplicationId;

            // Open modal on "Update Status" click
            $('.update-status').on('click', function () {
                selectedApplicationId = $(this).data('id'); // store application id
                let currentStatus = $(this).closest('tr').find('span.badge').text().trim();
                $('#currentStatusText').text(currentStatus);
                $('#updateStatusModal').modal('show');
            });

            // Click on a status option
            $('.status-option').on('click', function () {
                let newStatus = $(this).data('status');
                let statusLabel = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);

                // SweetAlert confirmation
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Change status to "${statusLabel}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Make AJAX call to update status
                        $.ajax({
                            url: '/applications/' + selectedApplicationId +
                                '/update-status', // create route in web.php
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: newStatus
                            },
                            success: function (response) {
                                // Close modal
                                $('#updateStatusModal').modal('hide');

                                // Update badge in table
                                let badge = $('tr').find(
                                    `[data-id='${selectedApplicationId}']`).closest(
                                        'tr').find('span.badge');
                                let colors = {
                                    'approved': ['#05956815', '#059568'],
                                    'pending': ['#FFF7E6', '#FF9F43'],
                                    'rejected': ['#FFE5E5', '#EA5455']
                                };
                                let bg = colors[newStatus][0] ?? '#E7F3FF';
                                let color = colors[newStatus][1] ?? '#0D6EFD';
                                badge.text(statusLabel);
                                badge.css({
                                    'background': bg,
                                    'color': color,
                                    'border': `1px solid ${color}30`
                                });

                                // Show success alert and reload after user clicks OK
                                Swal.fire(
                                    'Updated!',
                                    'Application status has been updated.',
                                    'success'
                                ).then(() => {
                                    // Reload the page
                                    location.reload();
                                });
                            },

                            error: function (err) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to update status.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection