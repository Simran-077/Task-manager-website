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
        // Create Admin User
        User::updateOrCreate(
            ['email' => 'admin@taskmanager.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('Admin@123'),
                'role' => 'admin',
            ]
        );

        // Create Regular User
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('Test@123'),
                'role' => 'user',
            ]
        );
    }


}
