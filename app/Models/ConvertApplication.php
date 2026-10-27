<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConvertApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'created_by',
        'officer_region',
        'officer_district',
        'officer_county',
        'former_names',
        'former_religion',
        'date_of_birth',
        'occupation',
        'current_residence',
        'contact',
        'father_name',
        'mother_name',
        'home_address',
        'county',
        'district',
        'new_names',
        'conversion_date',
        'conversion_place',
        'guardian_name',
        'guardian_occupation',
        'guardian_declaration_date',
        'conversion_reasons',
        'guardian_declaration',
        'declaration_date',
        'declaration_agreement',
        'signature',
        'officer_name',
        'officer_position',
        'registration_number',
        'verification_date',
        'officer_remarks',
        'officer_signature',
        'official_stamp',
        'status',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
