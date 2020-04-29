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
}
