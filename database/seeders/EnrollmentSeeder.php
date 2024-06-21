<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use Database\Factories\EnrollmentFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enrollment::factory(500)->create();
    }
}
