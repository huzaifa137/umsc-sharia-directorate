<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'firstname' => 'Test',
            'lastname' => 'User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => Hash::make('Pa$$w0rd!'), 
            'user_role' => 1,
            'account_status' => 10,
            'registration_status' => 1,
            'phonenumber' => '1234567890',
            'country' => 'Kenya',
        ]);
    }
}
