<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'user_role',
        'role_id',
        'account_status',
        'registration_status',
        'firstname',
        'lastname',
        'gender',
        'phonenumber',
        'country',
        'region',
        'district',
        'county',
        'mosque_name',
        'deputy_name',
        'deputy_contact',
        'created_by',
        'must_change_password',
        'bulk_imported',
        'generated_password',
        'last_login_at',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
        'must_change_password' => 'boolean',
        'bulk_imported' => 'boolean',
    ];

    /**
     * These computed attributes are appended automatically whenever a User
     * model is sent back as JSON (e.g. the "view"/"edit" AJAX modals), so the
     * front-end never has to re-implement the role/status label mapping.
     */
    protected $appends = [
        'role_name',
        'role_slug',
        'role_color',
        'account_status_text',
        'registration_status_text',
        'full_name',
        'credentials_status',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdAccounts()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function getFullNameAttribute(): string
    {
        return trim(($this->firstname ?? '') . ' ' . ($this->lastname ?? ''));
    }

    public function getRoleNameAttribute(): ?string
    {
        return $this->role?->name;
    }

    public function getRoleSlugAttribute(): ?string
    {
        return $this->role?->slug;
    }

    public function getRoleColorAttribute(): string
    {
        return $this->role?->color ?? '#00580f';
    }

    public function getAccountStatusTextAttribute(): string
    {
        return match ((int) $this->account_status) {
            10 => 'Active',
            0 => 'Banned',
            9 => 'Suspended',
            8 => 'Locked',
            default => 'Pending',
        };
    }

    public function getRegistrationStatusTextAttribute(): string
    {
        return $this->registration_status == 1 ? 'Registration Complete' : 'Registration Incomplete';
    }

    /**
     * "pending"  -> account still has its system-generated password
     * "updated"  -> a bulk-imported account whose owner has since changed it
     * null       -> not applicable (account was never system-generated)
     */
    public function getCredentialsStatusAttribute(): ?string
    {
        if (!$this->bulk_imported) {
            return null;
        }

        return $this->generated_password ? 'pending' : 'updated';
    }

    /**
     * Does this user's role carry the given permission slug? e.g. "users.create".
     * This is intentionally a separate method from Laravel's native can() (which
     * is reserved for Gates/Policies) to avoid any ambiguity.
     */
    public function hasPermission(string $slug): bool
    {
        if (!$this->relationLoaded('role')) {
            $this->load('role.permissions');
        }

        return $this->role?->hasPermission($slug) ?? false;
    }

    /**
 * Add this relationship to your existing app/Models/User.php,
 * next to the role()/creator() relations.
 */

public function conversations()
{
    return $this->belongsToMany(Conversation::class, 'conversation_participants')
        ->withPivot(['is_admin', 'last_read_at', 'joined_at', 'left_at'])
        ->withTimestamps();
}

// Don't forget the import at the top of the file:
// use App\Models\Conversation;

}