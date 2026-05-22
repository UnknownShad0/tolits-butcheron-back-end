<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    public function index()
    {
        return Game::with('homeTeam', 'awayTeam')->orderByDesc('played_at')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id|different:home_team_id',
            'home_score'   => 'required|integer|min:0',
            'away_score'   => 'required|integer|min:0',
            'played_at'    => 'required|date',
        ]);
        return Game::create($data)->load('homeTeam', 'awayTeam');
    }

    public function show(Game $game)
    {
        return $game->load('homeTeam', 'awayTeam', 'gameStats.player');
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'home_team_id' => 'sometimes|exists:teams,id',
            'away_team_id' => 'sometimes|exists:teams,id',
            'home_score'   => 'sometimes|integer|min:0',
            'away_score'   => 'sometimes|integer|min:0',
            'played_at'    => 'sometimes|date',
        ]);
        $game->update($data);
        return $game->load('homeTeam', 'awayTeam');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return response()->noContent();
    }
}
