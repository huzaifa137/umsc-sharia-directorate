@props(['label', 'value', 'note' => null, 'icon' => null, 'href' => null, 'tone' => null])
@php $tag = $href ? 'a' : 'div'; @endphp
<{{ $tag }} @if ($href) href="{{ $href }}" @endif class="ui-stat {{ $tone ? 'ui-stat--' . $tone : '' }}">
    <span class="ui-stat__label">@if ($icon)<i class="bx {{ $icon }}" aria-hidden="true"></i>@endif{{ $label }}</span>
    <strong class="ui-stat__value">{{ is_numeric($value) ? number_format($value) : $value }}</strong>
    @if ($note)<span class="ui-stat__note">{{ $note }}</span>@endif
</{{ $tag }}>
