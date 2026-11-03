@props(['title' => null, 'subtitle' => null, 'flush' => false])
<section {{ $attributes->class(['card']) }}>
    @if ($title)
        <div class="card-header d-flex justify-content-between align-items-start gap-3">
            <div>
                <h2 class="h5 mb-0">{{ $title }}</h2>
                @if ($subtitle)<p class="text-muted small mb-0 mt-1">{{ $subtitle }}</p>@endif
            </div>
            @isset($actions){{ $actions }}@endisset
        </div>
    @endif
    <div class="{{ $flush ? '' : 'card-body' }}">{{ $slot }}</div>
</section>
