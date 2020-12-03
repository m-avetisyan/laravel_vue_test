<?php


namespace App\Http\Services;

use App\Http\Contracts\TeamInterface;
use App\Team;
use Illuminate\Support\Facades\Auth;

class TeamService implements TeamInterface
{
    public function __construct(Team $team)
    {
        $this->team = $team;
    }
    public function index()
    {
        $teams = $this->team->where('user_id',Auth::user()->id)->whereNull('parent_id')
            ->with('subOptions')
            ->get();
        return $teams;

    }
    public function show($teamID)
    {

        return $this->team->where('user_id',Auth::user()->id)->with('player')->find($teamID);
    }
    public function create($credentials)
    {
        return $this->team->create($credentials);
    }

    public function update($credentials,$id)
    {
        return $this->team->where('id', $id)->update($credentials);
    }
    public function delete($id)
    {
        return $this->team->where('id', $id)->delete();
    }

}
