<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
       User::updateOrCreate(
    ['email' => 'admin@gmail.com'],
    [
        'name' => 'Admin',
        'password' => Hash::make('12345678'),
        'role' => 'admin',
        'status' => 'approved',
    ]
);
    }
}