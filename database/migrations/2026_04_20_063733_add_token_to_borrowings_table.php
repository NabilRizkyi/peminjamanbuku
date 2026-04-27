<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {

            if (!Schema::hasColumn('borrowings', 'token')) {
                $table->string('token')->nullable();
            }

            if (!Schema::hasColumn('borrowings', 'token_expired_at')) {
                $table->timestamp('token_expired_at')->nullable();
            }

            if (!Schema::hasColumn('borrowings', 'token_used')) {
                $table->boolean('token_used')->default(false);
            }

        });
    }

    public function down(): void
    {
        Schema::table('borrowings', function (Blueprint $table) {

            if (Schema::hasColumn('borrowings', 'token')) {
                $table->dropColumn('token');
            }

            if (Schema::hasColumn('borrowings', 'token_expired_at')) {
                $table->dropColumn('token_expired_at');
            }

            if (Schema::hasColumn('borrowings', 'token_used')) {
                $table->dropColumn('token_used');
            }

        });
    }
};