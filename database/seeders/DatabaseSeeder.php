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
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password'), 'is_admin' => false],
        );

        User::firstOrCreate(
            ['email' => 'admin@vendosmart.co.id'],
            ['name' => 'Admin VendoSmart', 'password' => bcrypt('admin123'), 'is_admin' => true],
        );

        $this->call(ProductSeeder::class);
    }
}
