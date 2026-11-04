@extends('layouts.public')

@section('title', 'Fatwa | Directorate of Sharia | Uganda Muslim Supreme Council')
@section('description', 'Rulings on matters of faith and daily life, published by the UMSC Directorate of Sharia and open to everyone.')

@section('content')
    @php
        $filtered = $search !== '' || $category !== '';

        // Builds a listing URL that keeps the current search term and never
        // emits empty query parameters (?q=&category=).
        $listUrl = fn (array $extra = []) => route(
            'fatwa.public.index',
            array_filter(array_merge(['q' => $search], $extra), fn ($v) => $v !== '' && $v !== null)
        );
    @endphp

    {{-- Page head --}}
    <section class="u-pagehead">
        <div class="u-wrap">
            <ol class="u-crumbs" aria-label="Breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li aria-current="page">Fatwa</li>
            </ol>
            <div class="u-bismillah" lang="ar">فتاوى</div>
            <h1>Fatwa</h1>
            <p class="u-lede">Rulings on matters of faith and daily life, issued by the Directorate of Sharia and open
                to everyone to read.</p>
        </div>
    </section>

    <div class="u-wrap u-archive">

        {{-- Search and topics --}}
        <aside class="u-archive-side" aria-label="Search and topics">
            <form class="u-search" method="get" action="{{ route('fatwa.public.index') }}" role="search">
                @if ($category !== '')
                    <input type="hidden" name="category" value="{{ $category }}">
                @endif
                <label class="u-sr" for="fatwaSearch">Search the rulings</label>
                <input class="u-input" id="fatwaSearch" type="search" name="q" value="{{ $search }}"
                    placeholder="Search rulings" autocomplete="off">
                <button type="submit" class="u-btn u-btn--solid">Search</button>
            </form>

            @if ($categories->isNotEmpty())
                <h2 class="u-side-title">Topics</h2>
                <ul class="u-cats">
                    <li>
                        <a href="{{ $listUrl() }}" class="{{ $category === '' ? 'is-active' : '' }}"
                            @if ($category === '') aria-current="true" @endif>All rulings</a>
                    </li>
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ $listUrl(['category' => $cat]) }}"
                                class="{{ $category === $cat ? 'is-active' : '' }}"
                                @if ($category === $cat) aria-current="true" @endif>{{ $cat }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </aside>

        {{-- Rulings --}}
        <div class="u-archive-main">
            <div class="u-results-bar">
                <span>
                    @if ($fatwas->isEmpty())
                        No rulings
                    @else
                        {{ number_format($fatwas->count()) }} {{ \Illuminate\Support\Str::plural('ruling', $fatwas->count()) }}
                    @endif
                    @if ($search !== '')
                        for &ldquo;{{ $search }}&rdquo;
                    @endif
                    @if ($category !== '')
                        in {{ $category }}
                    @endif
                </span>
                @if ($filtered)
                    <a href="{{ route('fatwa.public.index') }}" class="u-link">Clear filters</a>
                @endif
            </div>

            @if ($fatwas->isEmpty())
                <div class="u-empty">
                    <h3>{{ $filtered ? 'No rulings match your search' : 'No rulings have been published yet' }}</h3>
                    <p>
                        {{ $filtered ? 'Try a different word, or browse every topic.' : 'Please check back soon. New rulings appear here as soon as the Directorate publishes them.' }}
                    </p>
                    @if ($filtered)
                        <a href="{{ route('fatwa.public.index') }}" class="u-btn u-btn--line u-btn--sm">Show all rulings</a>
                    @endif
                </div>
            @else
                <ul class="u-rulings">
                    @foreach ($fatwas as $fatwa)
                        <li class="u-ruling">
                            <a href="{{ route('fatwa.public.show', $fatwa->slug) }}">
                                <div>
                                    @if ($fatwa->category)
                                        <span class="u-fatwa-cat">{{ $fatwa->category }}</span>
                                    @endif
                                    <h3>{{ $fatwa->title }}</h3>
                                    <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) ($fatwa->question ?: $fatwa->ruling)), 170) }}</p>
                                    @if ($fatwa->published_at)
                                        <div class="u-ruling-meta">{{ $fatwa->published_at->format('d F Y') }}</div>
                                    @endif
                                </div>
                                <i class="fa-solid fa-arrow-right u-ruling-go" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
