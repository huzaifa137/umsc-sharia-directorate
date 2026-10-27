<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * These columns record WHO registered an application and WHERE they were
     * stationed at the time, so the role-based visibility rules (Imaam -> own
     * records, County Sheikh -> his county, District Khadhi -> his district,
     * Director -> everything) can be enforced with a simple, fast `WHERE`
     * clause instead of an expensive join on every listing page.
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
                $table->foreignId('created_by')->nullable()->after('id')->constrained('users')->nullOnDelete();
                $table->string('officer_district')->nullable()->after('created_by');
                $table->string('officer_county')->nullable()->after('officer_district');
            });
        }
    }

    public function down()
    {
        foreach ($this->tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('created_by');
                $table->dropColumn(['officer_district', 'officer_county']);
            });
        }
    }
};
