<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(WorkbookSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(WorkbookExerciseSeeder::class);
    }
}
