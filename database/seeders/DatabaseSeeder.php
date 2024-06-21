<?php

namespace Database\Seeders;

use App\Models\Strand;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

      $this->call(UserSeeder::class);
      $this->call(TeacherSeeder::class);
      $this->call(EnrollmentSeeder::class);
      $this->call(RoomSeeder::class);
      $this->call(SectionSeeder::class);
      $this->call(StrandSeeder::class);
      $this->call(SubjectSeeder::class);

    }
}
