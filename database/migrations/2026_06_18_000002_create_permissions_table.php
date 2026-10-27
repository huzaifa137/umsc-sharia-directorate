<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();

            $table->string('name');             // Human readable, e.g. "View Nikah Applications"
            $table->string('slug')->unique();    // e.g. "nikah.view"
            $table->string('module');            // Grouping label for the UI, e.g. "Nikah"
            $table->string('action')->nullable(); // view | create | edit | delete | approve | manage
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
};
