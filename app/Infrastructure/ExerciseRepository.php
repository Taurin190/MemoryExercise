<?php
namespace App\Infrastructure;

use App\Domain\Exercise;
use App\Exceptions\DataNotFoundException;

class ExerciseRepository implements \App\Domain\ExerciseRepository
{
    function findByExerciseId($exercise_id)
    {
        $domain = \App\Exercise::where('exercise_id', $exercise_id);
        if (is_null($domain)) {
            throw new DataNotFoundException("Data not found in exercises by id: " . $exercise_id);
        }
        return Exercise::map($domain->first());
    }

    function save(Exercise $exercise)
    {
        \App\Exercise::map($exercise)->save();
    }
}
