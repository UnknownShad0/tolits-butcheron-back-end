<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GameStat;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $leaders = GameStat::select(
                'player_id',
                DB::raw('SUM(points) as total_points'),
                DB::raw('SUM(assists) as total_assists'),
                DB::raw('SUM(rebounds) as total_rebounds'),
                DB::raw('COUNT(match_id) as games_played'),
                DB::raw('ROUND(SUM(points) / COUNT(match_id), 1) as ppg')
            )
            ->with('player.team')
            ->groupBy('player_id')
            ->orderByDesc('ppg')
            ->limit(10)
            ->get();

        return $leaders;
    }
}
