<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignUuid('book_id')->constrained('books')->cascadeOnDelete();
            
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali_rencana');
            $table->date('tanggal_kembali')->nullable(); // Waktu aktual pengembalian
            
            $table->integer('durasi')->default(1);
            $table->string('status')->default('menunggu'); // menunggu, dipinjam, dikembalikan
            $table->integer('denda')->default(0);

            // Token pengambilan
            $table->string('token')->nullable();
            $table->timestamp('token_approved_at')->nullable();
            $table->timestamp('token_expired_at')->nullable();
            $table->boolean('token_used')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
