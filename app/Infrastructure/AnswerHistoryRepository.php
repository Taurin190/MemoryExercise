<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/02
 * Time: 7:48
 */

namespace App\Infrastructure;


use App\Domain\AnswerHistory;
use App\Exercise;
use App\ExerciseHistory;
use App\WorkbookHistory;
use App\User;

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

    function getExerciseHistoryByList($user_id, $exercise_list) {
        $exercise_id_list = [];
        foreach ($exercise_list as $exercise) {
            $exercise_id_list[] = $exercise->getKey();
        }
        return ExerciseHistory::where('user_id', $user_id)->whereIn('exercise_id', $exercise_id_list)->get();
    }

    function getExerciseHistoryByUserIdWithinTerm($user_id, $date_since, $date_until)
    {
        $query = ExerciseHistory::where('user_id', $user_id);
        if (isset($date_since) and isset($date_until)) {
            $query->whereBetween('created_at', [$date_since, $date_until]);
        } else if (isset($date_since)) {
            $query->where('created_at', '>', $date_since);
        } else if (isset($date_until)) {
            $query->where('created_at', '<', $date_until);
        } else {
          // ToDo 現在から一ヶ月前の範囲で取得する
        }
    }
}
