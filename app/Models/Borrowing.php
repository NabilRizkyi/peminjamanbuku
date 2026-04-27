<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_kembali_rencana',
        'durasi',
        'status',
        'denda',
        'token',
        'token_expired_at', // 
        'token_used',       // 
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'token_expired_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // RELASI
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}