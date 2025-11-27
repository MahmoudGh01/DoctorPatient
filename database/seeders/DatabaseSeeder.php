<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Cabinet;
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
        // -----------------------------------------
        // 1) Create Admin
        // -----------------------------------------
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);


        // -----------------------------------------
        // 2) Create Doctors (100)
        // -----------------------------------------
        $doctors = User::factory()
            ->count(100)
            ->create([
                'role' => 'doctor',
            ]);


        // -----------------------------------------
        // 3) Create Patients (500)
        // -----------------------------------------
        $patients = User::factory()
            ->count(500)
            ->create([
                'role' => 'patient',
            ]);


        // -----------------------------------------
        // 4) Create Cabinets — ONLY doctors can own cabinets
        // Each doctor gets 1 cabinet
        // -----------------------------------------
        $cabinets = Cabinet::factory()
            ->count(100) // One per doctor
            ->sequence(fn ($sequence) => ['doctor_id' => $doctors[$sequence->index]->id])
            ->create();


        // -----------------------------------------
        // 5) Create Appointments (optional)
        // Random:
        // - patient_id from patients
        // - cabinet_id from cabinets
        // - doctor = cabinet->doctor
        // -----------------------------------------
        Appointment::factory()
            ->count(400)
            ->make() // make instead of create to attach IDs correctly
            ->each(function ($appointment) use ($patients, $cabinets) {

                $cabinet = $cabinets->random();

                $appointment->patient_id = $patients->random()->id;
                $appointment->cabinet_id = $cabinet->id;

                $appointment->save();
            });
    }
}
