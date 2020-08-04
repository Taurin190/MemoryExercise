<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/02
 * Time: 7:48
 */

namespace App\Infrastructure;


use App\Domain\AnswerHistory;
use App\ExerciseHistory;
use App\WorkbookHistory;

class AnswerHistoryRepository implements \App\Domain\AnswerHistoryRepository
{

    function save(AnswerHistory $answerHistory)
    {
        $workbook_history = $answerHistory->getWorkbookHistory();
        $exercise_history_list = $answerHistory->getExerciseHistoryList();
        $workbook_history_model = WorkbookHistory::map($workbook_history);
        $workbook_history_model->user()->associate($workbook_history->getUser());
        $workbook_history_model->workbook()->associate(\App\Workbook::map($workbook_history->getWorkbook()));

        $workbook_history_model->save();
        foreach ($exercise_history_list as $exercise_history) {
            $exercise_history_model = ExerciseHistory::map($exercise_history);
            $exercise_history_model->user()->associate($exercise_history->getUser());
            $exercise_history_model->exercise()->associate(\App\Exercise::map($exercise_history->getExercise()));
            $exercise_history_model->save();
        }
    }
}
