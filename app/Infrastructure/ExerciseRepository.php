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
        $domain_list = [];
        $exercise_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)->get();
        foreach ($exercise_list as $exercise) {
            $domain_list[] = Exercise::map($exercise);
        }
        return $domain_list;
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
