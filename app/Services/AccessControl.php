<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

/**
 * Central place for every "who can see/do what" decision in the system.
 *
 * The role hierarchy is driven entirely by data (the `roles` table), not by
 * hard-coded ids, so the Director can create brand new roles from the Roles
 * & Privileges module and this class will respect them automatically.
 *
 *  - data_scope = self     -> sees only records they personally registered
 *  - data_scope = county   -> sees their own + everything registered by
 *                             Imaams stationed in the same county
 *  - data_scope = district -> sees their own + everything registered by
 *                             County Sheikhs/Imaams stationed in the same district
 *  - data_scope = region   -> sees their own + everything registered by
 *                             District Khadhis/County Sheikhs/Imaams stationed
 *                             in the same region (Regional Assistant)
 *  - data_scope = global   -> sees everything (Director Sharia & full-access staff)
 */
class AccessControl
{
    protected static ?User $cachedUser = null;
    protected static bool $resolved = false;

    /**
     * Who is allowed to CREATE an account of which role. This is deliberately
     * NOT "any role ranked below mine" — the org chart skips levels on
     * purpose: a Regional Assistant may onboard County Sheikhs and Imaams
     * directly but never a District Khadhi, and a District Khadhi may only
     * onboard Imaams (never a County Sheikh). The Director (full_access)
     * bypasses this map entirely and can create any role, including custom
     * ones added later from Roles & Privileges — this map only covers the
     * four fixed system roles below Director.
     */
    private const CREATABLE_ROLES = [
        'regional_assistant' => ['county_sheikh', 'imaam'],
        'district_khadhi' => ['imaam'],
    ];

    /**
     * The currently authenticated back-office user, or null if no one is
     * logged in. Cached for the lifetime of the request.
     */
    public static function user(): ?User
    {
        if (self::$resolved) {
            return self::$cachedUser;
        }

        self::$resolved = true;
        $id = Session::get('LoggedAdmin');

        if (!$id) {
            return self::$cachedUser = null;
        }

        return self::$cachedUser = User::with('role.permissions')->find($id);
    }

    public static function role(): ?Role
    {
        return self::user()?->role;
    }

    public static function hasFullAccess(): bool
    {
        return (bool) self::role()?->full_access;
    }

    public static function isDirector(): bool
    {
        return self::role()?->slug === 'director';
    }

    /**
     * Check a single permission slug, e.g. "nikah.create", "roles.manage".
     */
    public static function can(string $slug): bool
    {
        $user = self::user();

        if (!$user) {
            return false;
        }

        if (self::hasFullAccess()) {
            return true;
        }

        return $user->role?->hasPermission($slug) ?? false;
    }

    public static function canAny(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if (self::can($slug)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Restrict an application listing query (Nikah/Divorce/Inheritance/
     * Guardianship/Convert) to whatever the current user is allowed to see.
     */
    public static function scopeApplications(Builder $query): Builder
    {
        $user = self::user();

        if (!$user || self::hasFullAccess()) {
            return $query;
        }

        $scope = $user->role?->data_scope ?? 'self';

        return match ($scope) {
            'global' => $query,
            'region' => $query->where('officer_region', $user->region),
            'district' => $query->where('officer_district', $user->district),
            'county' => $query->where('officer_county', $user->county),
            default => $query->where('created_by', $user->id),
        };
    }

    /**
     * The created_by / officer_district / officer_county values that should
     * be stamped onto a new application record on behalf of the logged in
     * officer. Merge this into the data array before create().
     */
    public static function officerStamp(): array
    {
        $user = self::user();

        return [
            'created_by' => $user?->id,
            'officer_region' => $user?->region,
            'officer_district' => $user?->district,
            'officer_county' => $user?->county,
        ];
    }

    /**
     * Roles the current user is allowed to assign to a brand new account.
     * - Full-access roles (Director) can hand out any role.
     * - Everyone else can only hand out roles ranked below their own.
     */
    public static function assignableRoles()
    {
        $user = self::user();

        if (!$user || !$user->hasPermission('users.create')) {
            return Role::query()->whereRaw('1 = 0')->get();
        }

        if (self::hasFullAccess()) {
            return Role::orderByDesc('level')->get();
        }

        $creatableSlugs = self::CREATABLE_ROLES[$user->role?->slug ?? ''] ?? [];

        if (empty($creatableSlugs)) {
            return Role::query()->whereRaw('1 = 0')->get();
        }

        return Role::whereIn('slug', $creatableSlugs)->orderByDesc('level')->get();
    }

    public static function canCreateRole(Role $role): bool
    {
        $user = self::user();

        if (!$user || !$user->hasPermission('users.create')) {
            return false;
        }

        if (self::hasFullAccess()) {
            return true;
        }

        $creatableSlugs = self::CREATABLE_ROLES[$user->role?->slug ?? ''] ?? [];

        return in_array($role->slug, $creatableSlugs, true);
    }

    /**
     * Can the current user edit / suspend / ban / unsuspend / delete the
     * given target account?
     */
    public static function canManageUser(User $target): bool
    {
        $user = self::user();

        if (!$user) {
            return false;
        }

        if (self::hasFullAccess()) {
            return true;
        }

        if (!$user->hasPermission('users.edit') && !$user->hasPermission('users.suspend')
            && !$user->hasPermission('users.ban') && !$user->hasPermission('users.delete')) {
            return false;
        }

        $myLevel = $user->role?->level ?? 0;
        $targetLevel = $target->role?->level ?? 0;

        if ($targetLevel >= $myLevel) {
            return false;
        }

        $scope = $user->role?->data_scope;

        if ($scope === 'region' && $target->region !== $user->region) {
            return false;
        }

        if ($scope === 'district' && $target->district !== $user->district) {
            return false;
        }

        if ($scope === 'county' && $target->county !== $user->county) {
            return false;
        }

        return true;
    }

    /**
     * Users the current user is allowed to see in the Manage Users list.
     */
    public static function visibleUsersQuery(): Builder
    {
        $user = self::user();
        $query = User::query()->with('role');

        if (!$user) {
            return $query->whereRaw('1 = 0');
        }

        if (self::hasFullAccess()) {
            return $query;
        }

        $level = $user->role?->level ?? 0;
        $scope = $user->role?->data_scope;

        $query->whereHas('role', fn ($r) => $r->where('level', '<', $level));

        if ($scope === 'region') {
            $query->where('region', $user->region);
        } elseif ($scope === 'district') {
            $query->where('district', $user->district);
        } elseif ($scope === 'county') {
            $query->where('county', $user->county);
        }

        return $query;
    }
}