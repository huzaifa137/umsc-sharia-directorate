<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nikkah_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_id', 50)->unique()->nullable();
            $table->string('status', 20)->default('submitted');

            // Groom
            $table->string('groom_surname', 100)->nullable();
            $table->string('groom_given_name', 100)->nullable();
            $table->string('groomNIN', 20)->nullable();
            $table->tinyInteger('groom_day_date_of_birth')->nullable();
            $table->tinyInteger('groom_month_date_of_birth')->nullable();
            $table->smallInteger('groom_year_date_of_birth')->nullable();
            $table->string('groom_country', 3)->nullable();
            $table->string('groom_telephone', 20)->nullable();
            $table->string('groom_email', 100)->nullable();
            $table->string('groom_tribe', 100)->nullable();
            $table->string('groom_district', 100)->nullable();
            $table->string('groom_county', 100)->nullable();
            $table->string('groom_sub_county', 100)->nullable();
            $table->string('groom_parish', 100)->nullable();
            $table->string('groom_village', 100)->nullable();
            $table->string('groom_plot', 50)->nullable();

            // Bride
            $table->string('bride_surname', 100)->nullable();
            $table->string('bride_given_name', 100)->nullable();
            $table->string('brideNIN', 20)->nullable();
            $table->string('dowery_specify', 20)->nullable();
            $table->tinyInteger('bride_day_date_of_birth')->nullable();
            $table->tinyInteger('bride_month_date_of_birth')->nullable();
            $table->smallInteger('bride_year_date_of_birth')->nullable();
            $table->string('bride_country', 3)->nullable();
            $table->string('bride_telephone', 20)->nullable();
            $table->string('bride_email', 100)->nullable();
            $table->string('bride_tribe', 100)->nullable();
            $table->string('bride_district', 100)->nullable();
            $table->string('bride_county', 100)->nullable();
            $table->string('bride_sub_county', 100)->nullable();
            $table->string('bride_parish', 100)->nullable();
            $table->string('bride_village', 100)->nullable();
            $table->string('bride_plot', 50)->nullable();

            // Groom Parents
            $table->string('groomFatherStatus', 20)->nullable();
            $table->string('groom_father_given_name', 100)->nullable();
            $table->string('groom_father_surname', 100)->nullable();
            $table->string('groom_father_nin', 20)->nullable();
            $table->string('groomFatherDistrict', 100)->nullable();
            $table->string('groomFatherTribe', 100)->nullable();

            $table->string('groomMotherStatus', 20)->nullable();
            $table->string('groom_mother_given_name', 100)->nullable();
            $table->string('groom_mother_surname', 100)->nullable();
            $table->string('groomMotherMaidenName', 100)->nullable();
            $table->string('groomMotherNIN', 20)->nullable();
            $table->string('groomMotherDistrict', 100)->nullable();

            // Bride Parents
            $table->string('brideFatherStatus', 20)->nullable();
            $table->string('bride_father_given_name', 100)->nullable();
            $table->string('bride_father_surname', 100)->nullable();
            $table->string('brideFatherNIN', 20)->nullable();
            $table->string('brideFatherDistrict', 100)->nullable();
            $table->string('brideFatherTribe', 100)->nullable();

            $table->string('brideMotherStatus', 20)->nullable();
            $table->string('bride_mother_given_name', 100)->nullable();
            $table->string('bride_mother_surname', 100)->nullable();
            $table->string('brideMotherMaidenName', 100)->nullable();
            $table->string('brideMotherNIN', 20)->nullable();
            $table->string('brideMotherDistrict', 100)->nullable();

            // Witnesses (only 1 & 2 captured)
            for ($i = 1; $i <= 2; $i++) {
                $table->string("witness{$i}_surname", 100)->nullable();
                $table->string("witness{$i}_given_name", 100)->nullable();
                $table->string("witness{$i}_nin", 20)->nullable();
                $table->string("witness{$i}_telephone", 20)->nullable();
                $table->string("witness{$i}_address", 150)->nullable();
                $table->string("witness{$i}District", 100)->nullable();
            }

            // Imam
            $table->string('imam_name', 100)->nullable();

            // Photos
            $table->string('groom_photo_path', 150)->nullable();
            $table->string('bride_photo_path', 150)->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nikkah_applications');
    }
};
