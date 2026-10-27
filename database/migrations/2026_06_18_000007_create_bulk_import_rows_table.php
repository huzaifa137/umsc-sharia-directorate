<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bulk_import_rows', function (Blueprint $table) {
            $table->id();

            $table->foreignId('batch_id')->constrained('bulk_import_batches')->cascadeOnDelete();
            $table->unsignedInteger('row_number');

            $table->string('status'); // created | duplicate | error
            $table->string('message')->nullable();

            // Snapshot of the parsed row (region/district/county/mosque/imaam/username...).
            // Never store plaintext passwords here.
            $table->json('payload')->nullable();

            $table->foreignId('created_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bulk_import_rows');
    }
};
