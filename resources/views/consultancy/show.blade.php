@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;
    use App\Services\AccessControl;

    $c = $consultancy;
    $user = AccessControl::user();
    $isFull = AccessControl::hasFullAccess();
    $awaitingReview = in_array($c->status, ['submitted', 'under_review']);
    $isOwner = $user && (int) $user->id === (int) $c->created_by;

    $canReview = ($isFull || AccessControl::can('consultancy.review')) && $awaitingReview;
    $canSign = $isFull && $c->status === 'reviewed';
    $canReject = $isFull && in_array($c->status, ['submitted', 'under_review', 'reviewed']);
    $canChange = $canReject;
    $canEdit = ($isFull || $isOwner) && $awaitingReview;
    $canDelete = ($isFull || $isOwner) && in_array($c->status, ['submitted', 'under_review', 'rejected']);
    $canPrint = in_array($c->status, ['approved', 'accomplished']);

    $nin = trim((string) $c->applicant_nin);
    $ninMasked = $nin === '' ? null : (strlen($nin) > 6 ? substr($nin, 0, 3) . str_repeat('•', max(strlen($nin) - 6, 3)) . substr($nin, -3) : str_repeat('•', strlen($nin)));
    $hasResponse = $c->islamic_guidance || $c->recommendation || $c->conditions || $c->restrictions;
    $days = $c->created_at ? (int) $c->created_at->diffInDays(now()) : 0;
@endphp

<link rel="stylesheet" href="{{ asset('css/umsc-records.css') }}">

