{{-- The one frame used by every certificate: a green rule, a gold rule and a
     hairline, with a corner boss at each corner. Drawn in SVG, so it prints
     sharp at any size and needs no image files. --}}
@php
    $portrait = ($orientation ?? 'landscape') === 'portrait';
    $W = $portrait ? 210 : 297;
    $H = $portrait ? 297 : 210;
    $bosses = [
        [7, 7], [$W - 20, 7], [7, $H - 20], [$W - 20, $H - 20],
    ];
@endphp
<svg class="cert-frame" viewBox="0 0 {{ $W }} {{ $H }}" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
    <rect x="7" y="7" width="{{ $W - 14 }}" height="{{ $H - 14 }}" fill="none" stroke="#0d4b1e" stroke-width="1.6" />
    <rect x="9.6" y="9.6" width="{{ $W - 19.2 }}" height="{{ $H - 19.2 }}" fill="none" stroke="#b08d2e" stroke-width="0.4" />
    <rect x="11.1" y="11.1" width="{{ $W - 22.2 }}" height="{{ $H - 22.2 }}" fill="none" stroke="#0d4b1e" stroke-width="0.2" />
    @foreach ($bosses as $b)
        @php $cx = $b[0] + 6.5; $cy = $b[1] + 6.5; @endphp
        <rect x="{{ $b[0] }}" y="{{ $b[1] }}" width="13" height="13" fill="#0d4b1e" />
        <rect x="{{ $b[0] + 1.1 }}" y="{{ $b[1] + 1.1 }}" width="10.8" height="10.8" fill="none" stroke="#b08d2e" stroke-width="0.25" />
        <rect x="{{ $cx - 3.1 }}" y="{{ $cy - 3.1 }}" width="6.2" height="6.2" fill="none" stroke="#e6c93a" stroke-width="0.35" />
        <rect x="{{ $cx - 3.1 }}" y="{{ $cy - 3.1 }}" width="6.2" height="6.2" fill="none" stroke="#e6c93a" stroke-width="0.35"
            transform="rotate(45 {{ $cx }} {{ $cy }})" />
        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="0.9" fill="#e6c93a" />
    @endforeach
</svg>
<img class="cert-mark" src="{{ asset('assets/img/branding/umsc-seal.png') }}" alt="">
