@extends('layouts.app')

@section('content')
@php
    $applicant = [
        ['applicant_name',       'Full name',           'text',  true],
        ['applicant_phone',      'Phone number',        'tel',   true],
        ['applicant_email',      'Email address',       'email', false],
        ['applicant_nin',        'National ID (NIN)',   'text',  false],
        ['applicant_address',    'Residential address', 'text',  false],
        ['applicant_occupation', 'Occupation',          'text',  false],
    ];
    $types = [
        'business' => 'Business & Commerce', 'family' => 'Family Matters', 'financial' => 'Financial & Banking',
        'property' => 'Property & Real Estate', 'employment' => 'Employment & Labor', 'educational' => 'Educational',
        'health' => 'Health & Medical', 'social' => 'Social Issues', 'religious' => 'Religious Matters', 'other' => 'Other',
    ];
@endphp
<div class="container-xxl flex-grow-1 container-p-y">
    <x-ui.page-header title="New consultation request"
        subtitle="Submit a matter for Islamic guidance and consultation."
        :crumbs="['Consultancy' => route('consultancy.dashboard'), 'New request' => null]" />

    <form action="{{ route('consultancy.store') }}" method="POST" enctype="multipart/form-data" class="ui-sheet" id="consultancyForm" novalidate>
        @csrf

        <fieldset class="ui-fieldset">
            <legend>
                <span class="ui-fieldset__n">1</span>
                <span>
                    <strong>Applicant</strong>
                    <small>Who is asking for guidance</small>
                </span>
            </legend>
            <div class="ui-grid">
                @foreach ($applicant as [$name, $label, $type, $required])
                    <div class="ui-field">
                        <label for="{{ $name }}">{{ $label }}@if ($required)<span class="ui-req" aria-hidden="true"> *</span>@endif</label>
                        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name) }}"
                            class="form-control @error($name) is-invalid @enderror" @if ($required) required aria-required="true" @endif>
                        @error($name)<p class="ui-err">{{ $message }}</p>@enderror
                    </div>
                @endforeach
            </div>
        </fieldset>

        <fieldset class="ui-fieldset">
            <legend>
                <span class="ui-fieldset__n">2</span>
                <span>
                    <strong>The matter</strong>
                    <small>What you need guidance on</small>
                </span>
            </legend>
            <div class="ui-grid">
                <div class="ui-field">
                    <label for="consultationType">Consultation type<span class="ui-req" aria-hidden="true"> *</span></label>
                    <select name="consultation_type" id="consultationType" required aria-required="true"
                        class="form-select @error('consultation_type') is-invalid @enderror">
                        <option value="">Select type…</option>
                        @foreach ($types as $value => $text)
                            <option value="{{ $value }}" {{ old('consultation_type') == $value ? 'selected' : '' }}>{{ $text }}</option>
                        @endforeach
                    </select>
                    @error('consultation_type')<p class="ui-err">{{ $message }}</p>@enderror
                </div>

                <div class="ui-field" id="otherTypeContainer" style="display: none;">
                    <label for="consultation_type_other">Please specify</label>
                    <input type="text" id="consultation_type_other" name="consultation_type_other" value="{{ old('consultation_type_other') }}"
                        class="form-control @error('consultation_type_other') is-invalid @enderror" placeholder="Describe the type of matter">
                    @error('consultation_type_other')<p class="ui-err">{{ $message }}</p>@enderror
                </div>

                <div class="ui-field ui-field--full">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                        class="form-control @error('subject') is-invalid @enderror" placeholder="A short title for the consultation">
                    @error('subject')<p class="ui-err">{{ $message }}</p>@enderror
                </div>

                <div class="ui-field ui-field--full">
                    <label for="description">Description of the matter<span class="ui-req" aria-hidden="true"> *</span></label>
                    <textarea id="description" name="description" rows="6" required aria-required="true"
                        class="form-control @error('description') is-invalid @enderror"
                        placeholder="Describe the matter in as much detail as you can.">{{ old('description') }}</textarea>
                    @error('description')<p class="ui-err">{{ $message }}</p>@enderror
                </div>

                <div class="ui-field ui-field--full">
                    <label for="background_info">Background information</label>
                    <textarea id="background_info" name="background_info" rows="4"
                        class="form-control @error('background_info') is-invalid @enderror"
                        placeholder="Anything that was tried before, or context that helps.">{{ old('background_info') }}</textarea>
                    @error('background_info')<p class="ui-err">{{ $message }}</p>@enderror
                </div>
            </div>
        </fieldset>

        <fieldset class="ui-fieldset">
            <legend>
                <span class="ui-fieldset__n">3</span>
                <span>
                    <strong>Supporting document</strong>
                    <small>Optional</small>
                </span>
            </legend>
            <div class="ui-field">
                <label for="attachment">Attach a file</label>
                <input type="file" id="attachment" name="attachment" class="form-control @error('attachment') is-invalid @enderror"
                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <p class="ui-hint">PDF, DOC, DOCX, JPG or PNG. Up to 5 MB.</p>
                @error('attachment')<p class="ui-err">{{ $message }}</p>@enderror
            </div>
        </fieldset>

        <div class="ui-sheet__foot">
            <a href="{{ route('consultancy.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary" id="consultancySubmit">Submit consultation</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var typeSelect = document.getElementById('consultationType');
    var otherContainer = document.getElementById('otherTypeContainer');
    var form = document.getElementById('consultancyForm');
    var submit = document.getElementById('consultancySubmit');

    function toggleOther() {
        otherContainer.style.display = typeSelect.value === 'other' ? 'block' : 'none';
    }
    typeSelect.addEventListener('change', toggleOther);
    toggleOther();

    // Stop a second click from sending the request twice.
    form.addEventListener('submit', function () {
        if (submit.disabled) return;
        submit.disabled = true;
        submit.textContent = 'Submitting…';
    });
});
</script>
@endsection
