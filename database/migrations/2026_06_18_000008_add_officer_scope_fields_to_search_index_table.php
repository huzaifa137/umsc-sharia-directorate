<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('search_index', function (Blueprint $table) {
            $table->foreignId('created_by')->nullable()->after('reference_id')->constrained('users')->nullOnDelete();
            $table->string('officer_district')->nullable()->after('created_by');
            $table->string('officer_county')->nullable()->after('officer_district');
        });
    }

    public function down()
    {
        Schema::table('search_index', function (Blueprint $table) {
            $table->dropConstrainedForeignId('created_by');
            $table->dropColumn(['officer_district', 'officer_county']);
        });
    }
};
