@extends('layouts.public')

@section('title', 'Directorate of Sharia | Uganda Muslim Supreme Council')

@php
    $stats = $stats ?? [];
    $fatwas = $fatwas ?? collect();
    $hasStats = collect($stats)->filter()->isNotEmpty();

    $services = [
        ['Nikah registration', 'Marriages are registered by the local Imaam, reviewed, and issued with a certificate that carries a unique reference number.'],
        ['Divorce', 'Divorce cases are recorded with their supporting documents and passed through review and approval before a certificate is issued.'],
        ['Inheritance', 'Estates, heirs and properties are documented and verified so that shares can be settled on a clear, auditable record.'],
        ['Guardianship', 'Guardians of minors and dependants are registered, with the details of the ward and the person responsible for them.'],
        ['New Muslims', 'Converts are registered, issued a certificate, and linked to the mosque and community that received them.'],
        ['Consultancy', 'Individuals and institutions can ask the Directorate for guidance and receive a reviewed, signed opinion.'],
    ];

    $steps = [
        ['At the mosque', 'The Imaam enters the application into the system on behalf of the family.'],
        ['Review', 'The County Sheikh and District Khadhi check the details and the documents.'],
        ['Approval', 'Regional and national officers approve the record. Each action is logged.'],
        ['Certificate', 'An official certificate is printed with its reference number.'],
    ];

    $levels = [
        ['Director of Sharia', 'Sees and manages records for the whole country.'],
        ['Regional Assistant', 'Oversees every district within the region.'],
        ['District Khadhi', 'Reviews and approves cases from across the district.'],
        ['County Sheikh', 'Supports the mosques within the county.'],
        ['Imaam', 'Registers and follows up the records of the local mosque.'],
    ];
@endphp

