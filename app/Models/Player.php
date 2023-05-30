<?php

namespace App\Models;



use App\Models\Item;
use App\Models\Quirk;
use App\Models\Pitcher;
use App\Casts\PitchAttributesCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    protected $table = 'players';
    protected $fillable = [
        'ovr', 'age', 'height', 'weight', 'jersey_number', 'bat_hand', 'throw_hand', 'born', 'is_hitter', "stamina", "contact_left",
        "contact_right", "power_left", "power_right", "plate_vision", "plate_discipline", "batting_clutch", "bunting_ability", "drag_bunting_ability",
        "hitting_durability", "fielding_ability", "arm_strength", "arm_accuracy", "reaction_time", "blocking", "speed", "baserunning_ability", "baserunning_aggression",
        'pitcher_stats'
    ];


    protected $casts = [
        'pitcher_stats' => PitchAttributesCast::class,
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->drag_bunting_ability = 1;
            $model->hitting_durability = 1;
            $model->fielding_durability = 1;
            $model->fielding_ability = 1;
            $model->arm_strength = 1;
            $model->arm_accuracy = 1;
            $model->reaction_time = 1;
            $model->blocking = 0;
            $model->speed = 0;
            $model->baserunning_ability = 0;
            $model->baserunning_aggression = 0;
        });
    }
    public function quirks()
    {
        return $this->hasManyThrough(Quirk::class, 'player_has_quirks', 'player_id', 'quirk_id', 'id', 'id');
    }

    public function pitcher()
    {
        return $this->hasOne(Pitcher::class, 'player_id');
    }
    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }
}
