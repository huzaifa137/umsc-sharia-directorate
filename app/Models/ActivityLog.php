<?php

namespace App\Models;

use App\Services\AccessControl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_role',
        'action',
        'target_type',
        'target_id',
        'status',
        'ip_address',
        'user_agent',
        'old_values',
        'new_values',
        'description',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Limit the log to what the signed-in officer may see: everything for
     * full-access roles, otherwise only their own actions and those of the
     * accounts below them that they are allowed to manage.
     */
    public function scopeVisibleToOfficer(Builder $query): Builder
    {
        if (AccessControl::hasFullAccess()) {
            return $query;
        }

        $me = AccessControl::user();

        if (!$me) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $q) use ($me) {
            $q->where('user_id', $me->id)
                ->orWhereIn('user_id', AccessControl::visibleUsersQuery()->select('users.id'));
        });
    }

    /** Failed attempts are stored as "fail" by the login flow and "failed" elsewhere. */
    public function getIsFailureAttribute(): bool
    {
        return in_array(strtolower((string) $this->status), ['fail', 'failed', 'error'], true);
    }
}
