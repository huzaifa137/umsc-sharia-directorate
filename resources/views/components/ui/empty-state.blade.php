@props(['title', 'text' => null, 'icon' => 'bx-folder-open'])
<div {{ $attributes->class(['ui-empty']) }}>
    <span class="ui-empty__icon"><i class="bx {{ $icon }}" aria-hidden="true"></i></span>
    <h3>{{ $title }}</h3>
    @if ($text)<p>{{ $text }}</p>@endif
    {{ $slot }}
</div>
