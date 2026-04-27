<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            AdminSeeder::class,
<<<<<<< HEAD
            BookSeeder::class,
=======
            AnggotaSeeder::class,
>>>>>>> 4cbfe0c1ccd138ae29ba694be9cba2bd5ba3058e
        ]);
    }
}
