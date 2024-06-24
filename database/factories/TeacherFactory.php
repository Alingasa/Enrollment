<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
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
            'school_id' => uniqid(),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->lastName(),
            'last_name' => fake()->lastName(),
            // 'email' => fake()->unique()->email(),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'contact_number' => fake()->phoneNumber(),
            'barangay' => fake()->address(),
            'municipality' => fake()->address(),
            'province'  => fake()->address(),
            'zip_code' => rand(0000,872632),
            'birthdate' => fake()->date(),
            'guardian_name' => fake()->firstName(). ' '. fake()->lastName(),
        ];
    }
}
