<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Services\AccessControl;
use App\Services\RecordSchema;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One full-page record view for Nikah, Divorce, Inheritance, Guardianship and
 * Convert. Read-only: every edit and status change still goes through the
 * existing routes. Access follows the same rules as the lists, so a record
 * outside the officer's jurisdiction is a 404 rather than a leak.
 */
class RecordController extends Controller
{
    public function show(string $module, int $id)
    {
        abort_unless(RecordSchema::has($module), 404);
        abort_unless(AccessControl::can("{$module}.view"), 403);

        $def = RecordSchema::for($module);

        $query = $def['model']::query();
        if (!empty($def['with'])) {
            $query->with($def['with']);
        }
        $record = AccessControl::scopeApplications($query)->findOrFail($id);

        Helper::auditTrail(
            'view',
            class_basename($def['model']),
            $record->id,
            'success',
            null,
            null,
            "Viewed {$def['label']} record " . $record->application_id
        );

        $statusKey = strtolower((string) $record->status);
        $options = $def['status']['options'];
        $pendingKey = array_key_first($options);
        $isPending = $statusKey === $pendingKey;
        $isDone = in_array($statusKey, $def['status']['done'], true);

        $canDecide = AccessControl::can("{$module}.approve");
        $canCertificate = $isDone && AccessControl::can('certificates.view') && !empty($def['certificate']);
        $canEdit = !empty($def['edit']) && AccessControl::can("{$module}.edit");

        $sections = [];
        $filled = 0;
        $total = 0;
        foreach ($def['sections'] as $section) {
            $built = $this->buildSection($record, $section);
            $filled += $built['filled'];
            $total += $built['total'];
            $sections[] = $built;
        }

        $title = trim((string) ($def['title'])($record)) ?: 'Unnamed record';

        $facts = collect(($def['facts'])($record))
            ->filter(fn ($f) => filled($f[1]))
            ->values()
            ->all();

        return view('records.show', [
            'module' => $module,
            'def' => $def,
            'record' => $record,
            'title' => $title,
            'facts' => $facts,
            'sections' => $sections,
            'completeness' => ['filled' => $filled, 'total' => $total, 'pct' => $total ? (int) round($filled / $total * 100) : 0],
            'files' => $this->buildFiles($record, $def['files']),
            'status' => [
                'key' => $statusKey,
                'label' => $options[$statusKey] ?? Str::headline($statusKey ?: 'Unknown'),
                'options' => $options,
                'pending' => $isPending,
                'done' => $isDone,
                'offer' => collect($def['status']['offer'] ?? array_keys($options))
                    ->reject(fn ($k) => $k === $statusKey)
                    ->map(fn ($k) => [
                        'value' => $k,
                        'label' => $options[$k] ?? Str::headline($k),
                        'tone' => in_array($k, $def['status']['done'], true) ? 'ok' : ($k === 'rejected' ? 'bad' : 'idle'),
                    ])->values()->all(),
                'endpoint' => url(str_replace('{id}', (string) $record->id, $def['status']['url'])),
            ],
            'can' => [
                'decide' => $canDecide,
                'certificate' => $canCertificate,
                'edit' => $canEdit,
            ],
            'urls' => [
                'list' => url($def['list']),
                'dashboard' => url($def['dashboard']),
                'certificate' => $canCertificate ? url("certificates/{$def['certificate']}/{$record->id}/preview") : null,
                'edit' => $canEdit ? url(str_replace('{id}', (string) $record->id, $def['edit'])) : null,
            ],
            'case' => $this->caseFile($record, $isPending),
            'timeline' => $this->timeline($record, $def, $isPending),
        ]);
    }

    /** Turn one schema section into rows the view can print without any logic. */
    private function buildSection($record, array $section): array
    {
        $out = ['id' => $section['id'], 'title' => $section['title'], 'type' => 'fields', 'rows' => [], 'groups' => [], 'table' => null, 'filled' => 0, 'total' => 0];

        $count = function (array $rows) use (&$out) {
            foreach ($rows as $r) {
                $out['total']++;
                if ($r['text'] !== null) {
                    $out['filled']++;
                }
            }
        };

        // Related collection shown as a table (inheritance properties).
        if (!empty($section['relation']) && !empty($section['columns'])) {
            $out['type'] = 'table';
            $items = $record->{$section['relation']} ?? collect();
            $head = array_map(fn ($c) => $c[0], $section['columns']);
            $body = [];
            foreach ($items as $item) {
                $body[] = array_map(fn ($c) => RecordSchema::read($item, $c)['text'], $section['columns']);
            }
            $out['table'] = ['head' => $head, 'body' => $body, 'count' => count($body)];
            $out['filled'] = count($body) ? 1 : 0;
            $out['total'] = 1;

            return $out;
        }

        // Related single record (inheritance heirs, verification).
        if (!empty($section['relation']) && !empty($section['single'])) {
            $related = $record->{$section['relation']};
            $rows = $related ? array_map(fn ($f) => $this->row($related, $f), $section['fields']) : [];
            $out['rows'] = $rows;
            $count($rows);
            if (!$related) {
                $out['total'] = 1;
            }

            return $out;
        }

        if (!empty($section['groups'])) {
            $out['type'] = 'groups';
            foreach ($section['groups'] as [$label, $fields]) {
                $rows = array_map(fn ($f) => $this->row($record, $f), $fields);
                $count($rows);
                $out['groups'][] = ['label' => $label, 'rows' => $rows];
            }

            return $out;
        }

        $rows = array_map(fn ($f) => $this->row($record, $f), $section['fields']);
        $count($rows);
        $out['rows'] = $rows;

        return $out;
    }

