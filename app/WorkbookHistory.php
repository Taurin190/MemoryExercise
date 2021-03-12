<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkbookHistory extends Model
{
    protected $primaryKey = 'workbook_history_id';

    protected $fillable = [
        'exercise_count', 'ok_count', 'ng_count', 'studying_count'
    ];

    public function workbook() {
        return $this->belongsTo('\App\Workbook', 'workbook_id', 'workbook_id');
    }

    public function user() {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public static function convertOrm(\App\Domain\WorkbookHistory $workbookHistory) {
        $model = WorkbookHistory::find($workbookHistory->getWorkbookHistoryId());
        if (is_null($model)) {
            return new WorkbookHistory([
                'exercise_count' => $workbookHistory->getExerciseCount(),
                'ok_count' => $workbookHistory->getOKCount(),
                'ng_count' => $workbookHistory->getNGCount(),
                'studying_count' => $workbookHistory->getStudyingCount()
            ]);
        }
        return $model->fill([
            'workbook_history_id' => $$workbookHistory->getWorkbookHistoryId(),
            'exercise_count' => $workbookHistory->getExerciseCount(),
            'ok_count' => $workbookHistory->getOKCount(),
            'ng_count' => $workbookHistory->getNGCount(),
            'studying_count' => $workbookHistory->getStudyingCount()
        ]);
    }
}
