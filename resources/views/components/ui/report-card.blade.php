@props(['href', 'module' => 'records'])
<section {{ $attributes->class(['card', 'ui-report']) }}>
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <span class="ui-report__icon"><i class="bx bxs-file-pdf" aria-hidden="true"></i></span>
            <div>
                <h2 class="h6 mb-1">Reports and exports</h2>
                <p class="text-muted small mb-0">Filter {{ $module }} by date, region and status, then export a certified report.</p>
            </div>
        </div>
        <a href="{{ $href }}" class="ui-btn">Open reports</a>
    </div>
</section>
