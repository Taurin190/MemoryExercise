<?php

use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{
    public function run() {
        $exercises =
            [
                [
                    'exercise_id' => 'exercise1',
                    'question' => 'Is this a dog?',
                    'answer' => 'Yes, it is',
                ],
                [
                    'exercise_id' => 'exercise2',
                    'question' => 'Is this a cat?',
                    'answer' => 'No, it isn\'t.',
                ],
                [
                    'exercise_id' => 'exercise3',
                    'question' => 'Is this a pencil?',
                    'answer' => 'Yes, it is',
                ],
            ];
        foreach ($exercises as $exercise) {
            DB::table('exercises')->insert($exercise);
        }
    }
}
