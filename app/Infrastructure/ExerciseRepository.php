<?php
namespace App\Infrastructure;

use App\Domain\Exercise;

class ExerciseRepository implements \App\Domain\ExerciseRepository
{
    function findByExerciseId($exercise_id)
    {
        $domain = \App\Exercise::find($exercise_id)->first();
        return Exercise::map($domain);
    }

    function save(Exercise $exercise)
    {
    }
}
