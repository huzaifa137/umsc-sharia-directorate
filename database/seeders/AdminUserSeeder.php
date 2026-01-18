<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Check if user already exists
        $existingUser = User::where('email', 'techmhalid@gmail.com')->first();
        
        if ($existingUser) {
            echo "User already exists with email: techmhalid@gmail.com\n";
            return;
        }
        
        // Create admin user with all required fields
        $user = User::create([
            'username' => 'admin',
            'email' => 'techmhalid@gmail.com',
            'password' => Hash::make('Halid@123'),
            'user_role' => 'admin', // Check what roles exist: admin, user, farmer, etc.
            'account_status' => 'active', // active, inactive, suspended
            'registration_status' => 'completed', // pending, completed
            'firstname' => 'Admin',
            'lastname' => 'User',
            'gender' => 'male', // or 'female'
            'phonenumber' => '+255123456789', // Tanzanian format
            'country' => 'Tanzania',
            'temp_otp' => null,
            'email_verified_at' => now(),
            'last_login_at' => null,
            'profile_photo' => null,
        ]);
        
        echo "Admin user created successfully!\n";
        echo "Username: admin\n";
        echo "Email: techmhalid@gmail.com\n";
        echo "Password: Halid@123\n";
        echo "Role: " . $user->user_role . "\n";
    }
}