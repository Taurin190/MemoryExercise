<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyHistory extends Model
{
    protected $primaryKey = ['study_id', 'user_id', 'workbook_id', 'exercise_id'];

    public $incrementing = false;

    protected $fillable = ['score'];

    public static function convertOrm(\App\Domain\StudyHistories $studyHistories)
    {
        StudyHistory::fill($studyHistories->toRecords());
    }
}
