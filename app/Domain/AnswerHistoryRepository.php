<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/27
 * Time: 21:27
 */

namespace App\Domain;
use App\User;
use DateTime;

interface AnswerHistoryRepository
{
    function save(AnswerHistory $answerHistory);

    function getExerciseHistoryByList($user_id, $exercise_list);

    function getExerciseHistoryByUserIdWithinTerm($user_id, DateTime $date_since, DateTime $date_until);

    function getExerciseHistoryCountByUserIdWithinTerm($user_id, DateTime $date_since, DateTime $date_until);

    function getExerciseHistoryDailyCountTableWithinTerm($user_id, DateTime $date_since, DateTime $date_until);

    function getExerciseHistoryTotalCount($user_id);

    function getExerciseHistoryTotalDays($user_id);
}
