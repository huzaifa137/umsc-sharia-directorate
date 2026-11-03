@props(['status', 'label' => null])
@php
    // One mapping for every module's status words. Unknown values fall back to a neutral pill.
    $key = strtolower(trim((string) $status));
    $map = [
        'draft' => ['idle', 'Draft'],
        'submitted' => ['info', 'Submitted'],
        'pending' => ['warn', 'Pending'],
        'under_review' => ['warn', 'Under review'],
        'reviewed' => ['info', 'Reviewed'],
        'approved' => ['ok', 'Approved'],
        'accomplished' => ['ok', 'Completed'],
        'completed' => ['ok', 'Completed'],
        'active' => ['ok', 'Active'],
        'rejected' => ['bad', 'Rejected'],
        'suspended' => ['bad', 'Suspended'],
        'banned' => ['bad', 'Banned'],
        'inactive' => ['idle', 'Inactive'],
    ];
    [$tone, $text] = $map[$key] ?? ['idle', \Illuminate\Support\Str::headline($key ?: 'Unknown')];
@endphp
<span {{ $attributes->class(['ui-status', 'ui-status--' . $tone]) }}>{{ $label ?? $text }}</span>
