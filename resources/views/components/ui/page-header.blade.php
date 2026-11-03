@props(['title', 'subtitle' => null, 'crumbs' => []])
<header class="ui-page-head">
    <div>
        @if ($crumbs)
            <ul class="ui-crumbs" aria-label="Breadcrumb">
                @foreach ($crumbs as $label => $href)
                    <li>@if ($href)<a href="{{ $href }}">{{ $label }}</a>@else{{ $label }}@endif</li>
                @endforeach
            </ul>
        @endif
        <h1 class="ui-page-title">{{ $title }}</h1>
        @if ($subtitle)<p class="ui-page-sub">{{ $subtitle }}</p>@endif
    </div>
    @if (!$slot->isEmpty())
        <div class="ui-page-actions">{{ $slot }}</div>
    @endif
</header>
