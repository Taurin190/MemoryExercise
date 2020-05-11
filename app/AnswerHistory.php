<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnswerHistory extends Model
{
    protected $primaryKey = 'answer_history_id';

    protected $fillable = [
        'answer', 'score'
    ];
    public function exercise()
    {
        return $this->belongsTo('App\Exercise', 'exercise_id');
    }
    public function workbook()
    {
        return $this->belongsTo('App\Workbook', 'workbook_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
