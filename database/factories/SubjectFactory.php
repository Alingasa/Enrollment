<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\Section;
use App\Models\Strand;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $teachers = Teacher::count();
        $rooms = Room::count();
        $sections = Section::count();
        $strands = Strand::count();
        return [
            //
            'teacher_id' => fake()->numberBetween(1, $teachers),
            'room_id' => fake()->numberBetween(1, $rooms),
            'section_id' =>  fake()->numberBetween(1, $sections),
            'subject_code' => fake()->unique()->numberBetween(1, 10000),
            'subject_title' => fake()->word(),
            'strand_id'     => fake()->numberBetween(1, $strands),
            'subject_type'  => fake()->randomElement(['LECTURE', 'LABORATORY']),
            'units'     => fake()->numberBetween(1, 9),
            'grade_level' => fake()->numberBetween(1, 12),
            'room'          => fake()->numberBetween(1, 10000),
        ];
    }
}
