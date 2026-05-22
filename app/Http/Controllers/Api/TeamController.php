<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        return Team::with('players')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|unique:teams']);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        return Team::create($data);
    }

    public function show(Team $team)
    {
        return $team->load('players');
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate(['name' => 'required|string|unique:teams,name,' . $team->id]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $team->update($data);
        return $team;
    }

    public function destroy(Team $team)
    {
        $team->delete();
        return response()->noContent();
    }
}
