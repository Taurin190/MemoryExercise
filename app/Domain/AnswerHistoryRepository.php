<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/27
 * Time: 21:27
 */

namespace App\Domain;

use DateTime;

interface AnswerHistoryRepository
{
    public function save(AnswerHistory $answerHistory);

    public function getExerciseHistoryByList($user_id, $exercise_list);

    public function getExerciseHistoryByUserIdWithinTerm($user_id, DateTime $date_since, DateTime $date_until);

    public function getExerciseHistoryCountByUserIdWithinTerm($user_id, DateTime $date_since, DateTime $date_until);

    public function getExerciseHistoryDailyCountTableWithinTerm($user_id, DateTime $date_since, DateTime $date_until);

    public function getExerciseHistoryTotalCount($user_id);

    public function getExerciseHistoryTotalDays($user_id);
}
