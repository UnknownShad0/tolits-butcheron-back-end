<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['name', 'team_id', 'position', 'jersey_number', 'photo_path'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function gameStats()
    {
        return $this->hasMany(GameStat::class);
    }
}
