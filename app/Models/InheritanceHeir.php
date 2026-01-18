<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InheritanceHeir extends Model
{
    protected $fillable = [
        'inheritance_application_id',
        'spouse_name',
        'spouse_nin',
        'sons_count',
        'daughters_count',
        'father_alive',
        'father_name',
        'mother_alive',
        'mother_name',
        'full_brothers',
        'full_sisters',
        'uterine_brothers',
        'uterine_sisters',
        'pregnant_heir',
        'minor_heirs',
    ];

    protected $casts = [
        'father_alive' => 'boolean',
        'mother_alive' => 'boolean',
        'pregnant_heir' => 'boolean',
        'minor_heirs' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(InheritanceApplication::class);
    }
}

