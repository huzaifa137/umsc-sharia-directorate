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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Who
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('user_role')->nullable(); // Imaam, District Qadh, System

            // What
            $table->string('action'); // login, create, update, approve, delete
            $table->string('target_type')->nullable(); // User, NikkahApplication, Role
            $table->unsignedBigInteger('target_id')->nullable();

            // Result
            $table->string('status')->default('success'); // success | failed

            // Context
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();

            // Extra info
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
