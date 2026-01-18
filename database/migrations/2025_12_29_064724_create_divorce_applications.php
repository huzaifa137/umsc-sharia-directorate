<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('divorce_applications', function (Blueprint $table) {
            $table->id();

            // Application
            $table->string('application_id')->unique();
            $table->string('status')->default('pending');

            // Groom
            $table->string('groom_surname');
            $table->string('groom_given_name');
            $table->string('groom_nin');
            $table->string('groom_phone');
            $table->string('groom_email');
            $table->string('groom_tribe');
            $table->string('groom_district');
            $table->string('groom_municipality');
            $table->string('groom_sub_county');
            $table->string('groom_parish');
            $table->string('groom_village');
            $table->string('groom_plot_number')->nullable();
            $table->string('groom_photo_path')->nullable();

            // Bride
            $table->string('bride_surname');
            $table->string('bride_given_name');
            $table->string('bride_nin');
            $table->string('bride_phone');
            $table->string('bride_email');
            $table->string('bride_tribe');
            $table->string('bride_district');
            $table->string('bride_municipality');
            $table->string('bride_sub_county');
            $table->string('bride_parish');
            $table->string('bride_village');
            $table->string('bride_plot_number')->nullable();
            $table->string('bride_photo_path')->nullable();

            // Divorce details
            $table->string('divorce_type');
            $table->unsignedTinyInteger('talaq_count')->nullable();
            $table->string('divorce_initiated_by');
            $table->string('divorce_place');
            $table->text('divorce_reason');

            // Witnesses
            $table->string('w1_given_name');
            $table->string('w1_surname');
            $table->string('w1_nin');
            $table->string('w1_phone');
            $table->string('w1_address');

            $table->string('w2_given_name');
            $table->string('w2_surname');
            $table->string('w2_nin');
            $table->string('w2_phone');
            $table->string('w2_address');

            // Authority
            $table->string('imam_name');
            $table->string('imam_reg');
            $table->string('qadhi_area')->nullable();
            $table->string('mosque_name');

            // Children
            $table->string('children_involved');
            $table->unsignedInteger('num_children')->nullable();
            $table->string('custody_arrangement')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divorce_applications');
    }
};
