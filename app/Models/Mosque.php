<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    protected $fillable = [
        'region',
        'district',
        'county',
        'name',
        'location',
        'imaam_name',
        'imaam_contact',
        'deputy_imaam_name',
        'deputy_imaam_contact',
        'imaam_user_id',
        'imported_batch_id',
    ];

    public function imaamUser()
    {
        return $this->belongsTo(User::class, 'imaam_user_id');
    }

    public function batch()
    {
        return $this->belongsTo(BulkImportBatch::class, 'imported_batch_id');
    }
}
