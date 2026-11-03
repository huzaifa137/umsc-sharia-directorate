@props(['cols' => 4])
<section class="ui-stats" style="--cols: {{ (int) $cols }}">{{ $slot }}</section>
