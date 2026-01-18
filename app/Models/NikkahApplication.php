<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NikkahApplication extends Model
{
    use HasFactory;

    protected $fillable = [

        // Application
        'application_id',
        'status',

        // Groom
        'groom_surname',
        'groom_given_name',
        'groomNIN',
        'groom_day_date_of_birth',
        'groom_month_date_of_birth',
        'groom_year_date_of_birth',
        'groom_country',
        'groom_telephone',
        'groom_email',
        'groom_tribe',
        'groom_district',
        'groom_county',
        'groom_sub_county',
        'groom_parish',
        'groom_village',
        'groom_plot',

        // Bride
        'bride_surname',
        'bride_given_name',
        'brideNIN',
        'bride_day_date_of_birth',
        'bride_month_date_of_birth',
        'bride_year_date_of_birth',
        'bride_country',
        'bride_telephone',
        'bride_email',
        'bride_tribe',
        'bride_district',
        'bride_county',
        'bride_sub_county',
        'bride_parish',
        'bride_village',
        'bride_plot',

        // Groom Parents
        'groomFatherStatus',
        'groom_father_given_name',
        'groom_father_surname',
        'groom_father_nin',
        'groomFatherDistrict',
        'groomFatherTribe',

        'groomMotherStatus',
        'groom_mother_given_name',
        'groom_mother_surname',
        'groomMotherMaidenName',
        'groomMotherNIN',
        'groomMotherDistrict',

        // Bride Parents
        'brideFatherStatus',
        'bride_father_given_name',
        'bride_father_surname',
        'brideFatherNIN',
        'brideFatherDistrict',
        'brideFatherTribe',

        'brideMotherStatus',
        'bride_mother_given_name',
        'bride_mother_surname',
        'brideMotherMaidenName',
        'brideMotherNIN',
        'brideMotherDistrict',

        // Witnesses
        'witness1_surname',
        'witness1_given_name',
        'witness1_nin',
        'witness1_telephone',
        'witness1_address',
        'witness1District',

        'witness2_surname',
        'witness2_given_name',
        'witness2_nin',
        'witness2_telephone',
        'witness2_address',
        'witness2District',

        // Imam
        'imam_name',

        // Photos (paths only)
        'groom_photo_path',
        'bride_photo_path',
    ];
}
