<?php


namespace App\Http\Services;

use App\Http\Contracts\PlayerInterface;
use App\Player;
use App\Team;
use Illuminate\Support\Facades\Auth;

class PlayerService implements PlayerInterface
{
    public function __construct(Player $player, Team $team)
    {
        $this->player = $player;
        $this->team = $team;
    }
    public function index()
    {

        return $this->team->where('user_id',Auth::user()->id)->with('player')->get();
    }
    public function show($id)
    {
        return $this->team->where('user_id',Auth::user()->id)->with('player')->where('id',$id)->first();
    }
    public function create($credentials)
    {
        return $this->player->create($credentials);
    }

    public function update($credentials,$id)
    {
        return $this->player->where('id', $id)->update($credentials);
    }

}
