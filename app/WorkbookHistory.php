<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkbookHistory extends Model
{
    protected $primaryKey = 'exercise_history_id';

    protected $fillable = [
        'exercise_count', 'ok_count', 'ng_count', 'studying_count'
    ];

    public function workbook() {
        return $this->hasOne('\App\Workbook');
    }

    public function user() {
        return $this->hasOne('\App\User');
    }
}
