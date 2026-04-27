<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('book_id')->constrained()->cascadeOnDelete();
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali')->nullable();
            $table->integer('durasi')->default(1); // [FIX] Kolom ini wajib ada
            $table->dateTime('token_expired_at')->nullable();
            $table->string('token')->nullable();
            $table->boolean('token_used')->default(0);
            $table->enum('status', ['menunggu', 'approved', 'dipinjam', 'dikembalikan']);
            $table->integer('denda')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};