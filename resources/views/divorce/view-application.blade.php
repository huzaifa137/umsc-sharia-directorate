@extends('layouts.app')

@section('content')
    <style>
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

        .contact-item {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0;
        }

        .parent-card {
            border-left: 3px solid #48bb78;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f0fff4;
        }

        .witness-card {
            border-left: 3px solid #ed8936;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fffaf0;
        }

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
        <!-- Dashboard Header -->


        <!-- Main Action Cards -->
        <div class="row">

            <div class="modal-body">
                
                <div class="info-card mt-4">
                    <h6 class="section-title mb-0">Couple Application Information : <span class="small text-primary mb-0 "
                            style="font-size: 18px;">{{ trim($application->groom_given_name . ' ' . $application->groom_surname) }}
                            <span
                                class="fw-bold text-muted">&</span>{{ trim($application->bride_given_name . ' ' . $application->bride_surname) }}</span>
                    </h6>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>Groom Sirname</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->groom_surname }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>Groom Givenname</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->groom_given_name }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>Bride Sirname</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->bride_surname }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-item">
                                <label>Bride Givenname</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->bride_given_name }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Application Info Card -->
                <div class="info-card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="section-title mb-0">Application Information</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application ID</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->application_id }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application Date</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->created_at }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-item">
                                <label>Application Status</label>
                                <input type="text" disabled class="form-control" name="" id=""
                                    value="{{ $application->status }}">
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
                                    <img id="view_groom_photo" src="" alt="Groom Photo" class="img-fluid rounded">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-2 text-primary">
                                        <i class="fas fa-user-tie me-2"></i>Groom
                                    </h6>
                                    <h5 class="mb-3" id="view_groom"></h5>
                                    <div class="info-grid">

                                        <div class="info-item">
                                            <label>Email</label>
                                            <input type="text" disabled class="form-control" name="" id=""
                                                value="{{ $application->groom_email }}">
                                        </div>
                                        <div class="info-item">
                                            <label>Contact</label>
                                            <input type="text" disabled class="form-control" name="" id=""
                                                value="{{ $application->groom_phone }}">
                                        </div>
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
                                    <img id="view_bride_photo" src="" alt="Bride Photo" class="img-fluid rounded">
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-2 text-pink">
                                        <i class="fas fa-user-dress me-2"></i>Bride
                                    </h6>
                                    <h5 class="mb-3" id="view_bride"></h5>
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <label>Email</label>
                                            <input type="text" disabled class="form-control" name="" id=""
                                                value="{{ $application->bride_email }}">
                                        </div>

                                        <div class="info-item">
                                            <label>Contact</label>
                                            <input type="text" disabled class="form-control" name="" id=""
                                                value="{{ $application->bride_phone }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parents Information -->
                <h6 class="section-title mt-4">Divorce & Imam Information</h6>
                <div class="row">
                    <!-- Groom's Parents -->
                    <div class="col-lg-6 mb-4">
                        <div class="parent-card">
                            <h6 class="fw-bold text-success mb-3">
                                <i class="fas fa-people-roof me-2"></i>Divorce Information
                            </h6>
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <p class="fw-bold mb-1" id="view_groom_father"></p>
                                        <p class="small mb-2">
                                            <span class="fw-bold">Divorce Type
                                                <input type="text" disabled class="form-control"
                                                    value="{{ $application->divorce_type }}">
                                        </p>
                                        <p class="small mb-2">
                                            <span class="fw-bold">Talaq Count :

                                                <input type="text" disabled class="form-control"
                                                    value="{{ $application->talaq_count }}">
                                        </p>
                                        <p class="small mb-2">
                                            <span class="fw-bold">Divorce Initiated By: </span>

                                            <input type="text" disabled class="form-control"
                                                value="{{ $application->divorce_initiated_by }}">
                                        </p>

                                        <p class="small mb-0">
                                            <span class="fw-bold">Divorce Place: </span>
                                            <input type="text" disabled class="form-control"
                                                value="{{ $application->divorce_place }}">
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
                                <i class="fas fa-people-roof me-2"></i> Imam Information
                            </h6>
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <p class="fw-bold mb-1" id="view_groom_father"></p>
                                        <p class="small mb-2">
                                            <span class="fw-bold">Imaam Name
                                                <input type="text" disabled class="form-control"
                                                    value="{{ $application->imam_name }}">
                                        </p>
                                        <p class="small mb-2">
                                            <span class="fw-bold">Imaam Reg :

                                                <input type="text" disabled class="form-control"
                                                    value="{{ $application->imam_reg }}">
                                        </p>
                                        <p class="small mb-2">
                                            <span class="fw-bold">Mosque Name: </span>

                                            <input type="text" disabled class="form-control"
                                                value="{{ $application->mosque_name }}">
                                        </p>

                                        <p class="small mb-0">
                                            <span class="fw-bold">Custody Arrangement: </span>
                                            <input type="text" disabled class="form-control"
                                                value="{{ $application->custody_arrangement }}">
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
                                    <p>Given Name
                                        <input type="text" disabled class="form-control"
                                            value=" {{ $application->w1_given_name }}">
                                    </p>
                                    <p>surname
                                        <input type="text" disabled class="form-control"
                                            value=" {{ $application->w1_surname }}">
                                    </p>

                                </div>
                                <div class="col-md-6">
                                    <p>NIN
                                        <input type="text" disabled class="form-control" value=" {{ $application->w1_nin }}">
                                    </p>

                                    <p>Phone
                                        <input type="text" disabled class="form-control"
                                            value=" {{ $application->w1_phone }}">
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
                                    <p>Given Name
                                        <input type="text" disabled class="form-control"
                                            value=" {{ $application->w2_given_name }}">
                                    </p>
                                    <p>surname
                                        <input type="text" disabled class="form-control"
                                            value=" {{ $application->w2_surname }}">
                                    </p>

                                </div>
                                <div class="col-md-6">
                                    <p>NIN
                                        <input type="text" disabled class="form-control" value=" {{ $application->w2_nin }}">
                                    </p>

                                    <p>Phone
                                        <input type="text" disabled class="form-control"
                                            value=" {{ $application->w2_phone }}">
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .bg-gradient-danger {
            background: #dc2626;
        }

        .border-start {
            border-left-width: 4px !important;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-light-danger {
            background-color: rgba(220, 38, 38, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(245, 158, 11, 0.1);
        }

        .bg-light-success {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bg-light-info {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .bg-light-secondary {
            background-color: rgba(107, 114, 128, 0.1);
        }

        .bg-light-purple {
            background-color: rgba(111, 66, 193, 0.1);
        }

        .bg-label-danger {
            background-color: rgba(220, 38, 38, 0.1);
            color: #dc3545;
        }

        .bg-label-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
        }

        .bg-label-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #10b981;
        }

        .bg-label-info {
            background-color: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .bg-label-primary {
            background-color: rgba(37, 99, 235, 0.1);
            color: #2563eb;
        }

        .bg-label-purple {
            background-color: rgba(111, 66, 193, 0.1);
            color: #6f42c1;
        }

        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-outline-purple {
            color: #6f42c1;
            border-color: #6f42c1;
        }

        .btn-outline-purple:hover {
            background-color: #6f42c1;
            border-color: #6f42c1;
            color: white;
        }

        /* Custom table styles */
        .table-hover tbody tr:hover {
            background-color: rgba(220, 38, 38, 0.05);
        }

        /* Badge styles */
        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }
    </style>
@endsection
