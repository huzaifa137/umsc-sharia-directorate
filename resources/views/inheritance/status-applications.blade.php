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

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-end mb-4 pb-3 border-bottom">
            <div>
                @if ($statusId == 0)
                    <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;color:#059580;">PENDING Inheritance
                        APPLICATIONS
                    </h2>
                @elseif($statusId == 100)
                    <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;color:#059580;">All Inheritance
                        APPLICATIONS
                    </h2>
                @elseif($statusId == -10)
                    <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;color:#059580;">TERMINATED Inheritance
                        APPLICATIONS
                    </h2>
                @elseif($statusId == 10)
                    <h2 class="mb-0 fw-bold" style="font-family: 'Algerian', sans-serif;color:#059580;">Completed Inheritance
                        APPLICATIONS
                    </h2>
                @endif
            </div>
            <div class="avatar-group">
                <div class="bg-light p-2 rounded-3">
                    <i class="bx bx-calendar text-success me-2"></i>
                    <span id="currentDateFull" class="small fw-medium"></span>
                </div>
            </div>
        </div>

                @if ($statusId == 100)
           @include('layouts.search-feature')
        @endif

        <div class="card border-0 shadow-sm" style="border-radius: 16px;">
            <div class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                <!-- Search Bar -->
                <div class="w-100 me-4">
                    <div class="position-relative" style="max-width: 500px;">
                        <div class="input-group"
                            style="
                    background: white;
                    border-radius: 12px;
                    border: 1px solid #e2e8f0;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
                    padding: 8px;
                    transition: all 0.3s ease;
                "
                            onmouseover="this.style.boxShadow='0 6px 25px rgba(0, 0, 0, 0.08)'">
                            <!-- Search Icon -->
                            <span class="input-group-text border-0 bg-transparent" style="padding-left: 15px;">
                                <i class="bx bx-search-alt-2" style="color:#059568; font-size: 1.2rem;"></i>
                            </span>

                            <!-- Search Input -->
                            <input type="text" id="searchInput" class="form-control border-0 px-0"
                                placeholder="Search by ID, names, status…"
                                style="
        background: transparent;
        color: #1a202c;
        font-weight: 600;
        padding: 8px 0;
        height: auto;
    ">


                            <!-- Search Label -->
                            <label class="position-absolute"
                                style="
                        top: -10px;
                        left: 50px;
                        background: white;
                        padding: 0 10px;
                        font-size: 0.8rem;
                        color: #059568;
                        font-weight: 600;
                        letter-spacing: 0.5px;
                    ">
                                Search Records
                            </label>

                            <!-- Search Actions -->
                            <div class="d-flex align-items-center gap-2" style="padding-right: 15px;">
                                <!-- Clear Button -->
                                <button class="btn btn-sm p-1" id="clearSearch"
                                    style="
                                            background: #059568;
                                            color: #FFF;
                                            border-radius: 8px;
                                            width: 32px;
                                            height: 32px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        "
                                    onmouseover="this.style.background='#059568'"
                                    onmouseout="this.style.background='#059568'">
                                    <i class="bx bx-x" style="font-size: 1.1rem;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Link - FIXED -->
                <a href="{{ url('inheritance-dashboard') }}"
                    class="text-decoration-none d-flex align-items-center text-primary fw-bold text-nowrap"
                    style="
            background: #f0fdf4;
            padding: 10px 20px;
            border-radius: 10px;
            border: 1px solid rgba(5, 149, 104, 0.2);
            transition: all 0.3s ease;
            white-space: nowrap;
            flex-shrink: 0;
            margin-left: 16px;
        "
                    onmouseover="this.style.background='#dcfce7'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(5, 149, 104, 0.1)'"
                    onmouseout="this.style.background='#f0fdf4'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <i class="bx bx-home fs-4 me-2" style="color:#059568;"></i>
                    <span style="color:#065f46;">Inheritance Dashboard</span>
                </a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-muted small fw-bold text-center">
                                    ACTIVITY & ID
                                </th>
                                <th class="border-0 text-muted small fw-bold text-center">
                                    DECEASED NAME
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
                                <tr class="border-bottom border-light application-row"
                                    data-search="
                                        {{ strtolower($application->application_id) }}
                                        {{ strtolower($application->deceased_name) }}
                                        {{ strtolower($application->created_at) }}
                                        {{ strtolower($application->status) }}
                                    ">

                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3 bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center"
                                                style="background: #05956820; width: 40px; height: 40px;">
                                                <i class="bx bx-heart fs-4" style="color: #059568;"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">Inheritance</h6>
                                                <small class="text-muted text-uppercase"
                                                    style="font-size: 10px; letter-spacing: 0.5px;">
                                                    #{{ $application->application_id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="mb-0 text-dark fw-bold" style="font-size: 0.9rem;">
                                            {{ trim($application->deceased_name) }}
                                        </p>
                                        <small class="text-muted">Both Names of Deceased</small>
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

                                        @include('layouts.views.inheritance-actions')
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

@include('layouts.views.inheritance-actions-modals')
@include('layouts.views.shared-status-modal')
@include('layouts.views.case-modal-styles')


                    <div class="mt-4 me-4">
                        {{ $applications->links('pagination::bootstrap-5') }}
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
        document.getElementById('smartSearch').addEventListener('focus', function() {
            var suggestions = document.getElementById('searchSuggestions');
            suggestions.classList.add('show');
        });

        document.getElementById('smartSearch').addEventListener('blur', function() {
            setTimeout(function() {
                var suggestions = document.getElementById('searchSuggestions');
                suggestions.classList.remove('show');
            }, 200);
        });
    </script>

    <script>
        document.getElementById('clearSearch').addEventListener('click', function() {
            const input = document.getElementById('searchInput');
            input.value = '';
            input.dispatchEvent(new Event('keyup'));
        });
    </script>

    <script>
        document.getElementById('searchInput').addEventListener('keyup', function() {
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
@endsection
