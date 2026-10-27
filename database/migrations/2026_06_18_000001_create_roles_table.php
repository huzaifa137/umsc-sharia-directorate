<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();

            $table->string('name');                 // e.g. "District Khadhi"
            $table->string('slug')->unique();        // e.g. "district_khadhi"
            $table->text('description')->nullable();

            // Determines what an account with this role is allowed to see.
            // self     -> only records they personally created
            // county   -> records created by themselves + Imaams in their county
            // district -> records created by themselves + County Sheikhs/Imaams in their district
            // global   -> everything in the system
            $table->enum('data_scope', ['self', 'county', 'district', 'global'])->default('self');

            // Hierarchy weight used to decide who can create/manage who.
            // Higher level = more authority. Spaced by 10 so custom roles can be slotted in between.
            $table->unsignedInteger('level')->default(10);

            // System roles (Imaam, County Sheikh, District Khadhi, Director Sharia) are
            // seeded by the application and cannot be deleted, only edited.
            $table->boolean('is_system')->default(false);

            // Director-only flag. Bypasses every permission & scope check.
            $table->boolean('full_access')->default(false);

            // Presentation
            $table->string('color', 20)->default('#00580f');
            $table->string('icon', 60)->default('bx-shield');

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
