<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $primaryKey = 'user_id';

    protected $fillable = ['objective'];

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'user_id');
    }
}
