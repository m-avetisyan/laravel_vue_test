<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'parent_id','user_id'
    ];

    public function subOptions()
    {
        return $this->hasMany(Team::class,'parent_id')->with('subOptions');
    }
    public function player()
    {
        return $this->hasMany(Player::class,'team_id');
    }

}
