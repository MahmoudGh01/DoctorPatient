<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        User::create([
            'name' => 'Mahmoud',
            'email' => 'Mahmoud@gharbi.com',
            'password' => Hash::make('password'),
        ]);

        Cabinet::factory(5)->create();
    }
}
