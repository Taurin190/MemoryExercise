<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class Workbook extends Model
{
    protected $primaryKey = 'workbook_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'title', 'explanation', 'permission', 'author_id'
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

    public function exercises()
    {
        return $this->belongsToMany('App\Exercise', 'workbook_exercise', 'workbook_id', 'exercise_id');
    }

    public static function convertOrm(\App\Domain\Workbook $workbook)
    {
        $model = Workbook::find($workbook->getWorkbookId());
        if (is_null($model)) {
            $workbook_dto = $workbook->getWorkbookDto();
            return new Workbook([
                'title' => $workbook_dto->title,
                'explanation' => $workbook_dto->explanation,
                'author_id' => $workbook_dto->user_id
            ]);
        }
        $workbook_dto = $workbook->getWorkbookDto();
        return $model->fill([
            'workbook_id' => $workbook_dto->workbook_id,
            'title' => $workbook_dto->title,
            'explanation' => $workbook_dto->explanation,
            'author_id' => $workbook_dto->user_id
        ]);
    }
}
