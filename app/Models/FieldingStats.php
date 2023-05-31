<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldingStats extends Model
{
    use HasFactory;
    protected $fillable = [
        'fielding_durability',
        "hitting_durability", "fielding_ability", "arm_strength", "arm_accuracy", "reaction_time", "blocking", "speed", "baserunning_ability", "baserunning_aggression",
    ];
    protected $with  = ['player'];
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
