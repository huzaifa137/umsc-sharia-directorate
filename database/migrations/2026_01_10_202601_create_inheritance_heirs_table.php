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
        Schema::create('inheritance_heirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inheritance_application_id')
                ->constrained()
                ->cascadeOnDelete();

            // Spouse
            $table->string('spouse_name')->nullable();
            $table->string('spouse_nin')->nullable();

            // Children
            $table->integer('sons_count')->default(0);
            $table->integer('daughters_count')->default(0);

            // Parents
            $table->string('father_alive');
            $table->string('father_name')->nullable();
            $table->string('mother_alive');
            $table->string('mother_name')->nullable();

            // Siblings
            $table->integer('full_brothers')->default(0);
            $table->integer('full_sisters')->default(0);
            $table->integer('uterine_brothers')->default(0);
            $table->integer('uterine_sisters')->default(0);

            // Special cases
            $table->string('pregnant_heir');
            $table->string('minor_heirs');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inheritance_heirs');
    }
};
