<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'data_scope',
        'level',
        'is_system',
        'full_access',
        'color',
        'icon',
        'created_by',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'full_access' => 'boolean',
        'level' => 'integer',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permission')->withTimestamps();
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Does this role carry the given permission slug? `full_access` roles
     * (the Director Sharia by default) always answer true.
     */
    public function hasPermission(string $slug): bool
    {
        if ($this->full_access) {
            return true;
        }

        return $this->permissions->contains('slug', $slug);
    }

    public function visibilityLabel(): string
    {
        return match ($this->data_scope) {
            'self' => 'Own records only',
            'county' => 'County-wide',
            'district' => 'District-wide',
            'region' => 'Region-wide',
            'global' => 'Entire system',
            default => ucfirst($this->data_scope),
        };
    }
}