<div class="container-xxl flex-grow-1 container-p-y rec" id="rec" data-reference="{{ $c->application_id }}">

    @if (session('success') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : 'danger' }} mb-4" role="alert">{{ session('success') ?? session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger mb-4" role="alert">{{ $errors->first() }}</div>
    @endif

    <x-ui.page-header :title="$c->subject ?: $c->applicant_name"
        :subtitle="'Consultancy · ' . $c->application_id"
        :crumbs="['Dashboard' => url('/dashboard'), 'Consultancy' => route('consultancy.dashboard'), $c->application_id => null]">
        <a href="{{ route('consultancy.index') }}" class="ui-btn"><i class="bx bx-list-ul"></i> Consultancy list</a>
        @if ($canEdit)
            <a href="{{ route('consultancy.edit', $c->id) }}" class="ui-btn"><i class="bx bx-edit-alt"></i> Edit</a>
        @endif
        <button type="button" class="ui-btn" data-rec-print><i class="bx bx-printer"></i> Print page</button>
        @if ($canPrint)
            <a href="{{ route('consultancy.print', $c->id) }}" target="_blank" rel="noopener" class="ui-btn ui-btn--primary"><i class="bx bx-certification"></i> Certificate</a>
        @endif
    </x-ui.page-header>

    <dl class="rec-strip">
        <div>
            <dt>Reference</dt>
            <dd><span class="rec-ref">{{ $c->application_id }}</span> <button type="button" class="rec-link" data-rec-copy>Copy</button></dd>
        </div>
        <div><dt>Status</dt><dd><x-ui.status-badge :status="$c->status" :label="$c->status_label" /></dd></div>
        <div><dt>Applicant</dt><dd>{{ $c->applicant_name }}</dd></div>
        <div><dt>Type</dt><dd>{{ $c->consultation_type_label }}</dd></div>
        <div><dt>Lodged</dt><dd>{{ $c->created_at?->format('d M Y, H:i') }}</dd></div>
    </dl>

    <div class="rec-layout">
        <nav class="rec-index" aria-label="Sections">
            <p class="rec-index__title">On this page</p>
            <ol>
                <li><a href="#sec-applicant" data-rec-nav="sec-applicant">Applicant</a></li>
                <li><a href="#sec-consultation" data-rec-nav="sec-consultation">Consultation</a></li>
                @if ($hasResponse)<li><a href="#sec-guidance" data-rec-nav="sec-guidance">Guidance and response</a></li>@endif
            </ol>
        </nav>

        <div class="rec-main">
            <section class="rec-sec" id="sec-applicant">
                <header class="rec-sec__head"><h2>Applicant</h2></header>
                <dl class="rec-dl">
                    <div class="rec-dl__row"><dt>Full name</dt><dd>{{ $c->applicant_name }}</dd></div>
                    <div class="rec-dl__row"><dt>Telephone</dt><dd>@if ($c->applicant_phone)<a class="rec-tel" href="tel:{{ preg_replace('/[^0-9+]/', '', $c->applicant_phone) }}">{{ $c->applicant_phone }}</a>@else<span class="rec-nil">Not provided</span>@endif</dd></div>
                    <div class="rec-dl__row"><dt>Email</dt><dd>@if ($c->applicant_email)<a class="rec-tel" href="mailto:{{ $c->applicant_email }}">{{ $c->applicant_email }}</a>@else<span class="rec-nil">Not provided</span>@endif</dd></div>
                    <div class="rec-dl__row"><dt>National ID (NIN)</dt><dd>@if ($ninMasked)<span class="rec-nin" data-full="{{ $nin }}" data-masked="{{ $ninMasked }}">{{ $ninMasked }}</span> <button type="button" class="rec-link" data-rec-reveal aria-pressed="false">Show</button>@else<span class="rec-nil">Not provided</span>@endif</dd></div>
                    <div class="rec-dl__row"><dt>Occupation</dt><dd>{!! $c->applicant_occupation ? e($c->applicant_occupation) : '<span class="rec-nil">Not provided</span>' !!}</dd></div>
                    <div class="rec-dl__row"><dt>Address</dt><dd>{!! $c->applicant_address ? e($c->applicant_address) : '<span class="rec-nil">Not provided</span>' !!}</dd></div>
                </dl>
            </section>

            <section class="rec-sec" id="sec-consultation">
                <header class="rec-sec__head"><h2>Consultation</h2></header>
                <dl class="rec-dl">
                    <div class="rec-dl__row"><dt>Type</dt><dd>{{ $c->consultation_type_label }}@if ($c->consultation_type_other) <span class="rec-nil">({{ $c->consultation_type_other }})</span>@endif</dd></div>
                    <div class="rec-dl__row"><dt>Subject</dt><dd>{!! $c->subject ? e($c->subject) : '<span class="rec-nil">Not provided</span>' !!}</dd></div>
                    <div class="rec-dl__row is-long"><dt>Description</dt><dd><span class="rec-prose">{{ $c->description }}</span></dd></div>
                    @if ($c->background_info)
                        <div class="rec-dl__row is-long"><dt>Background</dt><dd><span class="rec-prose">{{ $c->background_info }}</span></dd></div>
                    @endif
                    @if ($c->attachment_path)
                        <div class="rec-dl__row is-long"><dt>Attachment</dt><dd><a class="rec-doc" href="{{ Storage::url($c->attachment_path) }}" target="_blank" rel="noopener"><i class="bx bx-file"></i><span><strong>Supporting document</strong><small>{{ strtoupper(pathinfo($c->attachment_path, PATHINFO_EXTENSION)) }} · {{ basename($c->attachment_path) }}</small></span></a></dd></div>
                    @endif
                </dl>
            </section>

            @if ($hasResponse)
                <section class="rec-sec" id="sec-guidance">
                    <header class="rec-sec__head"><h2>Guidance and response</h2></header>
                    <dl class="rec-dl">
                        @if ($c->islamic_guidance)<div class="rec-dl__row is-long"><dt>Islamic guidance</dt><dd><span class="rec-prose">{{ $c->islamic_guidance }}</span></dd></div>@endif
                        @if ($c->recommendation)<div class="rec-dl__row is-long"><dt>Recommendation</dt><dd><span class="rec-prose">{{ $c->recommendation }}</span></dd></div>@endif
                        @if ($c->conditions)<div class="rec-dl__row"><dt>Conditions</dt><dd><span class="rec-prose">{{ $c->conditions }}</span></dd></div>@endif
                        @if ($c->restrictions)<div class="rec-dl__row"><dt>Restrictions</dt><dd><span class="rec-prose">{{ $c->restrictions }}</span></dd></div>@endif
                        @if ($c->quran_reference)<div class="rec-dl__row"><dt>Qur’an reference</dt><dd>{{ $c->quran_reference }}</dd></div>@endif
                        @if ($c->hadith_reference)<div class="rec-dl__row"><dt>Hadith reference</dt><dd>{{ $c->hadith_reference }}</dd></div>@endif
                        @if ($c->scholar_reference)<div class="rec-dl__row"><dt>Scholar reference</dt><dd>{{ $c->scholar_reference }}</dd></div>@endif
                    </dl>
                </section>
            @endif
        </div>

        <aside class="rec-rail">
            @if ($canReview || $canSign || $canReject || $canChange || $canDelete)
                <section class="rec-panel">
                    <h2 class="rec-panel__title">Actions</h2>
                    <p class="rec-panel__text">
                        @if ($canSign) Reviewed and waiting for the Director’s signature.
                        @elseif ($canReview) Waiting for review{{ $days > 0 ? ', lodged ' . $days . ' ' . \Illuminate\Support\Str::plural('day', $days) . ' ago' : '' }}.
                        @else Current status: <strong>{{ $c->status_label }}</strong>. @endif
                    </p>
                    <div class="rec-decide">
                        @if ($canReview)
                            <button type="button" class="rec-decide__btn rec-decide__btn--ok" data-bs-toggle="modal" data-bs-target="#reviewModal">Write review</button>
                        @endif
                        @if ($canSign)
                            <form action="{{ route('consultancy.sign', $c->id) }}" method="POST" data-confirm="Approve and sign this consultation?" data-confirm-text="Approve and sign">
                                @csrf
                                <button type="submit" class="rec-decide__btn rec-decide__btn--ok w-100">Approve and sign</button>
                            </form>
                        @endif
                        @if ($canReject)
                            <form action="{{ route('consultancy.reject', $c->id) }}" method="POST" data-confirm="Reject this consultation?" data-confirm-text="Reject" data-danger="1">
                                @csrf
                                <button type="submit" class="rec-decide__btn rec-decide__btn--bad w-100">Reject</button>
                            </form>
                        @endif
                        @if ($canChange)
                            <button type="button" class="rec-decide__btn" data-bs-toggle="modal" data-bs-target="#statusModal">Change status</button>
                        @endif
                        @if ($canDelete)
                            <form action="{{ route('consultancy.destroy', $c->id) }}" method="POST" data-confirm="Delete this consultation permanently?" data-confirm-text="Delete" data-danger="1">
                                @csrf @method('DELETE')
                                <button type="submit" class="rec-decide__btn rec-decide__btn--bad w-100">Delete</button>
                            </form>
                        @endif
                    </div>
                </section>
            @endif

            <section class="rec-panel">
                <h2 class="rec-panel__title">Case file</h2>
                <dl class="rec-meta">
                    <div><dt>Reference</dt><dd>{{ $c->application_id }}</dd></div>
                    <div><dt>Lodged by</dt><dd>{{ $c->creator->full_name ?? '—' }}</dd></div>
                    <div><dt>Lodged</dt><dd>{{ $c->created_at?->format('d M Y, H:i') }}</dd></div>
                    <div><dt>Reviewed by</dt><dd>{{ $c->reviewer->full_name ?? '—' }}</dd></div>
                    <div><dt>Signed by</dt><dd>{{ $c->signed_at ? ($c->signatory->full_name ?? 'Director') : '—' }}</dd></div>
                </dl>
            </section>

            <section class="rec-panel">
                <h2 class="rec-panel__title">History</h2>
                <ol class="rec-timeline">
                    <li class="rec-timeline__item rec-timeline__item--done">
                        <p class="rec-timeline__title">Request lodged</p>
                        @if ($c->creator)<p class="rec-timeline__text">{{ $c->creator->full_name }}</p>@endif
                        <time class="rec-timeline__when" title="{{ $c->created_at?->format('d M Y, H:i') }}">{{ $c->created_at?->diffForHumans() }}</time>
                    </li>
                    @if ($c->reviewed_at)
                        <li class="rec-timeline__item rec-timeline__item--done">
                            <p class="rec-timeline__title">Reviewed</p>
                            @if ($c->reviewer)<p class="rec-timeline__text">{{ $c->reviewer->full_name }}</p>@endif
                            <time class="rec-timeline__when" title="{{ $c->reviewed_at->format('d M Y, H:i') }}">{{ $c->reviewed_at->diffForHumans() }}</time>
                        </li>
                    @endif
                    @if ($c->signed_at)
                        <li class="rec-timeline__item rec-timeline__item--done">
                            <p class="rec-timeline__title">Approved and signed</p>
                            <p class="rec-timeline__text">{{ $c->signatory->full_name ?? 'Director' }}</p>
                            <time class="rec-timeline__when" title="{{ $c->signed_at->format('d M Y, H:i') }}">{{ $c->signed_at->diffForHumans() }}</time>
                        </li>
                    @elseif ($c->status === 'rejected')
                        <li class="rec-timeline__item rec-timeline__item--bad"><p class="rec-timeline__title">Rejected</p></li>
                    @elseif ($awaitingReview)
                        <li class="rec-timeline__item rec-timeline__item--{{ $days > 14 ? 'bad' : ($days > 7 ? 'warn' : 'now') }}">
                            <p class="rec-timeline__title">Awaiting review</p>
                            <p class="rec-timeline__text">{{ $days === 0 ? 'Lodged today' : 'Waiting ' . $days . ' ' . \Illuminate\Support\Str::plural('day', $days) }}</p>
                        </li>
                    @elseif ($c->status === 'reviewed')
                        <li class="rec-timeline__item rec-timeline__item--now"><p class="rec-timeline__title">Awaiting signature</p></li>
                    @endif
                </ol>
            </section>
        </aside>
    </div>
