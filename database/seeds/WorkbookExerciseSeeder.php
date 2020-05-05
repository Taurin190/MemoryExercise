<?php

use Illuminate\Database\Seeder;

class WorkbookExerciseSeeder extends Seeder
{
    public function run() {
        $workbook_exercises =
            [
                [
                    'workbook_id' => 'test1',
                    'exercise_id' => 'exercise1',
                ],
                [
                    'workbook_id' => 'test2',
                    'exercise_id' => 'exercise1',
                ],
                [
                    'workbook_id' => 'test3',
                    'exercise_id' => 'exercise1',
                ],
                [
                    'workbook_id' => 'test2',
                    'exercise_id' => 'exercise2',
                ],
                [
                    'workbook_id' => 'test3',
                    'exercise_id' => 'exercise2',
                ],
                [
                    'workbook_id' => 'test3',
                    'exercise_id' => 'exercise3',
                ],
            ];
        foreach ($workbook_exercises as $workbook_exercise) {
            DB::table('workbook_exercise')->insert($workbook_exercise);
        }
    }
}
