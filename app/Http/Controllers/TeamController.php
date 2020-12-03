<?php

namespace App\Http\Controllers;

use App\Team;
use App\Http\Resources\FailedResource;
use App\Http\Resources\TeamResource;
use App\Http\Contracts\TeamInterface;
use App\Http\Requests\TeamRequest;
use Illuminate\Support\Facades\Auth;


class TeamController extends Controller
{

    protected $teamService;
    public function __construct(TeamInterface $teamService)
    {
        $this->teamService = $teamService;
    }
    /**
     * Get teams with parent_id is Null.
     *
     * @return TeamResource
     */
    public function index()
    {
        $teams = $this->teamService->index();
        return new TeamResource((object)['data' => $teams, 'message' =>'Successfully fetched']);
    }
    /**
     * Get All teams
     *
     * @return TeamResource
     */
    public function all()
    {
        $teams = Team::where('user_id',Auth::user()->id)->with('subOptions')->get();
        return new TeamResource((object)['data' => $teams, 'message' =>'Successfully fetched']);
    }

    /**
     * GET /api/team/{id}
     * Get single team with id
     *
     * @param $id
     * @return FailedResource|TeamResource
     */
    public function show($id)
    {
        $team = $this->teamService->show($id);
        if (!$team) {
            return new FailedResource((object)['error' => 'Sorry, account with id ' . $id . ' cannot be found']);
        }
        return new TeamResource((object)['data' => $team, 'message' =>'Successfully fetched']);
    }
    /**
     * POST /api/team/new
     * Create Team
     *
     * @param TeamRequest $request
     * @return FailedResource|TeamResource
     */
    public function store(TeamRequest $request)
    {
        $credentials = [
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::user()->id,
        ];
        $team = $this->teamService->create($credentials);

        if ($team) {
            $teams = $this->teamService->index();
            return new TeamResource((object)['data' => $teams, 'message' =>'Successfully added']);
        }
        else {
            return new FailedResource((object)['error' => 'Team can not be added']);
        }
    }
    /**
     * PUT /api/team/{id}
     * Update team
     *
     * @param TeamRequest $request
     * @param $id
     * @return FailedResource|TeamResource
     */
    public function update(TeamRequest $request, $id)
    {
        $credentials = [
            'name' => $request->name,
            'parent_id' => $request->parent_id
        ];
        $team =$this->teamService->update($credentials, $id);
        if ($team) {
            $teams = $this->teamService->index();
            return new TeamResource((object)['message' => 'Team  updated', 'data' => $teams]);
        }
        else {
            return new FailedResource((object)['error' => 'Team can not be updated']);
        }
    }
    /**
     * DELETE /api/team/{id}
     * Delete team
     *
     * @param   $id
     * @return FailedResource|TeamResource
     */
    public function destroy($id)
    {
        $team =$this->teamService->show($id);
        if(!$team) {
            return new FailedResource((object)['error' => 'Sorry, team with id ' . $id . ' cannot be found']);
        }
        if ($this->teamService->delete($id)) {
            $teams =  $this->teamService->index();
            return new TeamResource((object)['message' => 'Team  deleted', 'data' => $teams]);
        }
        else {
            return new FailedResource((object)['error' => 'Team can not be deleted']);
        }
    }
}
