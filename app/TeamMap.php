<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamMap extends Model
{
    protected $table = 'team_map';

    protected $fillable = ['team_id', 'player_id'];

}
