<?php

namespace App\Http\Controllers;


use App\Http\Resources\FailedResource;
use App\Http\Resources\PlayerResource;
use App\Http\Services\PlayerService;
use App\Http\Requests\PlayerRequest;


class PlayerController extends Controller
{


    /**
     * Get Authenticated user players.
     *
     * @param PlayerService $playerService
     * @return PlayerResource
     */
    public function index(PlayerService $playerService)
    {
        $players = $playerService->index();

        return new PlayerResource((object)['data' => $players,'message' =>'Successfully fetched']);
    }
    /**
     * GET /api/player/{id}
     * Get single player with id
     *
     * @param PlayerService $playerService
     * @param $id
     * @return FailedResource|PlayerResource
     */
    public function show(PlayerService $playerService,$id)
    {
        $player = $playerService->show($id);

        if (!$player) {
            return new FailedResource((object)['error' => 'Sorry, player with id ' . $id . ' cannot be found']);
        }
        return new playerResource((object)['data' => $player,'message' =>'Successfully fetched']);
    }

    public function store(PlayerService $playerService,PlayerRequest $request)
    {

        $credentials = [
            'name' => $request->name,
            'description' => $request->description,
            'team_id' => $request->team_id,
        ];
        $player = $playerService->create($credentials);
        if ($player) {
            $players = $playerService->index();
            return new PlayerResource((object)['data' => $players,'message' => 'Added Successfully']);
        }
        else {
            return new FailedResource((object)['error' => 'player can not be added']);
        }
    }
    /**
     * PUT /api/player/{id}
     * Update player
     *
     * @param PlayerService $playerService
     * @param PlayerRequest $request
     * @param $id
     * @return FailedResource|PlayerResource
     */
    public function update(PlayerService $playerService,PlayerRequest $request,$id)
    {
        $credentials = [
            'name' => $request->name,
            'description' => $request->description,
            'team_id' => $request->team_id,
        ];
        $player = $playerService->update($credentials, $id);
        if ($player) {
            $players = $playerService->index();
            return new playerResource((object)['message' => 'player  updated','data' => $players]);
        }
        else {
            return new FailedResource((object)['error' => 'player can not be updated']);
        }
    }
    /**
     * DELETE /api/player/{id}
     * Delete player
     *
     * @param PlayerService $playerService
     * @param   $id
     * @return FailedResource|PlayerResource
     */
    public function destroy(PlayerService $playerService,$id)
    {
        $player = $playerService->show($id);
        if(!$player) {
            return new FailedResource((object)['error' => 'Sorry, player with id ' . $id . ' cannot be found']);
        }
        if ($player->delete()) {
            $players =  $playerService->index();
            return new PlayerResource((object)['message' => 'player  deleted','data' => $players]);
        }
        else {
            return new FailedResource((object)['error' => 'player can not be deleted']);
        }
    }
}
