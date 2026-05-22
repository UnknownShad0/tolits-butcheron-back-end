<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'logo_path'];

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches()
    {
        return $this->hasMany(Game::class, 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany(Game::class, 'away_team_id');
    }
}
