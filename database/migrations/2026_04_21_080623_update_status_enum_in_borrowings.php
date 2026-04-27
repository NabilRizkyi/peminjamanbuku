<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Skipped: status column already defined in create_borrowings_table
        // MODIFY syntax is MySQL-only, not compatible with PostgreSQL
    }

    public function down(): void
    {
        //
    }
};