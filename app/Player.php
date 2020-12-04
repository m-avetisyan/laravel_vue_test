<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name', 'description','team_id'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

}
