<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('search_index', function (Blueprint $table) {
            $table->id();

            // What module this record belongs to
            $table->string('module');
            // nikah | divorce | inheritance | guardianship | convert

            // Application identifier (NK-UMSC..., DV-UMSC...)
            $table->string('application_id')->index();

            // Human-readable title for display
            $table->string('title');

            // Searchable keywords (names, IDs, text)
            $table->text('keywords');

            // Reference back to original table
            $table->unsignedBigInteger('reference_id');

            // Status for filtering
            $table->string('status')->index();

            // Submission date (for date filters)
            $table->date('application_date')->index();

            // For permissions
            $table->unsignedTinyInteger('required_role')->nullable();

            $table->timestamps();

            // Composite indexes for performance
            $table->index(['module', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('search_index');
    }
};
