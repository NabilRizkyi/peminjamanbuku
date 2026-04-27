<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasUuids, HasFactory, Notifiable; // ← hapus duplikat

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'nomor_anggota',
        'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->role)) {
                $user->role = 'anggota';
            }

            if ($user->role === 'anggota' && empty($user->nomor_anggota)) {
                // ✅ Pakai max() lebih aman & efisien
                $lastUser = self::where('role', 'anggota')
                                ->whereNotNull('nomor_anggota')
                                ->orderByRaw("CAST(SUBSTRING(nomor_anggota, 4) AS INTEGER) DESC")
                                ->first();

                $lastNumber = 0;
                if ($lastUser && $lastUser->nomor_anggota) {
                    $lastNumber = intval(substr($lastUser->nomor_anggota, 3));
                }

                $user->nomor_anggota = 'AGT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
}