</div>

{{-- Review --}}
@if ($canReview)
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" action="{{ route('consultancy.review', $c->id) }}" method="POST">
            @csrf
            <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="reviewTitle">Review consultation</h5>
                    <p class="mb-0 small text-muted">{{ $c->applicant_name }} · {{ $c->consultation_type_label }}</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label" for="rv-guidance">Islamic guidance <span class="text-danger">*</span></label>
                    <textarea id="rv-guidance" name="islamic_guidance" class="form-control" rows="5" required placeholder="The ruling or guidance on this matter"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="rv-rec">Recommendation</label>
                    <textarea id="rv-rec" name="recommendation" class="form-control" rows="3" placeholder="What the applicant should do"></textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6"><label class="form-label" for="rv-cond">Conditions</label><textarea id="rv-cond" name="conditions" class="form-control" rows="2"></textarea></div>
                    <div class="col-md-6"><label class="form-label" for="rv-restr">Restrictions</label><textarea id="rv-restr" name="restrictions" class="form-control" rows="2"></textarea></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4"><label class="form-label" for="rv-q">Qur’an reference</label><input id="rv-q" type="text" name="quran_reference" class="form-control" placeholder="e.g. 2:183"></div>
                    <div class="col-md-4"><label class="form-label" for="rv-h">Hadith reference</label><input id="rv-h" type="text" name="hadith_reference" class="form-control" placeholder="e.g. Sahih al-Bukhari 1"></div>
                    <div class="col-md-4"><label class="form-label" for="rv-s">Scholar reference</label><input id="rv-s" type="text" name="scholar_reference" class="form-control"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit review</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Change status --}}
