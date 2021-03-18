<?php

namespace App\Domain;

interface ExerciseRepository
{
    function findAll($limit = 10, $user = null, $page = 1);

    function findByExerciseId($exercise_id, $user_id = null);

    function findAllByExerciseIdList($exercise_id_list, $user_id = null);

    function save(Exercise $exercise);

    function search($text, $page, $limit = 10);

    function searchCount($text);

    function count($user = null);

    function checkEditPermission($exercise_id, $user_id);

    function delete($exercise_id);
}
