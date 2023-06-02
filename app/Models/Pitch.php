<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    /**
     * This Model is for the Pitches table, which stores data for each type of pitch
     * It has a belong to many relationship with Player
     */
    use HasFactory;
    protected $fillable = ['name', 'abbreviation'];
    public $timestamps = false;

    protected $table = 'pitches';
    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_has_pitches')
            ->withPivot('speed', 'control', 'movement');
    }
}
