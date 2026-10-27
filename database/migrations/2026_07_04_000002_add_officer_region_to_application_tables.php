<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Mirrors officer_district/officer_county with an officer_region stamp,
     * so a Regional Assistant's "everything registered in my region" view
     * can be enforced with the same simple WHERE-clause pattern used for
     * district/county scope, instead of an expensive join against a
     * district -> region lookup table.
     */
    private array $tables = [
        'nikkah_applications',
        'divorce_applications',
        'inheritance_applications',
        'guardianship_applications',
        'convert_applications',
    ];

    public function up()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->string('officer_region')->nullable()->after('officer_county');
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('officer_region');
            });
        }
    }
};
