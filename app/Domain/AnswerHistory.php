<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/07/24
 * Time: 8:54
 */

namespace App\Domain;


class AnswerHistory
{
    private $answer_history_id;

    private $exercise_id;

    private $user_id;

    private $created_at;

    public static function map(Answer $answer) {
        return new AnswerHistory();
    }

    public function getWorkbookHistory() {
        return new WorkbookHistory();
    }

    public function getExerciseHistoryList() {
        return [];
    }
}
