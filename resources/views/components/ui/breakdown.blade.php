@props(['title' => null, 'subtitle' => null, 'items' => [], 'footerHref' => null, 'footerLabel' => 'View all records'])
{{-- items: [['label' => 'Pending', 'value' => 4, 'href' => '/x', 'tone' => 'warn'], ...] --}}
<section {{ $attributes->class(['card']) }}>
    @if ($title)
        <div class="card-header">
            <h2 class="h5 mb-0">{{ $title }}</h2>
            @if ($subtitle)<p class="text-muted small mb-0 mt-1">{{ $subtitle }}</p>@endif
        </div>
    @endif
    <ul class="ui-breakdown">
        @foreach ($items as $item)
            @php $tag = !empty($item['href']) ? 'a' : 'div'; @endphp
            <li>
                <{{ $tag }} @if (!empty($item['href'])) href="{{ $item['href'] }}" @endif class="ui-breakdown__row">
                    <span class="ui-dot ui-dot--{{ $item['tone'] ?? 'idle' }}"></span>
                    <span class="ui-breakdown__label">{{ $item['label'] }}</span>
                    <strong class="ui-breakdown__value">{{ number_format((int) ($item['value'] ?? 0)) }}</strong>
                </{{ $tag }}>
            </li>
        @endforeach
    </ul>
    @if ($footerHref)
        <div class="card-footer">
            <a href="{{ $footerHref }}" class="ui-link">{{ $footerLabel }} <i class="bx bx-right-arrow-alt rtl-flip" aria-hidden="true"></i></a>
        </div>
    @endif
</section>