    private function row($source, array $field): array
    {
        $r = RecordSchema::read($source, $field);

        $r['masked'] = null;
        if ($r['kind'] === 'nin' && $r['text'] !== null) {
            $n = (string) $r['text'];
            $r['masked'] = strlen($n) > 6
                ? substr($n, 0, 3) . str_repeat('•', max(strlen($n) - 6, 3)) . substr($n, -3)
                : str_repeat('•', strlen($n));
        }

        return $r;
    }

    private function buildFiles($record, array $defs): array
    {
        $files = [];
        foreach ($defs as [$label, $column, $kind]) {
            $path = trim((string) ($record->{$column} ?? ''));
            if ($path === '') {
                continue;
            }

            $exists = true;
            try {
                $exists = Storage::disk('public')->exists($path);
            } catch (\Throwable $e) {
                // A storage hiccup shouldn't hide the link; the browser will say if it 404s.
            }

            $files[] = [
                'label' => $label,
                'kind' => $kind,
                'name' => basename($path),
                'ext' => strtoupper(pathinfo($path, PATHINFO_EXTENSION)),
                'url' => asset('storage/' . ltrim($path, '/')),
                'exists' => $exists,
            ];
        }

        return $files;
    }

    private function caseFile($record, bool $isPending): array
    {
        $creator = null;
        try {
            $creator = $record->creator?->full_name ?? null;
        } catch (\Throwable $e) {
        }

        return [
            'reference' => $record->application_id ?: ('#' . $record->id),
            'lodged' => $record->created_at?->format('d M Y, H:i'),
            'updated' => $record->updated_at && $record->created_at && $record->updated_at->gt($record->created_at->copy()->addMinute())
                ? $record->updated_at->format('d M Y, H:i') : null,
            'by' => $creator,
            'region' => $record->officer_region,
            'district' => $record->officer_district,
            'county' => $record->officer_county,
            'waiting' => $isPending && $record->created_at ? (int) $record->created_at->diffInDays(now()) : null,
        ];
    }

    /** Oldest first: lodged, then recorded actions, then where it stands now. */
    private function timeline($record, array $def, bool $isPending): array
    {
        $events = [];

        $events[] = [
            'tone' => 'done',
            'title' => 'Application lodged',
            'text' => trim(($record->creator?->full_name ?? '') . ' ' . ($record->officer_district ? '· ' . $record->officer_district : '')),
            'at' => $record->created_at,
        ];

        if (AccessControl::can('activity_logs.view') && Schema::hasTable('activity_logs')) {
            $logs = ActivityLog::query()
                ->where('target_type', class_basename($def['model']))
                ->where('target_id', $record->id)
                ->where('action', '!=', 'view')
                ->orderBy('created_at')
                ->limit(25)
                ->get();

            foreach ($logs as $log) {
                $failed = in_array(strtolower((string) $log->status), ['failed', 'failure', 'error', 'denied'], true);
                $events[] = [
                    'tone' => $failed ? 'bad' : 'done',
                    'title' => Str::headline((string) $log->action),
                    'text' => trim(($log->user_role ? $log->user_role . ' · ' : '') . ($log->description ?? '')),
                    'at' => $log->created_at,
                ];
            }
        }

        if ($isPending) {
            $days = $record->created_at ? (int) $record->created_at->diffInDays(now()) : 0;
            $events[] = [
                'tone' => $days > 14 ? 'bad' : ($days > 7 ? 'warn' : 'now'),
                'title' => 'Awaiting a decision',
                'text' => $days === 0 ? 'Lodged today' : "Waiting {$days} " . Str::plural('day', $days),
                'at' => null,
            ];
        }

        return array_map(function ($e) {
            $e['when'] = $e['at']?->format('d M Y, H:i');
            $e['ago'] = $e['at']?->diffForHumans();
            unset($e['at']);

            return $e;
        }, $events);
    }
}
