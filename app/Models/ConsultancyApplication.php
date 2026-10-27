<?php
// app/Models/ConsultancyApplication.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultancyApplication extends Model
{
    protected $fillable = [
        'application_id',
        'created_by',
        'officer_district',
        'officer_county',
        'officer_region',
        'applicant_name',
        'applicant_phone',
        'applicant_email',
        'applicant_nin',
        'applicant_address',
        'applicant_occupation',
        'consultation_type',
        'consultation_type_other',
        'subject',
        'description',
        'background_info',
        'attachment_path',
        'islamic_guidance',
        'recommendation',
        'conditions',
        'restrictions',
        'quran_reference',
        'hadith_reference',
        'scholar_reference',
        'reviewed_at',
        'reviewed_by',
        'signed_at',
        'signed_by',
        'signature_path',
        'official_stamp_path',
        'status',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'signed_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function signatory()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function getConsultationTypeLabelAttribute(): string
    {
        $labels = [
            'business' => 'Business & Commerce',
            'family' => 'Family Matters',
            'financial' => 'Financial & Banking',
            'property' => 'Property & Real Estate',
            'employment' => 'Employment & Labor',
            'educational' => 'Educational',
            'health' => 'Health & Medical',
            'social' => 'Social Issues',
            'religious' => 'Religious Matters',
            'other' => 'Other',
        ];
        
        return $labels[$this->consultation_type] ?? $this->consultation_type;
    }

    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'submitted' => 'Submitted',
            'under_review' => 'Under Review',
            'reviewed' => 'Reviewed',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'accomplished' => 'Accomplished',
        ];
        
        return $labels[$this->status] ?? $this->status;
    }

    // app/Models/ConsultancyApplication.php

public function getStatusColorAttribute(): string
{
    $colors = [
        'submitted' => '#1565C0',
        'under_review' => '#E65100',
        'reviewed' => '#6A1B9A',
        'approved' => '#2E7D32',
        'rejected' => '#C62828',
        'accomplished' => '#37474F',
    ];
    return $colors[$this->status] ?? '#6c757d';
}

public function getFullNameAttribute(): string
{
    return $this->firstname . ' ' . $this->lastname;
}

    public static function generateApplicationId(): string
    {
        $prefix = 'CON';
        $date = now()->format('dmy');
        $random = strtoupper(substr(uniqid(), -6));
        
        return $prefix . '-' . $date . '-' . $random;
    }
}