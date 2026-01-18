<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InheritanceVerification extends Model
{
    protected $fillable = [
        'inheritance_application_id',
        'imam_name',
        'imam_reg_number',
        'mosque_name',
        'verification_date',
        'verification_notes',
    ];

    public function application()
    {
        return $this->belongsTo(InheritanceApplication::class);
    }
}

