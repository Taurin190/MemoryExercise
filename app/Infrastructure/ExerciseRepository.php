<?php
namespace App\Infrastructure;

use App\Domain\Exercise;
use App\Domain\Exercises;
use App\Domain\SearchExerciseList;
use App\Exceptions\DataNotFoundException;

class ExerciseRepository implements \App\Domain\ExerciseRepository
{
    function findByExerciseId($exercise_id, $user_id = null)
    {
        $orm = null;
        if (isset($user_id)) {
            $orm = \App\Exercise::where('exercise_id', $exercise_id)
                ->where('permission', 1)->orWhere(function ($query) use ($user_id, $exercise_id) {
                    $query->where('exercise_id', $exercise_id)
                        ->where('author_id', $user_id);
                });
        } else {
            $orm = \App\Exercise::where('exercise_id', $exercise_id)->where('permission', 1);
        }
        if (is_null($orm->first())) {
            throw new DataNotFoundException("Data not found in exercises by id: " . $exercise_id);
        }
        return Exercise::convertDomain($orm->first());
    }

    function findAllByExerciseIdList($exercise_id_list, $user_id = null)
    {
        if (isset($user_id)) {
            $exercise_orm_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)->where('permission', 1)
                ->orWhere(function ($query) use ($user_id, $exercise_id_list) {
                    $query->whereIn('exercise_id', $exercise_id_list)->where('author_id', $user_id);
                })->get();
        } else {
            $exercise_orm_list = \App\Exercise::whereIn('exercise_id', $exercise_id_list)
                ->where('permission', 1)
                ->get();
        }

        $domain_list = Exercises::convertByOrmList($exercise_orm_list);
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

    function search($text, $user = null, $page = 1, $limit = 10)
    {
        if (mb_strlen($text) < 2) {
            $count = $this->count($user);
            $exercise_orm_list = $this->findAll($limit, $user, $page);
            return new SearchExerciseList(
                Exercises::convertByOrmList($exercise_orm_list),
                $count,
                $page,
                $text
            );
        }
        $count = $this->searchCount($text);
        $exercise_orm_list = \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)
            ->skip($limit * ($page - 1))->take($limit)->get();
        return new SearchExerciseList(
            Exercises::convertByOrmList($exercise_orm_list),
            $count,
            $page,
            $text
        );
    }

    function searchCount($text)
    {
        return \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)->count();
    }

    function checkEditPermission($exercise_id, $user_id)
    {
        $target_exercise = \App\Exercise::select(['author_id'])->where('exercise_id', $exercise_id)->first();
        //TODO 判断をインフラ層で行っているためドメインに移す
        if ($target_exercise->author_id == $user_id) {
            return true;
        }
        return false;
    }

    function delete($exercise_id)
    {
        \App\Exercise::where('exercise_id', $exercise_id)->delete();
    }
}