@if ($canChange)
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form class="modal-content" action="{{ route('consultancy.status', $c->id) }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="statusTitle">Change status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="small text-muted mb-3">{{ $c->application_id }} is currently <strong>{{ $c->status_label }}</strong>.</p>
                <label class="form-label" for="st-new">New status <span class="text-danger">*</span></label>
                <select id="st-new" name="status" class="form-select" required>
                    <option value="">Select a status</option>
                    @foreach (['submitted' => 'Submitted', 'under_review' => 'Under review', 'reviewed' => 'Reviewed', 'approved' => 'Approved', 'rejected' => 'Rejected', 'accomplished' => 'Accomplished'] as $v => $l)
                        <option value="{{ $v }}" @selected($v === $c->status)>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update status</button>
            </div>
        </form>
    </div>
</div>
@endif

<script src="{{ asset('js/umsc-records.js') }}" defer></script>
<script>
    // Forms marked data-confirm ask first, using the shared dialog when present.
    document.addEventListener('submit', function (e) {
        var f = e.target.closest('form[data-confirm]');
        if (!f || f.dataset.confirmed) return;
        e.preventDefault();
        var go = function () { f.dataset.confirmed = '1'; f.submit(); };
        if (window.UMSC && UMSC.confirm) {
            UMSC.confirm({ title: f.dataset.confirm, confirmText: f.dataset.confirmText || 'Confirm', cancelText: 'Cancel', danger: !!f.dataset.danger })
                .then(function (ok) { if (ok) go(); });
        } else if (window.confirm(f.dataset.confirm)) { go(); }
    });
</script>
@endsection
