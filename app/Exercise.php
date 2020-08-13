<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Exercise extends Model
{
    protected $primaryKey = 'exercise_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'question', 'answer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::generate()->string;
        });
    }

    public function user()
    {
        return $this->belongsTo('\App\User', 'author_id', 'id');
    }
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
