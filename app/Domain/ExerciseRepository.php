<?php

namespace App\Domain;


interface ExerciseRepository
{
    function findByExerciseId($exercise_id);

    function save(Exercise $exercise);

    function search($text, $page);
}
