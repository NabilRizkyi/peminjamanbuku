<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'judul',
        'penulis',
        'deskripsi',
        'stok',
        'cover'
    ];

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function getCoverUrlAttribute()
    {
        return $this->cover 
            ? asset('storage/' . $this->cover) 
            : asset('images/no-image.png');
    }
}