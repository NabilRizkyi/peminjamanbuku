<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
<<<<<<< HEAD
    use HasFactory, Notifiable;
    
=======
    use HasUuids, HasFactory, Notifiable;

>>>>>>> 856d5ac925529bc4eaa6bd5b89b64563fe18f814
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
            // Default role is anggota if not specified
            if (empty($user->role)) {
                $user->role = 'anggota';
            }

            // Only generate nomor_anggota for anggota
            if ($user->role === 'anggota' && empty($user->nomor_anggota)) {
                $lastUser = self::where('role', 'anggota')
                                ->whereNotNull('nomor_anggota')
                                ->latest('created_at')
                                ->first();

                $lastNumber = 0;
                if ($lastUser) {
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