<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';

    protected $fillable = ['name', 'cost', 'total', 'male', 'female', 'score', 'user_id'];

    public function players(){
        return $this->hasMany('App\TeamMap');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
