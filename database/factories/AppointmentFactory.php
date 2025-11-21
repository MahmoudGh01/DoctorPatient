<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'datetime' => fake()->dateTimeBetween('+1 days', '+1 month'),

            'status' => fake()->randomElement(['scheduled', 'completed', 'canceled']),
            'patient_id' => fake()->numberBetween(1, 5),
            'cabinet_id' => fake()->numberBetween(1, 5),

        ];
    }
}
