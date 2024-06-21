<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'grade_level' => random_int(7, 12),
            // 'school_id'   => fake()->random_int(00021, 999999),
            'first_name'  => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name'   => fake()->lastName(),
            'email'       => fake()->unique()->email(),
            'birthdate'   => fake()->date(),
            'gender'      => fake()->randomElement(['Male', 'Female']),
            'civil_status' => random_int(1, 6),
            'contact_number' => fake()->phoneNumber(),
            'religion'       => fake()->randomElement(['Roman Catholic', 'Muslim', 'Protestant']),
            'facebook_url'  => fake()->url(),
            'incaseof_emergency'  => random_int(0111, 9999999),
            'purok'               => fake()->word(),
            'sitio_street'               => fake()->word(),
            'barangay'            => fake()->address(),
            'municipality'        => fake()->streetAddress(),
            'province'            => fake()->address(),
            'zip_code'            => random_int(200, 900),
            'guardian_name'        => fake()->firstNameFemale(),

        ];
    }
}
