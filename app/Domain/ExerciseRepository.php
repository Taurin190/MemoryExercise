<?php

namespace App\Domain;

interface ExerciseRepository
{
    public function findAll($limit = 10, $user = null, $page = 1);

    public function findByExerciseId($exercise_id, $user_id = null): Exercise;

    public function findAllByExerciseIdList($exercise_id_list, $user_id = null): Exercises;

    public function save(Exercise $exercise): void;

    public function search(string $text, $user = null, int $page = 1, int $limit = 10);

    public function searchCount(string $text): int;

    public function count($user = null): int;

    public function delete($exercise_id): void;
}
