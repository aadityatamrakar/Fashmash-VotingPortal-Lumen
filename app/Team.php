<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'team';

    protected $fillable = ['name', 'cost', 'total', 'male', 'female', 'score', 'user_id'];

}
