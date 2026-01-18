<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inheritance_applications', function (Blueprint $table) {
            $table->id();

            $table->string('application_id')->unique();
            $table->string('status')->default('submitted');

            // Deceased info
            $table->string('deceased_name');
            $table->string('gender');
            $table->date('date_of_death');
            $table->string('place_of_death');
            $table->string('cause_of_death')->nullable();
            $table->string('deceased_nin');
            $table->string('marital_status');
            $table->string('occupation')->nullable();
            $table->text('last_residence');

            // Applicant info
            $table->string('applicant_name');
            $table->string('relationship');
            $table->string('applicant_nin');
            $table->string('applicant_phone');

            // Estate values
            $table->decimal('total_estate_value', 15, 2);
            $table->decimal('outstanding_debts', 15, 2)->nullable();
            $table->decimal('funeral_expenses', 15, 2);
            $table->decimal('unpaid_zakat', 15, 2)->nullable();
            $table->decimal('other_liabilities', 15, 2)->nullable();

            // Uploads
            $table->string('death_certificate_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inheritance_applications');
    }
};
