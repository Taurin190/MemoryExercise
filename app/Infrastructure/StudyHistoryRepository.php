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
        DB::table('study_histories')
            ->select(DB::raw('study_id'))
            ->whereBetween(
                'created_at',
                [
                    $date_since->format("Y-m-d H:i:s"),
                    $date_until->format("Y-m-d H:i:s")
                ]
            );

        return StudySummary::create([
            'exercise_count_in_month' => 3,
            'total_exercise_count' => 3,
            'total_study_days' => 1,
            'start_date' => $date_since,
            'end_date' => $date_until,
            'date_exercise_count_map' => []
        ]);
    }
}
