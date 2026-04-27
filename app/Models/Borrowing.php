<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasUuids;

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
        'token_expired_at',
        'token_used',
        'token_approved_at',
    ];

    protected $casts = [
        'tanggal_pinjam'          => 'datetime',
        'tanggal_kembali_rencana' => 'datetime',
        'tanggal_kembali'         => 'datetime',
        'token_expired_at'        => 'datetime',
        'token_approved_at'       => 'datetime',
        'token_used'              => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function isTokenUsed(): bool
    {
        return (bool) $this->token_used;
    }

    public function isTokenExpired(): bool
    {
        if (! $this->token_expired_at) {
            return false;
        }

        return now()->gt($this->token_expired_at);
    }

    public function isTokenValid(): bool
    {
        return $this->token !== null
            && ! $this->isTokenUsed()
            && ! $this->isTokenExpired();
    }

    public function tokenStatus(): string
    {
        if (! $this->token) {
            return 'none';
        }

        if ($this->isTokenUsed()) {
            return 'used';
        }

        if ($this->isTokenExpired()) {
            return 'expired';
        }

        return 'active';
    }
}
