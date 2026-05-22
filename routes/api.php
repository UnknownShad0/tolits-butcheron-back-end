<?php

use App\Http\Controllers\Api\GameStatController;
use App\Http\Controllers\Api\LeaderboardController;
use App\Http\Controllers\Api\MatchController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\TeamController;
use Illuminate\Support\Facades\Route;

Route::apiResource('teams', TeamController::class);
Route::apiResource('players', PlayerController::class);
Route::apiResource('matches', MatchController::class)->parameters(['matches' => 'game']);

Route::post('game-stats', [GameStatController::class, 'store']);
Route::put('game-stats/{gameStat}', [GameStatController::class, 'update']);

Route::get('leaderboard', [LeaderboardController::class, 'index']);
