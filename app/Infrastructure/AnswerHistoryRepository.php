<?php
/**
 * Created by IntelliJ IDEA.
 * User: koichi.taura
 * Date: 2020/08/02
 * Time: 7:48
 */

namespace App\Infrastructure;


use App\Domain\AnswerHistory;
use App\Domain\ExerciseDailyTable;
use App\Exercise;
use App\ExerciseHistory;
use App\WorkbookHistory;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;

class AnswerHistoryRepository implements \App\Domain\AnswerHistoryRepository
{
    const DATE_FORMAT = "Y-m-d H:i:s";

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
            $exercise_history_model->exercise()->associate(\App\Exercise::convertOrm($exercise_history->getExercise()));
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

    private function createQueryByUserWithinTerm($user_id, DateTime $date_since = null, DateTime $date_until = null) {
        $query = ExerciseHistory::where('user_id', $user_id);
        if (isset($date_since) and isset($date_until)) {
            $query->whereBetween('created_at', [$date_since->format(self::DATE_FORMAT), $date_until->format(self::DATE_FORMAT)]);
        } else if (isset($date_since)) {
            $last_month_from_target = $date_since;
            $last_month_from_target->modify('-1 month');
            $query->whereBetween('created_at', [$date_since->format(self::DATE_FORMAT), $last_month_from_target->format(self::DATE_FORMAT)]);
        } else if (isset($date_until)) {
            $query->where('created_at', '<', $date_until->format(self::DATE_FORMAT));
        } else {
            $now = new DateTime();
            $last_month = new DateTime();
            $last_month->modify('-1 month');
            $query->whereBetween('created_at', [$last_month->format(self::DATE_FORMAT), $now->format(self::DATE_FORMAT)]);
        }
        return $query;
    }

    function getExerciseHistoryByUserIdWithinTerm($user_id, DateTime $date_since = null, DateTime $date_until = null)
    {
        $query = $this->createQueryByUserWithinTerm($user_id, $date_since, $date_until);
        $exercise_history_list = $query->get();
        $exercise_history_domain_list = [];
        foreach ($exercise_history_list as $exercise_history) {
            $exercise_history_domain_list[] = \App\Domain\ExerciseHistory::map($exercise_history);
        }
        return $exercise_history_domain_list;
    }

    function getExerciseHistoryCountByUserIdWithinTerm($user_id, DateTime $date_since = null, DateTime $date_until = null)
    {
        $query = $this->createQueryByUserWithinTerm($user_id, $date_since, $date_until);
        return $query->count();
    }

    function getExerciseHistoryDailyCountTableWithinTerm($user_id, DateTime $date_since = null, DateTime $date_until = null)
    {
        $query = $this->createQueryByUserWithinTerm($user_id, $date_since, $date_until);
        $query->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as Date, count(created_at) as days"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"));
        $exercise_date_count_list = $query->get();
        if (is_null($date_since)) {
            $date_since = new DateTime();
            $date_since->modify('-1 month');
        }
        if (is_null($date_until)) {
            $date_until = new DateTime();
        }

        $exercise_daily_table = new ExerciseDailyTable(clone $date_since, clone $date_until);
        foreach ($exercise_date_count_list as $exercise_date_count) {
            $exercise_daily_table->addCount($exercise_date_count);
        }
        return $exercise_daily_table;
    }

    function getExerciseHistoryTotalCount($user_id)
    {
        $query = ExerciseHistory::where('user_id', $user_id);
        return $query->count();
    }
    function getExerciseHistoryTotalDays($user_id)
    {
        $query = ExerciseHistory::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as Date, count(created_at) as days"))
            ->where('user_id', $user_id)
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"));
        return $query->get()->count();
    }
}
