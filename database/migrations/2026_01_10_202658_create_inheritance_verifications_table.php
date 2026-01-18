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
        Schema::create('inheritance_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inheritance_application_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('imam_name');
            $table->string('imam_reg_number')->nullable();
            $table->string('mosque_name');
            $table->date('verification_date')->nullable();
            $table->text('verification_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inheritance_verifications');
    }
};
