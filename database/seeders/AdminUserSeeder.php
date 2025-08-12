<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if it doesn't exist
        if (!User::where('email', 'admin@safar.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@safar.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'phone' => '+1234567890',
                'is_active' => true,
            ]);

            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@safar.com');
            $this->command->info('Password: admin123');
        } else {
            $this->command->info('Admin user already exists!');
        }

        // Create a test user if it doesn't exist
        if (!User::where('email', 'user@safar.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'user@safar.com',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'phone' => '+0987654321',
                'is_active' => true,
            ]);

            $this->command->info('Test user created successfully!');
            $this->command->info('Email: user@safar.com');
            $this->command->info('Password: user123');
        } else {
            $this->command->info('Test user already exists!');
        }

        // Create a moderator user if it doesn't exist
        if (!User::where('email', 'moderator@safar.com')->exists()) {
            User::create([
                'name' => 'Moderator User',
                'email' => 'moderator@safar.com',
                'password' => Hash::make('moderator123'),
                'role' => 'moderator',
                'phone' => '+1122334455',
                'is_active' => true,
            ]);

            $this->command->info('Moderator user created successfully!');
            $this->command->info('Email: moderator@safar.com');
            $this->command->info('Password: moderator123');
        } else {
            $this->command->info('Moderator user already exists!');
        }
    }
}
