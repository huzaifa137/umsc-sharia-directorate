<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mosques', function (Blueprint $table) {
            $table->id();

            $table->string('region');
            $table->string('district');
            $table->string('county');
            $table->string('name');               // Mosque name
            $table->string('location')->nullable(); // Village/area the mosque sits in

            $table->string('imaam_name')->nullable();
            $table->string('imaam_contact')->nullable();
            $table->string('deputy_imaam_name')->nullable();
            $table->string('deputy_imaam_contact')->nullable();

            // Linked once an account is created for the Imaam of this mosque.
            $table->foreignId('imaam_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('imported_batch_id')->nullable()->constrained('bulk_import_batches')->nullOnDelete();

            $table->timestamps();

            $table->index(['region', 'district', 'county']);
            $table->unique(['district', 'county', 'name'], 'mosques_unique_in_county');
        });
    }

    public function down()
    {
        Schema::dropIfExists('mosques');
    }
};
