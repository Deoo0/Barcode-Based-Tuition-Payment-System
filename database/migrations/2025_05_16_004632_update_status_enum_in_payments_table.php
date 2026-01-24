<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE payments
            DROP CONSTRAINT IF EXISTS payments_status_check
        ");

        DB::statement("
            ALTER TABLE payments
            ADD CONSTRAINT payments_status_check
            CHECK (status IN ('Partial','Paid','Pending','Cancelled','Completed'))
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE payments
            DROP CONSTRAINT IF EXISTS payments_status_check
        ");

        DB::statement("
            ALTER TABLE payments
            ADD CONSTRAINT payments_status_check
            CHECK (status IN ('Partial','Paid','Pending','Cancelled'))
        ");
    }
};
