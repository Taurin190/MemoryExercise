<?php

namespace App\Infrastructure;

use App\Domain\StudyHistories;
use App\Domain\StudySummary;
use App\StudyHistory;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudyHistoryRepository implements \App\Domain\StudyHistoryRepository
{

    public function save(StudyHistories $studyHistories): void
    {
        DB::beginTransaction();
        try {
            $study_id = StudyHistory::max('study_id');
            if (is_null($study_id)) {
                $study_id = 0;
            }
            $study_id += 1;
            $studyHistories->setStudyId($study_id);
            StudyHistory::insert($studyHistories->toRecords());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("DB Exception: " . $e);
        }
    }

    public function inquireStudySummary($user_id, DateTime $date_since, DateTime $date_until): StudySummary
    {
        $exerciseCountInMonth = DB::table('study_histories')
            ->select('study_id')
            ->where('user_id', $user_id)
            ->whereBetween(
                'created_at',
                [
                    $date_since->format("Y-m-d H:i:s"),
                    $date_until->format("Y-m-d H:i:s")
                ]
            )->count();
        $countsSinceStart = DB::table('study_histories')
            ->select(DB::raw("count(exercise_id) as exercise_count, count(distinct DATE_FORMAT(created_at, '%Y-%m-%d')) as total_study_days"))
            ->where('user_id', $user_id)
            ->first();
        $exerciseDate = DB::table('study_histories')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as Date, count(created_at) as days"))
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
            ->where('user_id', $user_id)
            ->whereBetween(
                'created_at',
                [
                    $date_since->format("Y-m-d H:i:s"),
                    $date_until->format("Y-m-d H:i:s")
                ]
            )->get();

        return StudySummary::createFromRepository([
            'exercise_count_in_month' => $exerciseCountInMonth,
            'total_exercise_count' => $countsSinceStart->exercise_count,
            'total_study_days' => $countsSinceStart->total_study_days,
            'start_date' => $date_since,
            'end_date' => $date_until,
            'date_exercise_count_orm' => $exerciseDate
        ]);
    }
}
