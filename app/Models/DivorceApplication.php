<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivorceApplication extends Model
{
    protected $fillable = [
        'application_id',
        'status',
        'created_by',
        'officer_region',
        'officer_district',
        'officer_county',

        'groom_surname',
        'groom_given_name',
        'groom_nin',
        'groom_phone',
        'groom_email',
        'groom_tribe',
        'groom_district',
        'groom_municipality',
        'groom_sub_county',
        'groom_parish',
        'groom_village',
        'groom_plot_number',
        'groom_photo_path',

        'bride_surname',
        'bride_given_name',
        'bride_nin',
        'bride_phone',
        'bride_email',
        'bride_tribe',
        'bride_district',
        'bride_municipality',
        'bride_sub_county',
        'bride_parish',
        'bride_village',
        'bride_plot_number',
        'bride_photo_path',

        'divorce_type',
        'talaq_count',
        'divorce_initiated_by',
        'divorce_place',
        'divorce_reason',

        'w1_given_name',
        'w1_surname',
        'w1_nin',
        'w1_phone',
        'w1_address',

        'w2_given_name',
        'w2_surname',
        'w2_nin',
        'w2_phone',
        'w2_address',

        'imam_name',
        'imam_reg',
        'qadhi_area',
        'mosque_name',

        'children_involved',
        'num_children',
        'custody_arrangement',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
