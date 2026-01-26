@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
            <div>
                <h4 class="fw-bold mb-1"><i class="bx bx-buildings me-2 text-primary"></i>Inheritance & Properties Dashboard
                </h4>
                <p class="text-muted small mb-0">Managing Sharia-compliant asset distribution and legal heirship.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row mb-4">
                    @php
                        $stats = [
                            [
                                'label' => 'Total Applications',
                                'value' => $all ?? 0,
                                'statusId' => 100,
                                'bg_color' => '#eff6ff',
                                'hover_bg' => '#dbeafe',
                                'text_color' => '#1d4ed8',
                                'icon_color' => '#1d4ed8',
                                'icon_bg' => 'rgba(29, 78, 216, 0.25)',
                                'icon' => 'bx bx-buildings',
                                'sub' => 'All Applications',
                            ],
                            [
                                'label' => 'Approved Applications',
                                'value' => $Finalised ?? 0,
                                'statusId' => 10,
                                'bg_color' => '#f0fdf4',
                                'hover_bg' => '#dcfce7',
                                'text_color' => '#065f46',
                                'icon_color' => '#059568',
                                'icon_bg' => 'rgba(5, 149, 104, 0.25)',
                                'icon' => 'bx bx-money',
                                'sub' => 'All Approved Applications',
                            ],
                            [
                                'label' => 'Pending Applications',
                                'value' => $pending ?? 0,
                                'statusId' => 0,
                                'bg_color' => '#fef9e7',
                                'hover_bg' => '#fef3c7',
                                'text_color' => '#92400e',
                                'icon_color' => '#d97706',
                                'icon_bg' => 'rgba(217, 119, 6, 0.25)',
                                'icon' => 'bx bx-time-five',
                                'sub' => 'All Pending Applications',
                            ],
                            [
                                'label' => 'Cancelled Applications',
                                'value' => $Rejected ?? 0,
                                'statusId' => -10,
                                'bg_color' => '#fef2f2',
                                'hover_bg' => '#fee2e2',
                                'text_color' => '#991b1b',
                                'icon_color' => '#ef4444',
                                'icon_bg' => 'rgba(239, 68, 68, 0.25)',
                                'icon' => 'bx bx-credit-card',
                                'sub' => 'All Cancelled Applications',
                            ],
                        ];
                    @endphp

                    @foreach ($stats as $stat)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('inheritance.status.applications', ['statusId' => $stat['statusId']]) }}"
                                class="text-decoration-none">

                                <div class="card h-100 border-0 shadow-sm"
                                    style="border-radius:20px; background:{{ $stat['bg_color'] }}; transition: all 0.3s ease;"
                                    onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 20px rgba(0, 0, 0, 0.1)'; this.style.background='{{ $stat['hover_bg'] }}'"
                                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)'; this.style.background='{{ $stat['bg_color'] }}'">

                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-uppercase fw-bold"
                                                style="font-size:0.65rem; color:{{ $stat['text_color'] }};">
                                                {{ $stat['label'] }}
                                            </span>

                                            <div class="icon-box"
                                                style="background:{{ $stat['icon_bg'] }}; border-radius: 10px; padding: 8px;">
                                                <i class="{{ $stat['icon'] }}" style="color:{{ $stat['icon_color'] }};"></i>
                                            </div>
                                        </div>

                                        <h2 class="fw-bold" style="color:{{ $stat['text_color'] }};">
                                            {{ $stat['value'] }}
                                        </h2>

                                        <small class="text-muted" style="color:{{ $stat['icon_color'] }};">
                                            {{ $stat['sub'] }}
                                        </small>
                                    </div>
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
                    style="background: linear-gradient(90deg, #ffffff 0%, #f8fafc 100%); border-bottom: 1px solid #e2e8f0;">
                    <div>
                        <h5 class="mb-0 fw-bold" style="color: #1e293b;">Recent Inheritance Applications</h5>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-light-primary text-primary fw-medium" style="font-size: 0.7rem;">
                                <i class="bx bx-layer me-1"></i> Heirship Administration
                            </span>
                            <span class="badge bg-light-success text-success fw-medium" style="font-size: 0.7rem;">
                                <i class="bx bx-time me-1"></i> Application Monitoring
                            </span>
                        </div>
                    </div>

                    <div class="w-100" style="max-width: 480px;">
                        <div class="position-relative">
                            <i class="bx bx-search position-absolute"
                                style="left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.1rem; z-index: 10;"></i>
                            <input type="text" id="inheritanceSearch" class="form-control form-control-sm ps-5"
                                placeholder="Search by File ID, Deceased Name, Estate Value, Status..."
                                style="
                       border-radius: 8px;
                       border: 1px solid #d1d5db;
                       background: #ffffff;
                       padding: 10px 16px 10px 40px;
                       font-size: 0.9rem;
                       transition: all 0.3s ease;
                   "
                                onfocus="this.style.borderColor='#059568'; this.style.boxShadow='0 0 0 3px rgba(5, 149, 104, 0.1)'; this.style.background='#ffffff'"
                                onblur="this.style.borderColor='#d1d5db'; this.style.boxShadow='none'; this.style.background='#ffffff'">
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>File ID</th>
                                <th>Deceased Detail</th>
                                <th>Est. Value</th>
                                <th>Status</th>
                                <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $application)
                                <tr>
                                    {{-- File ID --}}
                                    <td>
                                        <span class="fw-bold text-primary">
                                            #{{ $application->application_id }}
                                        </span>
                                    </td>

                                    {{-- Deceased Details --}}
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">
                                                Late {{ $application->deceased_name }}
                                            </span>
                                            <span class="text-muted" style="font-size: 0.75rem;">
                                                Died:
                                                {{ \Carbon\Carbon::parse($application->date_of_death)->format('d M Y') }}
                                            </span>
                                        </div>
                                    </td>

                                    {{-- Estate Value --}}
                                    <td>
                                        <span class="fw-semibold">
                                            UGX {{ number_format($application->total_estate_value) }}
                                        </span>
                                    </td>

                                    {{-- Status --}}
                                    <td>
                                        @php
                                            $badge = match ($application->status) {
                                                'submitted' => 'bg-label-warning',
                                                'rejected' => 'bg-label-danger',
                                                'accomplished' => 'bg-label-success',
                                                default => 'bg-label-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $badge }}">
                                            {{ ucfirst($application->status) }}
                                        </span>
                                    </td>

                                    @include('layouts.views.inheritance-actions')
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No inheritance applications found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4 me-4">
                        {{ $applications->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>

    <style>
        /* Professional Modern Accents */
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            cursor: pointer;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .bg-label-primary {
            background: #eef2ff !important;
            color: #4f46e5 !important;
        }

        .bg-label-success {
            background: #ecfdf5 !important;
            color: #10b981 !important;
        }

        .bg-label-warning {
            background: #fffbeb !important;
            color: #f59e0b !important;
        }

        .bg-label-info {
            background: #f0f9ff !important;
            color: #0ea5e9 !important;
        }

        .bg-label-danger {
            background: #fef2f2 !important;
            color: #ef4444 !important;
        }

        .btn-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .btn-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }

        .text-primary {
            color: #4f46e5 !important;
        }

        .card {
            border-radius: 12px;
        }

        .table thead th {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 700;
        }

        .btn-white {
            background: #fff;
            color: #334155;
            border: 1px solid #e2e8f0;
        }
    </style>

    <script>
        document.getElementById('inheritanceSearch').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('table tbody tr');

            rows.forEach(row => {
                if (row.querySelector('td[colspan]')) {
                    return;
                }

                const rowText = row.innerText.toLowerCase();

                if (rowText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endsection
