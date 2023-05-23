<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitcherStats extends Model
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
    public function players(){
        return $this->belongsTo(Player::class,'player_id');
    }
    // want to code that if is_hitter = false , to use pitcher model and not hitter model.  also want to make it a propery of a pitcher
}
