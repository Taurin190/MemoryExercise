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

    private $workbook_history;

    private $exercise_history_list;

    private function __construct($workbook, $exercise_list)
    {
        $this->workbook_history = WorkbookHistory::map($workbook);
        $this->exercise_history_list = [];
        foreach ($exercise_list as $exercise) {
            $this->exercise_history_list[] = ExerciseHistory::map($exercise);
        }
    }

    public static function map(Answer $answer) {
        return new AnswerHistory($answer->getWorkbook(), $answer->getExerciseList());
    }

    public function getWorkbookHistory() {
        return $this->workbook_history;
    }

    public function getExerciseHistoryList() {
        return $this->exercise_history_list;
    }
}
