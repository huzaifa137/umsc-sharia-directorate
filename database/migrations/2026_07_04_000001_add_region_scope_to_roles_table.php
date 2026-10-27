<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Adds the "region" tier to the data_scope enum, slotting the Regional
     * Assistant role in between District Khadhi and Director for Sharia:
     *
     *   self (Imaam) -> county (County Sheikh) -> district (District Khadhi)
     *   -> region (Regional Assistant) -> global (Director for Sharia)
     */
    public function up()
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // SQLite has no native ENUM type — data_scope is just a CHECK-less
            // string column there, so there's nothing to alter.
            return;
        }

        DB::statement("ALTER TABLE roles MODIFY data_scope ENUM('self','county','district','region','global') NOT NULL DEFAULT 'self'");
    }

    public function down()
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            return;
        }

        // Reassign any 'region' roles back to 'district' before shrinking the enum,
        // so the rollback never leaves an invalid value behind.
        DB::table('roles')->where('data_scope', 'region')->update(['data_scope' => 'district']);

        DB::statement("ALTER TABLE roles MODIFY data_scope ENUM('self','county','district','global') NOT NULL DEFAULT 'self'");
    }
};
