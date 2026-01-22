<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchIndex extends Model
{
    protected $table = 'search_index';

    protected $fillable = [
        'module',
        'application_id',
        'title',
        'keywords',
        'reference_id',
        'status',
        'application_date',
        'required_role',
    ];
}

