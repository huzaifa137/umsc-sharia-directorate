<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        // Ward Details
        'application_id',
        'ward_name',
        'ward_gender',
        'ward_dob',
        'ward_age',
        'birth_certificate_number',
        'ward_type',
        'guardianship_type',
        'health_conditions',
        'ward_education_level',
        'ward_photo_path',
        
        // Parental Information
        'father_name',
        'father_status',
        'mother_name',
        'mother_status',
        'birth_certificate_path',
        
        // Guardian Applicant Details
        'guardian_name',
        'guardian_gender',
        'guardian_dob',
        'guardian_nin',
        'relationship_to_ward',
        'guardian_phone',
        'guardian_address',
        'previous_experience',
        'criminal_record',
        'health_status',
        'religious_background',
        'motivation',
        'guardian_photo_path',
        
        // Guardianship Terms
        'guardianship_duration',
        'reporting_frequency',
        'powers_granted',
        'restrictions',
        
        // Verification
        'imam_name',
        'imam_reg_number',
        'mosque_name',
        
        // Witnesses
        'witness1_name',
        'witness1_nin',
        'witness2_name',
        'witness2_nin',
        
        // Status
        'status',
    ];

    protected $casts = [
        'ward_dob' => 'date',
        'guardian_dob' => 'date',
        'powers_granted' => 'array',
    ];
}