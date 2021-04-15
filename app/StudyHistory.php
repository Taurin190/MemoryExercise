<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyHistory extends Model
{
    protected $primaryKey = ['study_history_id', 'workbook_id', 'exercise_id'];

    public $incrementing = false;

    protected $fillable = ['score'];
}
