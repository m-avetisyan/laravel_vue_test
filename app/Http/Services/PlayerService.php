<?php


namespace App\Http\Services;

use App\Http\Contracts\PlayerInterface;
use App\Player;
use Illuminate\Support\Facades\Auth;

class PlayerService implements PlayerInterface
{
    public function __construct(Player $player)
    {
        $this->player = $player;
    }
    public function index()
    {
        return $this->player->whereHas('team' , function($query)  {
            $query->where('user_id', Auth::user()->id);
        })->with('team')->get();
    }
    public function show($id)
    {
        return $this->player->whereHas('team' , function($query)  {
            $query->where('user_id', Auth::user()->id);
        })->with('team')->where('id',$id)->first();
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
