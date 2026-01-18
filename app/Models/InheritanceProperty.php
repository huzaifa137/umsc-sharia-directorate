<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InheritanceProperty extends Model
{
    protected $fillable = [
        'inheritance_application_id',
        'type',
        'description',
        'value',
        'location',
    ];

    public function application()
    {
        return $this->belongsTo(InheritanceApplication::class);
    }
}
