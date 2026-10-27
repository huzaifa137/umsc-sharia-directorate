<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $this->call([
            CountriesSeeder::class,
            RolesAndPermissionsSeeder::class,
        ]);

        $directorRole = Role::where('slug', 'director')->first();

        // Default Director for Sharia account. Change this password immediately
        // after first login — the account is also flagged must_change_password.
        User::firstOrCreate(
            ['username' => 'director'],
            [
                'firstname' => 'Director',
                'lastname' => 'Sharia',
                'email' => 'director@umsc-sharia.test',
                'password' => Hash::make('Director@2026'),
                'user_role' => 3,
                'role_id' => $directorRole?->id,
                'account_status' => 10,
                'registration_status' => 1,
                'phonenumber' => '+256700000000',
                'country' => 'Uganda',
                'gender' => 'male',
                'must_change_password' => true,
            ]
        );
    }
}
