<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // New role system. The legacy integer `user_role` column is kept (read-only,
            // for historical records) but is no longer used to decide access.
            $table->foreignId('role_id')->nullable()->after('user_role')->constrained('roles')->nullOnDelete();

            // Jurisdiction. A District Khadhi only needs `district`, a County Sheikh needs
            // both `district` and `county`, an Imaam additionally has a `mosque_name`.
            $table->string('region')->nullable()->after('country');
            $table->string('district')->nullable()->after('region');
            $table->string('county')->nullable()->after('district');
            $table->string('mosque_name')->nullable()->after('county');

            // Captured from the bulk Imaam/Mosque directory import - informational only,
            // the deputy is not granted a system account.
            $table->string('deputy_name')->nullable()->after('mosque_name');
            $table->string('deputy_contact')->nullable()->after('deputy_name');

            // Who registered this account - lets the Director/District Khadhi trace
            // who onboarded who, and powers the "created by" jurisdiction checks.
            $table->foreignId('created_by')->nullable()->after('deputy_contact')->constrained('users')->nullOnDelete();

            // Forces a password change screen on next login - used for bulk-imported
            // accounts and any account an administrator resets on behalf of a user.
            $table->boolean('must_change_password')->default(false)->after('created_by');

            $table->timestamp('last_login_at')->nullable()->after('must_change_password');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('role_id');
            $table->dropConstrainedForeignId('created_by');

            $table->dropColumn([
                'region',
                'district',
                'county',
                'mosque_name',
                'deputy_name',
                'deputy_contact',
                'must_change_password',
                'last_login_at',
            ]);
        });
    }
};
