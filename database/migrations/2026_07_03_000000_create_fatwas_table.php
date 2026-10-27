<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fatwas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('question');           // the matter being asked about
            $table->longText('ruling');         // the Director's answer/ruling
            $table->string('category')->nullable();
            $table->string('icon')->default('bx-book-open');   // boxicon class for the public card
            $table->string('color', 20)->default('#059568');   // accent color for the public card
            $table->text('quran_reference')->nullable();
            $table->text('hadith_reference')->nullable();
            $table->string('youtube_url')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fatwas');
    }
};