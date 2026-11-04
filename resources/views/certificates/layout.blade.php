{{-- One sheet for every certificate. A certificate view extends this, sets
     $record, $certType, $titleEn, $titleAr (and optionally $orientation,
     $downloadFilename), and fills the "body" section. --}}
@php
    $orientation = $orientation ?? 'landscape';
    $portrait = $orientation === 'portrait';
    $certNo = $record->application_id ?? ('UMSC-' . strtoupper($certType) . '-' . $record->id);
    $downloadFilename = $downloadFilename ?? ($certNo . '.pdf');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $titleEn }} | {{ $certNo }}</title>
    @include('certificates.partials.style', ['orientation' => $orientation])
</head>

<body class="cert-page">

    @include('certificates.partials.actions', ['certNo' => $certNo])

    <div class="cert-stage">
        <div class="cert-box">
            <div class="cert-fit">
                <article class="certificate {{ $portrait ? 'certificate--portrait' : '' }}"
                    data-orientation="{{ $orientation }}" data-filename="{{ $downloadFilename }}">

                    @include('certificates.partials.frame', ['orientation' => $orientation])

                    <div class="cert-inner">
                        @include('certificates.partials.header', ['certNo' => $certNo])

                        <div class="cert-body">
                            @yield('body')
                        </div>

                        @include('certificates.partials.footer')
                    </div>
                </article>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/umsc-certificate.js') }}"></script>
</body>

</html>
