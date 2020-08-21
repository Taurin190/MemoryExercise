<?php
namespace App\Infrastructure;

use App\Domain\Exercise;
use App\Exceptions\DataNotFoundException;

class ExerciseRepository implements \App\Domain\ExerciseRepository
{
    function findByExerciseId($exercise_id, $user = null)
    {
        $domain = null;
        if (isset($user)) {
            $domain = \App\Exercise::where('exercise_id', $exercise_id)
                ->where('permission', 1)->orWhere(function ($query) use ($user, $exercise_id) {
                    $query->where('exercise_id', $exercise_id)
                        ->where('author_id', $user->getKey());
                });
        } else {
            $domain = \App\Exercise::where('exercise_id', $exercise_id)->where('permission', 1);
        }
        if (is_null($domain)) {
            throw new DataNotFoundException("Data not found in exercises by id: " . $exercise_id);
        }
        return Exercise::map($domain->first());
    }

    function findAllByExerciseIdList($exercise_id_list, $user = null)
    {
        $domain_list = [];
        if (isset($user)) {
            $exercise_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)->where('permission', 1)
                ->orWhere(function ($query) use ($user, $exercise_id_list){
                    $query->whereIn('exercise_id', $exercise_id_list)->where('author_id', $user->getKey());
                })->get();
        } else {
            $exercise_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)->where('permission', 1)->get();
        }
        foreach ($exercise_list as $exercise) {
            $domain_list[] = Exercise::map($exercise);
        }
        return $domain_list;
    }

    function save(Exercise $exercise)
    {
        \App\Exercise::map($exercise)->save();
    }

    function findAll($limit = 10, $user = null)
    {
        if (isset($user)) {
            return \App\Exercise::where('permission', 1)
                ->orWhere("author_id", $user->getKey())->take($limit)->get();
        } else {
            return \App\Exercise::where('permission', 1)->take($limit)->get();
        }
    }

    function search($text, $page){
        return \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)->get();
    }
}
