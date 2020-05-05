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
        $this->call(WorkbookTableSeeder::class);
        $this->call(ExerciseTableSeeder::class);
        $this->call(WorkbookExerciseTableSeeder::class);
    }
}
