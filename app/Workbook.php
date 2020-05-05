<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workbook extends Model
{
    protected $primaryKey = 'workbook_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'title', 'explanation',
    ];
    public function exercises()
    {
        return $this->belongsToMany('App\Exercise');
    }
}
