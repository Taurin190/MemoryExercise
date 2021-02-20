<?php
namespace App\Infrastructure;

use App\Domain\Exercise;
use App\Exceptions\DataNotFoundException;

class ExerciseRepository implements \App\Domain\ExerciseRepository
{
    function findByExerciseId($exercise_id, $user_id = null)
    {
        $domain = null;
        if (isset($user_id)) {
            $domain = \App\Exercise::where('exercise_id', $exercise_id)
                ->where('permission', 1)->orWhere(function ($query) use ($user_id, $exercise_id) {
                    $query->where('exercise_id', $exercise_id)
                        ->where('author_id', $user_id);
                });
        } else {
            $domain = \App\Exercise::where('exercise_id', $exercise_id)->where('permission', 1);
        }
        if (is_null($domain)) {
            throw new DataNotFoundException("Data not found in exercises by id: " . $exercise_id);
        }
        return Exercise::convertDomain($domain->first());
    }

    function findAllByExerciseIdList($exercise_id_list, $user_id = null)
    {
        $domain_list = [];
        if (isset($user_id)) {
            $exercise_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)->where('permission', 1)
                ->orWhere(function ($query) use ($user_id, $exercise_id_list){
                    $query->whereIn('exercise_id', $exercise_id_list)->where('author_id', $user_id);
                })->get();
        } else {
            $exercise_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)->where('permission', 1)->get();
        }
        foreach ($exercise_list as $exercise) {
            $domain_list[] = Exercise::convertDomain($exercise);
        }
        return $domain_list;
    }

    function save(Exercise $exercise)
    {
        \App\Exercise::convertOrm($exercise)->save();
    }

    function findAll($limit = 10, $user = null, $page = 1)
    {
        // TODO 引数を整える
        if (isset($user)) {
            return $exercise_list = \App\Exercise::where('permission', 1)
                ->orWhere("author_id", $user->getKey())->skip($limit * ($page - 1))->take($limit)->get();
        } else {
            return \App\Exercise::where('permission', 1)->skip($limit * ($page - 1))->take($limit)->get();
        }
    }

    function count($user = null)
    {
        if (isset($user)) {
            return \App\Exercise::where('permission', 1)
                ->orWhere("author_id", $user->getKey())->count();
        }
        return \App\Exercise::where('permission', 1)->count();
    }

    function search($text, $page){
        // TODO 引数を整える
        return \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)
            ->skip(10 * ($page - 1))->take(10)->get();
    }

    function searchCount($text) {
        return \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)->count();
    }

    function checkEditPermission($exercise_id, $user_id) {
        $target_exercise = \App\Exercise::select(['author_id'])->where('exercise_id', $exercise_id)->first();
        if ($target_exercise->author_id == $user_id) return true;
        return false;
    }

    function delete($exercise_id) {
        \App\Exercise::where('exercise_id', $exercise_id)->delete();
    }
}
