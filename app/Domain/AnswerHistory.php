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

    private function __construct($answer, $workbook, $user)
    {
        $this->workbook_history = WorkbookHistory::map($answer, $workbook, $user);
        $this->exercise_history_list = [];
        $exercise_map = $answer->getExerciseMap();
        //TODO ExerciseListの使い方を修正する
        foreach ($workbook->getExerciseList() as $exercise) {
            $this->exercise_history_list[] = ExerciseHistory::create(
                $user,
                $exercise,
                $exercise_map[$exercise->getExerciseId()]
            );
        }
    }

    public static function map(Answer $answer, Workbook $workbook, $user) {
        return new AnswerHistory($answer, $workbook, $user);
    }

    public function getWorkbookHistory() {
        return $this->workbook_history;
    }

    public function getExerciseHistoryList() {
        return $this->exercise_history_list;
    }
}
