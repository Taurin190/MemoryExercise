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
        'question', 'answer', 'permission', 'author_id'
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
    public function labels()
    {
        return $this->belongsToMany('App\Label');
    }

    public static function convertOrm(Domain\Exercise $exercise)
    {
        $dto = $exercise->getExerciseDto();
        $exercise_orm = null;
        if (isset($dto->exercise_id)) {
            $exercise_orm = Exercise::find($dto->exercise_id);
        }
        if (is_null($exercise_orm)) {
            return new Exercise($dto->toArray());
        }
        return $exercise_orm->fill($dto->toArray());
    }
}
