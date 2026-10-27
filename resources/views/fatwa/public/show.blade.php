<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $fatwa->title }} | Fatwa | UMSC Directorate of Sharia</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/boxicons/2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root { --f-green: #059568; --f-dark: #0b3d2e; }
        * { box-sizing: border-box; }
        body { margin: 0; font-family: -apple-system, 'Segoe UI', Roboto, Arial, sans-serif; background: #faf9f6; color: #1a202c; }

        .f-nav { display: flex; align-items: center; justify-content: space-between; padding: 14px 30px; background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,.06); position: relative; z-index: 10; }
        .f-nav img.f-nav-logo { height: 48px; }
        .f-nav ul.nav { list-style: none; display: flex; align-items: center; gap: 28px; margin: 0; padding: 0; }
        .f-nav ul.nav li a { text-decoration: none; font-weight: 600; font-size: .9rem; }
        .f-nav ul.nav li a.active, .f-nav ul.nav li a:hover span { color: var(--f-green) !important; }
        .f-nav .menu-trigger { display: none; }
        @media (max-width: 767px) {
            .f-nav ul.nav { gap: 14px; flex-wrap: wrap; justify-content: flex-end; }
            .f-nav img.f-nav-logo { height: 38px; }
        }

        .f-top { background: linear-gradient(135deg, var(--f-dark), var(--f-green)); color: #fff; padding: 40px 20px 60px; }
        .f-top .wrap { max-width: 760px; margin: 0 auto; }
        .f-top a.back { color: #fff; opacity: .85; text-decoration: none; font-size: .9rem; display: inline-flex; align-items: center; gap: 6px; }
        .f-cat-badge { display: inline-block; background: rgba(255,255,255,.18); padding: 5px 14px; border-radius: 20px; font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; margin: 16px 0 10px; }
        .f-top h1 { font-size: 1.7rem; margin: 0 0 8px; line-height: 1.35; }
        .f-top .f-date { opacity: .8; font-size: .85rem; }

        .f-body { max-width: 760px; margin: -30px auto 60px; padding: 0 20px; }
        .f-panel { background: #fff; border-radius: 16px; padding: 28px 30px; box-shadow: 0 10px 34px rgba(0,0,0,.07); margin-bottom: 22px; }
        .f-panel h2 { font-size: 1rem; text-transform: uppercase; letter-spacing: .04em; color: var(--f-green); margin: 0 0 14px; display: flex; align-items: center; gap: 8px; }
        .f-panel .content { line-height: 1.8; font-size: .98rem; white-space: pre-line; }

        .f-ref { border-left: 4px solid var(--f-green); background: #f0fdf7; border-radius: 0 12px 12px 0; padding: 18px 20px; margin-bottom: 18px; }
        .f-ref h3 { margin: 0 0 8px; font-size: .85rem; color: var(--f-green); display: flex; align-items: center; gap: 6px; }
        .f-ref .content { white-space: pre-line; font-style: italic; color: #2d3748; line-height: 1.7; }

        .f-video { position: relative; padding-top: 56.25%; border-radius: 12px; overflow: hidden; margin-bottom: 6px; }
        .f-video iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; }

        .f-related { max-width: 760px; margin: 0 auto 60px; padding: 0 20px; }
        .f-related h3 { font-size: 1rem; color: #4a5568; margin-bottom: 14px; }
        .f-related a { display: block; background: #fff; border-radius: 12px; padding: 14px 18px; margin-bottom: 10px; text-decoration: none; color: inherit; box-shadow: 0 4px 14px rgba(0,0,0,.05); }
        .f-related a:hover { box-shadow: 0 8px 22px rgba(0,0,0,.1); }
        .f-related .cat { font-size: .7rem; color: var(--f-green); font-weight: 700; text-transform: uppercase; }

        .f-footer { text-align: center; padding: 20px; color: #a0aec0; font-size: .85rem; }
    </style>
</head>
<body>

    <header class="f-nav">
        <img class="f-nav-logo" src="{{ asset('assets/img/branding/logo-png.png') }}" alt="UMSC Logo" onerror="this.style.display='none'">

        <!-- ***** Menu Start ***** -->
        <ul class="nav">
            <li class="scroll-to-section">
                <a href="{{ url('/') }}">
                    <span style="color: black;">Home</span>
                </a>
            </li>

            <li class="scroll-to-section">
                <a href="{{ url('/') }}#contact">
                    <span style="color: black;">Contact Us</span>
                </a>
            </li>

            <li>
                <a href="{{ route('fatwa.public.index') }}" class="active">
                    <span style="color: black;">Fatwa</span>
                </a>
            </li>

            <li>
                <a href="{{ url('users/login') }}" class="login-btn"
                    style="border: 2px solid #4CAF50; color: #4CAF50 !important; padding: 6px 18px; border-radius: 5px; font-weight: 600; text-decoration: none; margin-left: 15px; display: inline-flex; align-items: center; justify-content: center; height: 40px;">
                    {{ __('ui.nav.login') }}
                </a>
            </li>
        </ul>

        <a class='menu-trigger'>
            <span>Menu</span>
        </a>
        <!-- ***** Menu End ***** -->
    </header>

    @if($fatwa->status !== 'published')
        <div style="background:#fff7e6; color:#b45309; text-align:center; padding:8px 16px; font-size:.85rem; font-weight:600;">
            <i class='bx bx-info-circle'></i> This fatwa is a draft — only visible to you because you're logged in. It will not appear on the public site until published.
        </div>
    @endif

    <div class="f-top">
        <div class="wrap">
            <a href="{{ route('fatwa.public.index') }}" class="back"><i class='bx bx-arrow-back'></i> All Fatwa</a>
            @if($fatwa->category)
                <div class="f-cat-badge">{{ $fatwa->category }}</div>
            @endif
            <h1>{{ $fatwa->title }}</h1>
            <div class="f-date">{{ optional($fatwa->published_at)->format('d F Y') }}</div>
        </div>
    </div>

    <div class="f-body">
        <div class="f-panel">
            <h2><i class='bx bx-help-circle'></i> The Question</h2>
            <div class="content">{{ $fatwa->question }}</div>
        </div>

        <div class="f-panel">
            <h2><i class='bx bx-check-shield'></i> The Ruling</h2>
            <div class="content">{{ $fatwa->ruling }}</div>

            @if($fatwa->quran_reference)
                <div class="f-ref" style="margin-top: 20px;">
                    <h3><i class='bx bx-book'></i> Qur'an</h3>
                    <div class="content">{{ $fatwa->quran_reference }}</div>
                </div>
            @endif

            @if($fatwa->hadith_reference)
                <div class="f-ref">
                    <h3><i class='bx bx-bookmark'></i> Hadith</h3>
                    <div class="content">{{ $fatwa->hadith_reference }}</div>
                </div>
            @endif

            @if($fatwa->youtube_embed_url)
                <div class="f-video">
                    <iframe src="{{ $fatwa->youtube_embed_url }}" allowfullscreen></iframe>
                </div>
            @endif
        </div>
    </div>

    @if($related->isNotEmpty())
        <div class="f-related">
            <h3>Related Fatwa</h3>
            @foreach($related as $r)
                <a href="{{ route('fatwa.public.show', $r->slug) }}">
                    @if($r->category)<div class="cat">{{ $r->category }}</div>@endif
                    <div>{{ $r->title }}</div>
                </a>
            @endforeach
        </div>
    @endif

    <div class="f-footer">&copy; {{ date('Y') }} UMSC &mdash; Directorate of Sharia.</div>

</body>
</html>