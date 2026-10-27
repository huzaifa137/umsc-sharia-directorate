<?php
// database/migrations/2026_07_18_000000_create_consultancy_applications_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultancy_applications', function (Blueprint $table) {
            $table->id();
            
            // Application identifiers
            $table->string('application_id')->unique();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Officer scope (for access control)
            $table->string('officer_district')->nullable();
            $table->string('officer_county')->nullable();
            $table->string('officer_region')->nullable();
            
            // Applicant information
            $table->string('applicant_name');
            $table->string('applicant_phone');
            $table->string('applicant_email')->nullable();
            $table->string('applicant_nin')->nullable();
            $table->string('applicant_address')->nullable();
            $table->string('applicant_occupation')->nullable();
            
            // Consultation details
            $table->enum('consultation_type', [
                'business',
                'family',
                'financial',
                'property',
                'employment',
                'educational',
                'health',
                'social',
                'religious',
                'other'
            ])->default('other');
            $table->string('consultation_type_other')->nullable();
            $table->text('subject')->nullable();
            $table->text('description');
            $table->text('background_info')->nullable();
            
            // Supporting documents
            $table->string('attachment_path')->nullable();
            
            // Response / Ruling
            $table->text('islamic_guidance')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('conditions')->nullable();
            $table->text('restrictions')->nullable();
            
            // References
            $table->text('quran_reference')->nullable();
            $table->text('hadith_reference')->nullable();
            $table->text('scholar_reference')->nullable();
            
            // Approval/Signing
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('signed_at')->nullable();
            $table->foreignId('signed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('signature_path')->nullable();
            $table->string('official_stamp_path')->nullable();
            
            // Status
            $table->enum('status', [
                'submitted',
                'under_review',
                'reviewed',
                'approved',
                'rejected',
                'accomplished'
            ])->default('submitted');
            
            $table->timestamps();
        });

        // Add search index
        Schema::create('consultancy_search_index', function (Blueprint $table) {
            $table->id();
            $table->string('application_id');
            $table->string('applicant_name');
            $table->text('keywords');
            $table->foreignId('reference_id')->constrained('consultancy_applications')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('officer_district')->nullable();
            $table->string('officer_county')->nullable();
            $table->string('status');
            $table->date('application_date');
            $table->tinyInteger('required_role')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultancy_search_index');
        Schema::dropIfExists('consultancy_applications');
    }
};