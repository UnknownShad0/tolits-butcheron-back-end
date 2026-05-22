<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        return Player::with('team')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string',
            'team_id'       => 'required|exists:teams,id',
            'position'      => 'nullable|string',
            'jersey_number' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('players', 'public');
        }

        return Player::create($data)->load('team');
    }

    public function show(Player $player)
    {
        return $player->load('team', 'gameStats');
    }

    public function update(Request $request, Player $player)
    {
        $data = $request->validate([
            'name'          => 'sometimes|string',
            'team_id'       => 'sometimes|exists:teams,id',
            'position'      => 'nullable|string',
            'jersey_number' => 'nullable|string',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('players', 'public');
        }

        $player->update($data);
        return $player->load('team');
    }

    public function destroy(Player $player)
    {
        $player->delete();
        return response()->noContent();
    }
}
