<?php
namespace App\Infrastructure;

use App\Domain\Exercise;
use App\Domain\Exercises;
use App\Domain\SearchExerciseList;
use App\Exceptions\DataNotFoundException;

class ExerciseRepository implements \App\Domain\ExerciseRepository
{
    public function findByExerciseId($exercise_id, $user_id = null): Exercise
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

    public function findAllByExerciseIdList($exercise_id_list, $user_id = null): Exercises
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

    public function save(Exercise $exercise): void
    {
        \App\Exercise::convertOrm($exercise)->save();
    }

    public function findExercises($limit = 10, $user = null, $page = 1): Exercises
    {
        // TODO 引数を整える
        $exercise_list = null;
        if (isset($user)) {
            $exercise_list = \App\Exercise::where('permission', 1)
                ->orWhere("author_id", $user->getKey())->skip($limit * ($page - 1))->take($limit)->get();
        } else {
            $exercise_list = \App\Exercise::where('permission', 1)->skip($limit * ($page - 1))->take($limit)->get();
        }
        return Exercises::convertByOrmList($exercise_list);
    }

    public function count($user = null): int
    {
        if (isset($user)) {
            return \App\Exercise::where('permission', 1)
                ->orWhere("author_id", $user->getKey())->count();
        }
        return \App\Exercise::where('permission', 1)->count();
    }

    public function search(string $text, $user = null, int $page = 1, int $limit = 10)
    {
        if (mb_strlen($text) < 2) {
            $count = $this->count($user);
            $exercises_orm = $this->findExercises($limit, $user, $page);
            return new SearchExerciseList(
                $exercises_orm,
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

    public function searchCount(string $text): int
    {
        return \App\Exercise::whereRaw("match(`question`) against (? IN NATURAL LANGUAGE MODE)", $text)->count();
    }

    public function delete($exercise_id): void
    {
        \App\Exercise::where('exercise_id', $exercise_id)->delete();
    }
}