@section('content')

    {{-- Hero --}}
    <section class="u-hero" id="home">
        <div class="u-wrap">
            <div>
                <div class="u-bismillah">بسم الله الرحمن الرحيم</div>
                <h1>Marriage, family and inheritance records for Uganda's Muslims.</h1>
                <p class="u-lede">The Directorate of Sharia keeps the national register of Nikah, divorce, inheritance,
                    guardianship and conversion, and publishes rulings for anyone who needs guidance. Mosques,
                    counties, districts and regions all work from the same record.</p>
                <div class="u-hero-actions">
                    <a href="{{ url('users/login') }}" class="u-btn u-btn--light">Staff sign in</a>
                    <a href="{{ route('fatwa.public.index') }}" class="u-link u-link--light">Read the Fatwa</a>
                </div>
            </div>
            <div class="u-seal" aria-hidden="true"><img src="{{ asset('asset/images/logo.png') }}" alt=""></div>
        </div>
    </section>

    {{-- Certificate check --}}
    <section class="u-check" aria-labelledby="checkTitle">
        <div class="u-wrap">
            <div>
                <h2 id="checkTitle">Check a certificate</h2>
                <p>Enter the reference printed on the certificate to confirm it was issued by the Directorate.</p>
            </div>
            <form id="uCheckForm" novalidate>
                <div>
                    <label for="cType">Type</label>
                    <select class="u-input" id="cType" name="type">
                        <option value="nikah">Nikah</option>
                        <option value="divorce">Divorce</option>
                        <option value="inheritance">Inheritance</option>
                        <option value="guardianship">Guardianship</option>
                        <option value="convert">Convert</option>
                    </select>
                </div>
                <div>
                    <label for="cCode">Reference number</label>
                    <input class="u-input" id="cCode" name="code" type="text" placeholder="NK-UMSC0000000000"
                        autocomplete="off">
                </div>
                <button type="submit" class="u-btn u-btn--solid">Check</button>
                <p class="u-check-result" id="uCheckResult" role="status" aria-live="polite"></p>
            </form>
        </div>
    </section>

    {{-- Figures --}}
    @if ($hasStats)
        <section class="u-figures" aria-label="The register in numbers">
            <div class="u-wrap">
                <div class="u-figure"><strong>{{ number_format($stats['nikah'] ?? 0) }}</strong><span>Nikah records on
                        the register</span></div>
                <div class="u-figure"><strong>{{ number_format($stats['mosques'] ?? 0) }}</strong><span>Mosques
                        connected</span></div>
                <div class="u-figure"><strong>{{ number_format($stats['fatwas'] ?? 0) }}</strong><span>Fatwa rulings
                        published</span></div>
            </div>
        </section>
    @endif

    {{-- Services --}}
    <section class="u-section" id="services">
        <div class="u-wrap u-services">
            <div class="u-services-intro">
                <h2>What the Directorate handles</h2>
                <p class="u-lede">Six kinds of record, each with its own workflow, certificate and approval trail.</p>
            </div>
            <div>
                <ol class="u-index">
                    @foreach ($services as $i => $s)
                        <li>
                            <span class="u-index-no">{{ sprintf('%02d', $i + 1) }}</span>
                            <div>
                                <h3>{{ $s[0] }}</h3>
                                <p>{{ $s[1] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
                <p class="u-index-note">Applications are entered by registered Imaams and officers through the staff
                    portal. <a href="{{ url('users/login') }}" class="u-link">Sign in</a></p>
            </div>
        </div>
    </section>

    {{-- Process --}}
    <section class="u-section u-section--paper" id="process">
        <div class="u-wrap">
            <h2>From the mosque to the certificate</h2>
            <p class="u-lede">Every record follows the same four stages, whichever service it belongs to.</p>
            <ol class="u-steps">
                @foreach ($steps as $st)
                    <li>
                        <h3>{{ $st[0] }}</h3>
                        <p>{{ $st[1] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    {{-- Structure --}}
    <section class="u-section" id="structure">
        <div class="u-wrap u-structure">
            <div>
                <h2>One structure, from the mosque to the Director</h2>
                <p class="u-lede">The system follows the way the Muslim community in Uganda is organised. Each officer
                    works with the records of their own mosque, county, district or region, and sees nothing beyond
                    that.</p>
                <p class="u-lede">Every change to a record is written to an activity log, and records kept on paper can
                    be brought into the system in bulk.</p>
            </div>
            <ul class="u-tree">
                @foreach ($levels as $l)
                    <li><strong>{{ $l[0] }}</strong><span>{{ $l[1] }}</span></li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Fatwa --}}
    @if ($fatwas->count())
        <section class="u-section u-section--paper" id="fatwa">
            <div class="u-wrap u-fatwa">
                <div class="u-services-intro">
                    <h2>Recent Fatwa</h2>
                    <p class="u-lede">Rulings published by the Directorate, open to everyone.</p>
                    <a href="{{ route('fatwa.public.index') }}" class="u-link">All rulings</a>
                </div>
                <ul class="u-fatwa-list">
                    @foreach ($fatwas as $f)
                        <li>
                            <a href="{{ route('fatwa.public.show', $f) }}">
                                @if ($f->category)
                                    <span class="u-fatwa-cat">{{ $f->category }}</span>
                                @endif
                                <h3>{{ $f->title }}</h3>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags((string) ($f->question ?: $f->ruling)), 140) }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif

    {{-- Contact --}}
    <section class="u-section" id="contact">
        <div class="u-wrap">
            <h2>Contact the Directorate</h2>
            <p class="u-lede">For questions about a record, a certificate or access to the system.</p>
            <div class="u-contact">
                <div>
                    <h3>Office</h3>
                    <p>UMSC Headquarters<br>Old Kampala, Uganda</p>
                </div>
                <div>
                    <h3>Telephone</h3>
                    <a href="tel:+256000000000">+256 000 000 000</a>
                </div>
                <div>
                    <h3>Email</h3>
                    <a href="mailto:sharia@umsc.example">sharia@umsc.example</a>
                </div>
            </div>
        </div>
    </section>

@endsection
