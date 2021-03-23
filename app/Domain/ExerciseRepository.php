<?php

namespace App\Domain;

interface ExerciseRepository
{
    public function findAll($limit = 10, $user = null, $page = 1);

    public function findByExerciseId($exercise_id, $user_id = null);

    public function findAllByExerciseIdList($exercise_id_list, $user_id = null);

    public function save(Exercise $exercise);

    public function search($text, $page, $limit = 10);

    public function searchCount($text);

    public function count($user = null);

    public function delete($exercise_id);
}
