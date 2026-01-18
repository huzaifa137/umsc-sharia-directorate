<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('guardianship_applications', function (Blueprint $table) {
            $table->id();
            
            // Ward Details
            $table->string('application_id')->unique();
            $table->string('ward_name');
            $table->enum('ward_gender', ['male', 'female']);
            $table->date('ward_dob');
            $table->integer('ward_age');
            $table->string('birth_certificate_number')->nullable();
            $table->enum('ward_type', ['orphan', 'abandoned', 'special_needs', 'normal']);
            $table->enum('guardianship_type', ['minor', 'incapacitated', 'testamentary', 'emergency']);
            $table->text('health_conditions')->nullable();
            $table->enum('ward_education_level', ['none', 'nursery', 'primary', 'secondary', 'vocational', 'university'])->nullable();
            $table->string('ward_photo_path')->nullable();
            
            // Parental Information
            $table->string('father_name');
            $table->enum('father_status', ['alive', 'deceased', 'unknown', 'incapacitated']);
            $table->string('mother_name')->nullable();
            $table->enum('mother_status', ['alive', 'deceased', 'unknown', 'incapacitated']);
            $table->string('birth_certificate_path')->nullable();
            
            // Guardian Applicant Details
            $table->string('guardian_name');
            $table->enum('guardian_gender', ['male', 'female'])->nullable();
            $table->date('guardian_dob');
            $table->string('guardian_nin');
            $table->enum('relationship_to_ward', ['father', 'mother', 'relative', 'other']);
            $table->string('guardian_phone');
            $table->text('guardian_address');
            $table->text('previous_experience')->nullable();
            $table->enum('criminal_record', ['yes', 'no']);
            $table->string('health_status')->nullable();
            $table->text('religious_background')->nullable();
            $table->text('motivation');
            $table->string('guardian_photo_path')->nullable();
            
            // Guardianship Terms
            $table->enum('guardianship_duration', ['until_majority', 'specific_period', 'indefinite']);
            $table->enum('reporting_frequency', ['monthly', 'quarterly', 'annually', 'none'])->nullable();
            $table->json('powers_granted')->nullable();
            $table->text('restrictions')->nullable();
            
            // Verification
            $table->string('imam_name')->nullable();
            $table->string('imam_reg_number')->nullable();
            $table->string('mosque_name')->nullable();
            
            // Witnesses
            $table->string('witness1_name')->nullable();
            $table->string('witness1_nin')->nullable();
            $table->string('witness2_name')->nullable();
            $table->string('witness2_nin')->nullable();
            
            // Application Status
            $table->enum('status', ['submitted', 'accomplished', 'rejected'])->default('submitted');
            
            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guardianship_applications');
    }
};