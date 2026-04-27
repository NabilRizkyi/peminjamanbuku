<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            if (!Schema::hasColumn('borrowings', 'tanggal_pengembalian')) {
                $table->date('tanggal_pengembalian')->nullable()->after('tanggal_kembali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {
            if (Schema::hasColumn('borrowings', 'tanggal_pengembalian')) {
                $table->dropColumn('tanggal_pengembalian');
            }
        });
    }
};