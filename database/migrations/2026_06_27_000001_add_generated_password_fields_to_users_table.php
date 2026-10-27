<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // True for any account created by Bulk Import (or any other flow
            // that issues a system-generated temporary password). Used to
            // decide whether the "Generated Password" column in Manage Users
            // applies to this account at all.
            $table->boolean('bulk_imported')->default(false)->after('must_change_password');

            // The plain-text temporary password issued at account creation.
            // Shown to the Director / District Khadhi in Manage Users so they
            // can hand it to the Imaam. Cleared to NULL the moment the user
            // changes their own password — at that point the UI shows
            // "Updated" instead.
            $table->string('generated_password')->nullable()->after('bulk_imported');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bulk_imported', 'generated_password']);
        });
    }
};