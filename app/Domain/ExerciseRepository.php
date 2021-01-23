<?php

namespace App\Domain;


interface ExerciseRepository
{
    function findByExerciseId($exercise_id);

    function findAllByExerciseIdList($exercise_id_list, $user = null);

    function save(Exercise $exercise);

    function search($text, $page);

    function count($user = null);
}
