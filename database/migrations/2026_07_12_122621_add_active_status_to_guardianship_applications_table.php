<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE guardianship_applications
            MODIFY status ENUM('submitted', 'accomplished', 'active', 'rejected')
            NOT NULL DEFAULT 'submitted'
        ");
    }

    public function down(): void
    {
        // Any rows currently set to 'active' must be moved to a valid
        // value before the column can be shrunk back down, or this
        // rollback will fail with the same truncation error.
        DB::statement("
            UPDATE guardianship_applications
            SET status = 'accomplished'
            WHERE status = 'active'
        ");

        DB::statement("
            ALTER TABLE guardianship_applications
            MODIFY status ENUM('submitted', 'accomplished', 'rejected')
            NOT NULL DEFAULT 'submitted'
        ");
    }
};