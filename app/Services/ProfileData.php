<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Throwable;

/**
 * Everything the "My profile" page shows, in one place so the view stays markup only.
 * Read-only: nothing here changes data, and a failed query degrades to an empty section
 * instead of an error page.
 */
class ProfileData
{
    public static function for(?User $u): array
    {
        if (!$u) {
            return ['available' => false];
        }

        $role = $u->role;
        $scope = $role?->data_scope ?? 'self';
        $name = $u->full_name ?: $u->username;

        return [
            'available' => true,
            'name' => $name,
            'initial' => mb_strtoupper(mb_substr($name ?: '?', 0, 1)),
            'role' => $u->role_name ?: 'Officer',
            'scope' => $role ? $role->visibilityLabel() : 'Own records only',
            'jurisdiction' => self::jurisdiction($u, $scope),
            'mosque' => $u->mosque_name,
            'last_login' => $u->last_login_at,
            'member_since' => $u->created_at,
            'must_change' => (bool) $u->must_change_password,
            'recent' => self::safe(fn () => self::recent($u), collect()),
            'actions_30' => self::safe(fn () => ActivityLog::where('user_id', $u->id)
                ->where('created_at', '>=', now()->subDays(30))->count(), null),
        ];
    }

    /** Account status as the three tones the UI knows. */
    public static function status($code): array
    {
        return match ((int) $code) {
            10 => ['Active', 'ok'],
            9 => ['Suspended', 'warn'],
            8 => ['Locked', 'bad'],
            0 => ['Banned', 'bad'],
            default => ['Unknown', 'idle'],
        };
    }

    private static function recent(User $u)
    {
        return ActivityLog::where('user_id', $u->id)->latest('id')->limit(8)
            ->get(['id', 'action', 'target_type', 'target_id', 'status', 'description', 'created_at']);
    }

    private static function jurisdiction(User $u, string $scope): string
    {
        return match ($scope) {
            'region' => (string) $u->region,
            'district' => trim($u->district . ($u->region ? ', ' . $u->region : ''), ', '),
            'county', 'self' => trim(implode(', ', array_filter([$u->county, $u->district])), ', '),
            default => '',
        };
    }

    private static function safe(callable $fn, $fallback)
    {
        try {
            return $fn();
        } catch (Throwable $e) {
            report($e);
            return $fallback;
        }
    }
}
