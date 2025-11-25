<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
    'name' => 'Admin',
    'email' => 'admin@test.com',
    'password' => bcrypt('admin123'),
    'role' => 'admin'
]);
    }
}
