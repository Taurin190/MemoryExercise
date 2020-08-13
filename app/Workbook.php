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
        'title', 'explanation', 'public'
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

    public static function map(\App\Domain\Workbook $workbook) {
        $model = Workbook::find($workbook->getWorkbookId());
        if (is_null($model)) {
            return new Workbook([
                'title' => $workbook->getTitle(),
                'explanation' => $workbook->getExplanation()
            ]);
        }
        return $model->fill([
            'workbook_id' => $workbook->getWorkbookId(),
            'title' => $workbook->getTitle(),
            'explanation' => $workbook->getExplanation()
        ]);
    }
}
