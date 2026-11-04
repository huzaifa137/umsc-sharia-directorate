@extends('layouts.public')

@section('title', $fatwa->title . ' | Fatwa | Directorate of Sharia')
@section('description', \Illuminate\Support\Str::limit(strip_tags((string) ($fatwa->question ?: $fatwa->ruling)), 155))

@section('content')

    @if ($fatwa->status !== 'published')
        <div class="u-notice" role="status">
            <div class="u-wrap">
                <i class="fa-solid fa-circle-info" aria-hidden="true"></i>
                <span>This fatwa is a draft. You can see it because you are signed in; it will not appear on the public
                    site until it is published.</span>
            </div>
        </div>
    @endif

    {{-- Page head --}}
    <section class="u-pagehead">
        <div class="u-wrap">
            <ol class="u-crumbs" aria-label="Breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('fatwa.public.index') }}">Fatwa</a></li>
                @if ($fatwa->category)
                    <li><a href="{{ route('fatwa.public.index', ['category' => $fatwa->category]) }}">{{ $fatwa->category }}</a></li>
                @endif
            </ol>
            @if ($fatwa->category)
                <span class="u-pagehead-kicker">{{ $fatwa->category }}</span>
            @endif
            <h1>{{ $fatwa->title }}</h1>
            <div class="u-pagehead-meta">
                @if ($fatwa->published_at)
                    <span><i class="fa-regular fa-calendar" aria-hidden="true"></i> {{ $fatwa->published_at->format('d F Y') }}</span>
                @endif
                @if ($fatwa->views_count)
                    <span><i class="fa-regular fa-eye" aria-hidden="true"></i> {{ number_format($fatwa->views_count) }} {{ \Illuminate\Support\Str::plural('view', $fatwa->views_count) }}</span>
                @endif
            </div>
        </div>
    </section>

    <div class="u-wrap u-article-wrap">

        <article class="u-article">

            <section class="u-block" aria-labelledby="fatwaQuestion">
                <h2 class="u-block-label" id="fatwaQuestion"><i class="fa-regular fa-circle-question" aria-hidden="true"></i> The question</h2>
                <div class="u-prose u-prose--question">{{ $fatwa->question }}</div>
            </section>

            <section class="u-block" aria-labelledby="fatwaRuling">
                <h2 class="u-block-label" id="fatwaRuling"><i class="fa-solid fa-scale-balanced" aria-hidden="true"></i> The ruling</h2>
                <div class="u-prose">{{ $fatwa->ruling }}</div>
            </section>

            @if ($fatwa->quran_reference || $fatwa->hadith_reference)
                <section class="u-block" aria-labelledby="fatwaSources">
                    <h2 class="u-block-label" id="fatwaSources"><i class="fa-solid fa-book-open" aria-hidden="true"></i> Evidence</h2>

                    @if ($fatwa->quran_reference)
                        <figure class="u-cite">
                            <figcaption>Qur&rsquo;an</figcaption>
                            <div class="u-prose">{{ $fatwa->quran_reference }}</div>
                        </figure>
                    @endif

                    @if ($fatwa->hadith_reference)
                        <figure class="u-cite">
                            <figcaption>Hadith</figcaption>
                            <div class="u-prose">{{ $fatwa->hadith_reference }}</div>
                        </figure>
                    @endif
                </section>
            @endif

            @if ($fatwa->youtube_embed_url)
                <section class="u-block" aria-labelledby="fatwaVideo">
                    <h2 class="u-block-label" id="fatwaVideo"><i class="fa-solid fa-circle-play" aria-hidden="true"></i> Watch</h2>
                    <div class="u-video">
                        <iframe src="{{ $fatwa->youtube_embed_url }}" title="{{ $fatwa->title }}" loading="lazy"
                            allow="accelerometer; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </section>
            @endif

            <a href="{{ route('fatwa.public.index') }}" class="u-link"><i class="fa-solid fa-arrow-left u-back-ico" aria-hidden="true"></i> All rulings</a>
        </article>

        <aside class="u-aside" aria-label="More from the Directorate">
            @if ($related->isNotEmpty())
                <div>
                    <h2 class="u-side-title">Related rulings</h2>
                    <ul class="u-related">
                        @foreach ($related as $r)
                            <li>
                                <a href="{{ route('fatwa.public.show', $r->slug) }}">
                                    @if ($r->category)
                                        <span class="u-fatwa-cat">{{ $r->category }}</span>
                                    @endif
                                    <strong>{{ $r->title }}</strong>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="u-aside-card">
                <h2>Need further guidance?</h2>
                <p>If your situation is not covered by a published ruling, you can put it to the Directorate.</p>
                <a href="{{ url('/') }}#contact" class="u-btn u-btn--line u-btn--sm">Contact the Directorate</a>
            </div>
        </aside>
    </div>
@endsection
