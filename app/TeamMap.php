<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMap extends Model
{
    protected $table = 'team_map';

    protected $fillable = ['team_id', 'player_id'];

    public function team(){
        return $this->belongsTo('App\Team');
    }

    public function player(){
        return $this->belongsTo('App\Player');
    }
}
