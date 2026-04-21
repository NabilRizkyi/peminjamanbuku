<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'nomor_anggota',
    ];

    /**
     * Hidden field
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast data
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Auto generate nomor anggota
     */
    protected static function booted()
    {
        static::creating(function ($user) {

            // Ambil user terakhir
            $lastUser = self::latest()->first();

            $lastNumber = 0;

            // Cegah error null
            if ($lastUser && $lastUser->nomor_anggota) {
                $lastNumber = intval(substr($lastUser->nomor_anggota, 3));
            }

            // Generate nomor anggota
            $user->nomor_anggota = 'AGT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            // Pastikan role selalu anggota
            $user->role = 'anggota';
        });
    }

    /**
     * Relasi ke peminjaman
     */
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}