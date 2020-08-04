<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseHistory extends Model
{
    protected $primaryKey = 'exercise_history_id';

    protected $fillable = [
        'score'
    ];

    public function exercise() {
        return $this->belongsTo('\App\Exercise', 'exercise_id');
    }

    public function user() {
        return $this->belongsTo('\App\User', 'user_id', 'id');
    }

    public static function map(\App\Domain\ExerciseHistory $exerciseHistory) {
        $model = ExerciseHistory::find($exerciseHistory->getExerciseHistoryId());
        if (is_null($model)) {
            return new ExerciseHistory([
                'score' => $exerciseHistory->getScore()
            ]);
        } else {
            return $model->fill([
                'exercise_history_id' => $exerciseHistory->getExerciseHistoryId(),
                'score' => $exerciseHistory->getScore()
            ]);
        }
    }
}
