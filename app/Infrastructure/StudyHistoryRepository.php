<?php

namespace App\Infrastructure;

use App\Domain\StudyHistories;
use App\StudyHistory;
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
}
