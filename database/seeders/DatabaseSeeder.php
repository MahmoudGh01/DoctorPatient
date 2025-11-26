<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Cabinet;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create random users with random roles
        User::factory(4)->create();

        // Admin
        User::create([
            'name' => 'Mahmoud',
            'email' => 'Mahmoud@gharbi.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Regular patient
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
            'role' => 'patient',
        ]);

        // Doctors (optional)
        User::factory()->count(3)->create([
            'role' => 'doctor',
        ]);

        Cabinet::factory(5)->create();
        Appointment::factory(5)->create();
    }

}
