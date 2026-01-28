<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = \App\Models\User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create doctor users
        $doctor1 = \App\Models\User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor1@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'doctor',
        ]);

        $doctor2 = \App\Models\User::create([
            'name' => 'Dr. Jane Doe',
            'email' => 'doctor2@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'doctor',
        ]);

        // Create patient users
        $patient1 = \App\Models\User::create([
            'name' => 'Patient One',
            'email' => 'patient1@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'patient',
        ]);

        $patient2 = \App\Models\User::create([
            'name' => 'Patient Two',
            'email' => 'patient2@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'patient',
        ]);

        // Create cabinets
        $cabinet1 = \App\Models\Cabinet::create([
            'name' => 'Cardiology Clinic',
            'location' => '123 Medical Center, New York, NY 10001',
            'doctor_id' => $doctor1->id,
        ]);

        $cabinet2 = \App\Models\Cabinet::create([
            'name' => 'General Practice',
            'location' => '456 Health Street, Los Angeles, CA 90001',
            'doctor_id' => $doctor2->id,
        ]);

        // Create appointments
        \App\Models\Appointment::create([
            'datetime' => now()->addDays(1),
            'status' => 'scheduled',
            'patient_id' => $patient1->id,
            'cabinet_id' => $cabinet1->id,
        ]);

        \App\Models\Appointment::create([
            'datetime' => now()->addDays(2),
            'status' => 'scheduled',
            'patient_id' => $patient2->id,
            'cabinet_id' => $cabinet2->id,
        ]);

        \App\Models\Appointment::create([
            'datetime' => now()->subDays(1),
            'status' => 'completed',
            'patient_id' => $patient1->id,
            'cabinet_id' => $cabinet2->id,
        ]);
    }
}
