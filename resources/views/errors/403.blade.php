@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex align-items-center justify-content-center" style="min-height: 65vh;">
        <div class="text-center" style="max-width: 480px;">
            <div class="mx-auto mb-4 d-flex align-items-center justify-content-center rounded-circle"
                 style="width: 96px; height: 96px; background: #fdecea;">
                <i class="bx bx-shield-x" style="font-size: 46px; color: #dc3545;"></i>
            </div>
            <h3 class="fw-bold mb-2">Access Restricted</h3>
            <p class="text-muted mb-4">
                Your role does not have permission to view this page. If you believe this is a
                mistake, please contact your District Khadhi or the Directorate for Sharia.
            </p>
            <a href="{{ url('/users/dashboard') }}" class="btn btn-success px-4">
                <i class="bx bx-arrow-back me-1"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
