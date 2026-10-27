<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('nikkah_applications', function (Blueprint $table) {
            $table->string('masjid_name', 100)->nullable()->after('imam_name');
            $table->string('dowery_type', 20)->nullable()->after('bride_plot');
            $table->string('dowery_specify', 255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('nikkah_applications', function (Blueprint $table) {
            $table->dropColumn(['masjid_name', 'dowery_type']);
            $table->string('dowery_specify', 20)->nullable()->change();
        });
    }
};