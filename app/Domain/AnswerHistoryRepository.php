<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/27
 * Time: 21:27
 */

namespace App\Domain;
use App\User;

interface AnswerHistoryRepository
{
    function save(AnswerHistory $answerHistory);

    function getExerciseHistoryByList(User $user, $exercise_list);
}
