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

    function findAllByExerciseIdList($exercise_id_list)
    {
        return \App\Exercise::whereIn('exercise_id', $exercise_id_list)->get();
    }

    function save(Exercise $exercise)
    {
        \App\Exercise::map($exercise)->save();
    }

    function findAll()
    {
        return \App\Exercise::take(10)->get();
    }

    function search($text, $page){
        return \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)->get();
    }
}
