{{-- Fonts, stylesheet and page size. The page size makes the browser's own
     Print produce an exact A4 sheet with no margins or headers. --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=IBM+Plex+Sans:wght@400;500;600&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,500;0,8..60,600;1,8..60,400&display=swap"
    rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/umsc-certificate.css') }}">
<style>
    @page { size: A4 {{ ($orientation ?? 'landscape') === 'portrait' ? 'portrait' : 'landscape' }}; margin: 0; }
</style>
