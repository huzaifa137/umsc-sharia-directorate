<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fatwa - Islamic Rulings | UMSC Directorate of Sharia</title>
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

        .f-hero { background: linear-gradient(135deg, var(--f-dark), var(--f-green)); color: #fff; padding: 70px 20px 90px; text-align: center; position: relative; }
        .f-hero img.logo { width: 64px; margin-bottom: 14px; }
        .f-hero h1 { font-size: 2.2rem; margin: 0 0 10px; font-weight: 800; }
        .f-hero p { max-width: 560px; margin: 0 auto; opacity: .9; line-height: 1.6; }

        .f-search-wrap { max-width: 640px; margin: -36px auto 0; padding: 0 20px; position: relative; z-index: 2; }
        .f-search { background: #fff; border-radius: 14px; box-shadow: 0 14px 40px rgba(0,0,0,.12); padding: 10px 14px; display: flex; align-items: center; gap: 10px; }
        .f-search i { color: var(--f-green); font-size: 1.3rem; }
        .f-search input { border: none; outline: none; flex: 1; font-size: 1rem; padding: 8px 0; }
        .f-search button { background: var(--f-green); color: #fff; border: none; border-radius: 10px; padding: 10px 18px; font-weight: 600; cursor: pointer; }

        .f-categories { max-width: 900px; margin: 22px auto 0; padding: 0 20px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
        .f-cat-pill { border: 1px solid #e2e8f0; background: #fff; padding: 6px 16px; border-radius: 20px; font-size: .85rem; text-decoration: none; color: #4a5568; transition: all .2s; }
        .f-cat-pill:hover, .f-cat-pill.active { background: var(--f-green); border-color: var(--f-green); color: #fff; }

        .f-timeline { max-width: 900px; margin: 50px auto; padding: 0 20px; position: relative; }
        .f-timeline::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 3px; background: #e2e8f0; transform: translateX(-50%); }

        .f-item { position: relative; display: flex; align-items: flex-start; margin-bottom: 46px; width: 100%; }
        .f-item:nth-child(odd) { justify-content: flex-start; }
        .f-item:nth-child(even) { justify-content: flex-end; }

        .f-icon-circle { position: absolute; left: 50%; top: 0; transform: translateX(-50%); width: 58px; height: 58px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.5rem; box-shadow: 0 8px 20px rgba(0,0,0,.15); z-index: 2; border: 4px solid #faf9f6; }

        .f-card { width: 46%; background: #fff; border-radius: 16px; padding: 20px 22px; box-shadow: 0 6px 24px rgba(0,0,0,.06); text-decoration: none; color: inherit; display: block; transition: transform .2s, box-shadow .2s; }
        .f-card:hover { transform: translateY(-4px); box-shadow: 0 14px 32px rgba(0,0,0,.12); }
        .f-card .f-cat-label { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; display: inline-block; }
        .f-card h3 { margin: 0 0 8px; font-size: 1.05rem; line-height: 1.4; }
        .f-card p { margin: 0; font-size: .88rem; color: #718096; line-height: 1.5; }
        .f-card .f-meta { margin-top: 10px; font-size: .75rem; color: #a0aec0; }

        .f-empty { text-align: center; padding: 60px 20px; color: #a0aec0; }
        .f-empty i { font-size: 3rem; color: var(--f-green); opacity: .3; }

        .f-footer { text-align: center; padding: 30px 20px; color: #a0aec0; font-size: .85rem; }

        @media (max-width: 767px) {
            .f-hero h1 { font-size: 1.6rem; }
            .f-timeline::before { left: 28px; }
            .f-icon-circle { left: 28px; width: 46px; height: 46px; font-size: 1.2rem; }
            .f-item, .f-item:nth-child(odd), .f-item:nth-child(even) { justify-content: flex-start; padding-left: 64px; }
            .f-card { width: 100%; }
        }
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

    <div class="f-hero">
        <img class="logo" src="{{ asset('assets/img/branding/logo-png.png') }}" alt="UMSC Logo" onerror="this.style.display='none'">
        <h1>Fatwa &mdash; Islamic Rulings</h1>
        <p>Guidance on matters of faith and daily life, issued by the Directorate of Sharia, Uganda Muslim Supreme Council.</p>
    </div>

    <div class="f-search-wrap">
        <form class="f-search" method="GET" action="{{ route('fatwa.public.index') }}">
            <i class='bx bx-search'></i>
            <input type="text" name="q" value="{{ $search }}" placeholder="Search a ruling, e.g. 'fasting', 'inheritance'...">
            <button type="submit">Search</button>
        </form>
    </div>

    @if($categories->isNotEmpty())
        <div class="f-categories">
            <a href="{{ route('fatwa.public.index', ['q' => $search]) }}" class="f-cat-pill {{ !$category ? 'active' : '' }}">All</a>
            @foreach($categories as $cat)
                <a href="{{ route('fatwa.public.index', ['q' => $search, 'category' => $cat]) }}"
                   class="f-cat-pill {{ $category == $cat ? 'active' : '' }}">{{ $cat }}</a>
            @endforeach
        </div>
    @endif

    @php $palette = \App\Models\Fatwa::PALETTE; @endphp

    @if($fatwas->isEmpty())
        <div class="f-empty">
            <i class='bx bx-book-open'></i>
            <p>No fatwas published yet. Please check back soon.</p>
        </div>
    @else
        <div class="f-timeline">
            @foreach($fatwas as $i => $fatwa)
                @php $color = $fatwa->color ?: $palette[$i % count($palette)]; @endphp
                <div class="f-item">
                    <div class="f-icon-circle" style="background: {{ $color }};">
                        <i class='bx {{ $fatwa->icon ?: "bx-book-open" }}'></i>
                    </div>
                    <a href="{{ route('fatwa.public.show', $fatwa->slug) }}" class="f-card">
                        @if($fatwa->category)
                            <span class="f-cat-label" style="color: {{ $color }};">{{ $fatwa->category }}</span>
                        @endif
                        <h3>{{ $fatwa->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($fatwa->question), 130) }}</p>
                        <div class="f-meta">{{ optional($fatwa->published_at)->format('d M Y') }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div class="f-footer">&copy; {{ date('Y') }} UMSC &mdash; Directorate of Sharia.</div>

</body>
</html>