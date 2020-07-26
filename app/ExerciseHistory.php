<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseHistory extends Model
{
    protected $primaryKey = 'exercise_history_id';

    protected $fillable = [
        'score'
    ];

    public function exercise() {
        return $this->hasOne('\App\Exercise');
    }

    public function user() {
        return $this->hasOne('\App\User');
    }
}