@extends('layouts.app')

@section('content')
<style>
    .card-gold { border-top: 4px solid #b8860b !important; }
    .bg-label-gold { background-color: #fdf5e6 !important; color: #b8860b !important; }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="https://ui-avatars.com/api/?name=Admin+Registry&background=b8860b&color=fff" class="rounded-circle mb-3" width="80">
                    <h5 class="fw-bold mb-0">Senior Registrar</h5>
                    <small class="text-muted">Authentication Office</small>
                    <hr>
                    <div class="text-start">
                        <p class="small text-uppercase text-muted fw-bold mb-2">My Desk</p>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="small"><i class="bx bx-edit-alt me-2"></i> Pending Signatures</span>
                            <span class="badge bg-danger">04</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small"><i class="bx bx-envelope me-2"></i> New Applications</span>
                            <span class="badge bg-primary">12</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold small mb-3">SHARIA REFERENCE</h6>
                    <div class="bg-light p-3 rounded mb-2">
                        <p class="small mb-0 italic">"For men is a share of what the parents and close relatives leave..." (4:7)</p>
                    </div>
                    <a href="#" class="small text-primary text-decoration-none">Read Full Faraid Manual →</a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card border-0 shadow-sm card-gold mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold mb-0">Estate Distribution Overview</h5>
                        <button class="btn btn-sm btn-white border">Filter Calendar</button>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <h2 class="fw-bold mb-0">42</h2>
                                <small class="text-muted">Total Estates Managed</small>
                                <div class="progress mt-2" style="height: 4px;"><div class="progress-bar bg-warning" style="width: 70%"></div></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 border rounded">
                                <h2 class="fw-bold mb-0">15</h2>
                                <small class="text-muted">Certificates Ready for Issue</small>
                                <div class="progress mt-2" style="height: 4px;"><div class="progress-bar bg-success" style="width: 40%"></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="bg-label-gold p-3 border-bottom">
                    <h6 class="mb-0 fw-bold"><i class="bx bx-list-ul me-2"></i>Recent Official Decrees</h6>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Registry No.</th>
                                <th>Name of Deceased</th>
                                <th>Inheritance Type</th>
                                <th>Date Filed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1; $i<=6; $i++)
                            <tr>
                                <td><span class="badge bg-label-secondary">#REF-883{{$i}}</span></td>
                                <td class="fw-bold">Hassan Ali Ibrahim</td>
                                <td><small class="fw-semibold">Testamentary (Wasiyyah)</small></td>
                                <td><small class="text-muted">Jan 0{{$i}}, 2026</small></td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection