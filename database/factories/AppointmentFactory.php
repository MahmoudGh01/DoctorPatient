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
            'datetime' => $this->faker->dateTimeBetween('+1 days', '+1 month'),

            'status' => $this->faker->randomElement(['scheduled', 'completed', 'canceled']),
            'patient_id' => $this->faker->numberBetween(1, 5),
            'cabinet_id' => $this->faker->numberBetween(1, 5),

        ];
    }
}
