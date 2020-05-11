<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $primaryKey = 'exercise_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'question', 'answer',
    ];
    public function workbooks()
    {
        return $this->belongsToMany('App\Workbook');
    }
    public function answerHistories()
    {
        return $this->hasMany('App\AnswerHistory');
    }

    public static function map(\App\Domain\Exercise $exercise) {
        $model = Exercise::find($exercise->getExerciseId());
        if (is_null($model)) {
            return new Exercise([
                'question' => $exercise->getQuestion(),
                'answer' => $exercise->getAnswer()
            ]);
        }
        return $model->fill([
            'exercise_id' => $exercise->getExerciseId(),
            'question' => $exercise->getQuestion(),
            'answer' => $exercise->getAnswer()
        ]);
    }
}
