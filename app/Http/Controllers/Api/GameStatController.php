<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameStat;
use Illuminate\Http\Request;

class GameStatController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'player_id' => 'required|exists:players,id',
            'match_id'  => 'required|exists:matches,id',
            'points'    => 'required|integer|min:0',
            'assists'   => 'required|integer|min:0',
            'rebounds'  => 'required|integer|min:0',
        ]);
        return GameStat::updateOrCreate(
            ['player_id' => $data['player_id'], 'match_id' => $data['match_id']],
            $data
        )->load('player', 'match');
    }

    public function update(Request $request, GameStat $gameStat)
    {
        $data = $request->validate([
            'points'   => 'sometimes|integer|min:0',
            'assists'  => 'sometimes|integer|min:0',
            'rebounds' => 'sometimes|integer|min:0',
        ]);
        $gameStat->update($data);
        return $gameStat->load('player');
    }
}
