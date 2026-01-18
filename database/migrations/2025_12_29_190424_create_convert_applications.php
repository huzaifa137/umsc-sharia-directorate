<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('convert_applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->unique();

            // Step A - Convert's Declaration
            $table->string('former_names');
            $table->string('former_religion');
            $table->date('date_of_birth');
            $table->string('occupation');
            $table->string('current_residence');
            $table->string('contact');
            $table->string('father_name');
            $table->string('mother_name');
            $table->text('home_address');
            $table->string('county');
            $table->string('district');

            // Step B - Upon Conversion
            $table->string('new_names');
            $table->date('conversion_date');
            $table->string('conversion_place');
            $table->string('guardian_name');
            $table->string('guardian_occupation');
            $table->date('guardian_declaration_date');
            $table->text('conversion_reasons');
            $table->text('guardian_declaration');

            // Step C - Declaration
            $table->date('declaration_date');
            $table->boolean('declaration_agreement')->default(false);
            $table->string('signature')->nullable(); // store file path

            // Step D - Officer Verification
            $table->string('officer_name');
            $table->string('officer_position');
            $table->string('registration_number');
            $table->date('verification_date');
            $table->text('officer_remarks')->nullable();
            $table->string('officer_signature')->nullable(); // file path
            $table->string('official_stamp')->nullable(); // file path
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('convert_support_sessions');
        Schema::dropIfExists('convert_education_progress');
        Schema::dropIfExists('convert_applications');
    }
};