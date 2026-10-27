<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkImportBatch extends Model
{
    protected $fillable = [
        'type',
        'original_filename',
        'total_rows',
        'created_count',
        'duplicate_count',
        'error_count',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function rows()
    {
        return $this->hasMany(BulkImportRow::class, 'batch_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the display name for the import type
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'imaam_directory' => 'Imaam Directory',
            'district_khadhi' => 'District Khadhi',
            'regional_assistant' => 'Regional Assistant',
            default => ucwords(str_replace('_', ' ', $this->type)),
        };
    }

    /**
     * Get the icon for the import type
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'imaam_directory' => '🕌',
            'district_khadhi' => '⚖️',
            'regional_assistant' => '📍',
            default => '📄',
        };
    }
}