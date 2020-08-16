<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $primaryKey = 'label_id';

    protected $fillable = ['name'];

    public function exercises()
    {
        return $this->belongsToMany('App\Exercise', 'exercise_label', 'exercise_id', 'label_id');
    }
}
