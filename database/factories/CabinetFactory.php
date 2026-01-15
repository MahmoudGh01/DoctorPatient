<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cabinet>
 */
class CabinetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $specialties = [
            'Cardiology',
            'Dermatology',
            'Neurology',
            'Pediatrics',
            'Orthopedics',
            'Ophthalmology',
            'Gastroenterology',
            'Urology',
            'Endocrinology',
            'Radiology',
            'ENT (Otolaryngology)',
            'Oncology',
            'Rheumatology',
            'Pulmonology',
            'General Surgery',
            'Nephrology',
            'Allergy & Immunology',
            'Family Medicine',
            'Internal Medicine',
            'Psychiatry'
        ];

        $specialty = $this->faker->randomElement($specialties);

        return [
            'name' => $specialty . ' Clinic',
            'location' => $this->faker->address(),
            'doctor_id' => $this->faker->numberBetween(1, 5),
        ];
    }

}
