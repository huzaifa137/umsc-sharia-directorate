<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BulkImportRow extends Model
{
    protected $fillable = [
        'batch_id',
        'row_number',
        'status',
        'message',
        'payload',
        'created_user_id',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function batch()
    {
        return $this->belongsTo(BulkImportBatch::class, 'batch_id');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }
}
