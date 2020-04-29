<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $primaryKey = 'exercise_id';
    protected $fillable = [
        'question', 'answer',
    ];
    public function workbooks()
    {
        return $this->belongsToMany('App\Workbook');
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
            'question' => $exercise->getQuestion(),
            'answer' => $exercise->getAnswer()
        ]);
    }
}
