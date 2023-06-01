<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'abbreviation'];
    public $timestamps = false;
    // I am aware I did not make a Pitcher table but I made a pitcher model
    protected $table = 'pitches';
    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_has_pitches')
            ->withPivot('speed', 'control', 'movement');
    }
}
