<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    use HasFactory;
    protected $fillable = ['name','abbreviation'];
    // I am aware I did not make a Pitcher table but I made a pitcher model
    protected $table = 'pitches';
    public function players()
    {
        return $this->belongsToMany(Player::class, 'pitcher_has_pitches','pitch_id','player_id')
            ->withPivot('speed', 'control', 'break');
    }
}
