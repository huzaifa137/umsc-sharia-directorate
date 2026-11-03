<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ActivityLogController extends Controller
{
    private const PER_PAGE = 25;
    private const EXPORT_LIMIT = 5000;

    public function index(Request $request)
    {
        $filters = $this->filters($request);

        $base = ActivityLog::query()->visibleToOfficer();

        $logs = $this->applyFilters((clone $base), $filters)
            ->with('user')
            ->orderByDesc('id')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        $stats = [
            'today' => (clone $base)->where('created_at', '>=', now()->startOfDay())->count(),
            'failed' => (clone $base)->where('created_at', '>=', now()->subDays(7))
                ->whereIn('status', ['fail', 'failed', 'error'])->count(),
            'officers' => (clone $base)->where('created_at', '>=', now()->subDays(7))
                ->whereNotNull('user_id')->distinct()->count('user_id'),
            'matching' => $logs->total(),
        ];

        $actions = (clone $base)->select('action')->distinct()->orderBy('action')->limit(80)->pluck('action');

        return view('admin.activity-logs', compact('logs', 'filters', 'stats', 'actions'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filters = $this->filters($request);

        $query = $this->applyFilters(ActivityLog::query()->visibleToOfficer(), $filters)
            ->with('user')
            ->orderByDesc('id')
            ->limit(self::EXPORT_LIMIT);

        Helper::auditTrail(
            'Activity Log Exported (CSV)',
            'Report',
            null,
            'success',
            null,
            array_filter($filters),
            'Exported the activity log as CSV.'
        );

        $filename = 'activity-log-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // UTF-8 BOM so Excel opens Arabic names correctly
            fputcsv($out, ['Time', 'Officer', 'Role', 'Action', 'Target', 'Target ID', 'Result', 'IP address', 'Description']);

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $log) {
                    fputcsv($out, array_map([self::class, 'safeCell'], [
                        optional($log->created_at)->format('Y-m-d H:i:s'),
                        $log->user?->full_name ?: ($log->user_id ? 'User #' . $log->user_id : 'System'),
                        $log->user_role,
                        $log->action,
                        $log->target_type,
                        $log->target_id,
                        $log->is_failure ? 'Failed' : 'Success',
                        $log->ip_address,
                        $log->description,
                    ]));
                }
            });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** Stops spreadsheet apps from treating a cell as a formula. */
    public static function safeCell($value)
    {
        $value = (string) $value;

        return $value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true) ? "'" . $value : $value;
    }

    private function filters(Request $request): array
    {
        $request->validate([
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
            'status' => 'nullable|in:success,fail',
            'q' => 'nullable|string|max:100',
            'action' => 'nullable|string|max:120',
        ]);

        return [
            'q' => trim((string) $request->query('q', '')),
            'action' => (string) $request->query('action', ''),
            'status' => (string) $request->query('status', ''),
            'date_from' => (string) $request->query('date_from', ''),
            'date_to' => (string) $request->query('date_to', ''),
        ];
    }

    private function applyFilters($query, array $f)
    {
        if ($f['q'] !== '') {
            $like = '%' . str_replace(['%', '_'], ['\%', '\_'], $f['q']) . '%';
            $query->where(function ($q) use ($like) {
                $q->where('description', 'like', $like)
                    ->orWhere('action', 'like', $like)
                    ->orWhere('ip_address', 'like', $like)
                    ->orWhereHas('user', function ($u) use ($like) {
                        $u->where('username', 'like', $like)
                            ->orWhere('firstname', 'like', $like)
                            ->orWhere('lastname', 'like', $like);
                    });
            });
        }

        if ($f['action'] !== '') {
            $query->where('action', $f['action']);
        }

        if ($f['status'] === 'fail') {
            $query->whereIn('status', ['fail', 'failed', 'error']);
        } elseif ($f['status'] === 'success') {
            $query->whereNotIn('status', ['fail', 'failed', 'error']);
        }

        if ($f['date_from'] !== '') {
            $query->where('created_at', '>=', $f['date_from'] . ' 00:00:00');
        }

        if ($f['date_to'] !== '') {
            $query->where('created_at', '<=', $f['date_to'] . ' 23:59:59');
        }

        return $query;
    }
}
