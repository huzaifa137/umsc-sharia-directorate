<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InheritanceApplication extends Model
{
    protected $fillable = [
        'application_id',
        'status',
        'deceased_name',
        'gender',
        'date_of_death',
        'place_of_death',
        'cause_of_death',
        'deceased_nin',
        'marital_status',
        'occupation',
        'last_residence',
        'applicant_name',
        'relationship',
        'applicant_nin',
        'applicant_phone',
        'total_estate_value',
        'outstanding_debts',
        'funeral_expenses',
        'unpaid_zakat',
        'other_liabilities',
        'death_certificate_path',
    ];

    public function properties()
    {
        return $this->hasMany(InheritanceProperty::class);
    }

    public function heirs()
    {
        return $this->hasOne(InheritanceHeir::class);
    }

    public function verification()
    {
        return $this->hasOne(InheritanceVerification::class);
    }
}
