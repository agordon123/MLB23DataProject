<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Player;

class Pitcher extends Player
{
    use HasFactory;

    protected $fillable = [
        'pitching_clutch',
        'hits_per_bf',
        'k_per_bf',
        'bb_per_bf',
        'pitch_velocity',
        'pitch_control',
        'pitch_movement'
    ];
    protected $table = 'pitcher_stats';
     // want to code that if is_hitter = false , to use pitcher model and not hitter model.  also want to make it a propery of a pitcher
    public function players()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
    public function item()
    {
        return $this->morphMany(Item::class, 'itemable');
    }
    //$player->item()->update(['itemable_type' => Pitcher::class]);

}
