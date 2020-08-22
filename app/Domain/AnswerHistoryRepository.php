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

    function getExerciseHistoryByList($user_id, $exercise_list);

    function getExerciseHistoryByUserIdWithinTerm($user_id, $date_since, $date_until);
}
