<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;
    protected $table = 'players';
    protected $fillable = [
        'ovr', 'age', 'height', 'weight', 'jersey_number', 'bat_hand', 'throw_hand', 'born', 'is_hitter', "stamina","contact_left",
        "contact_right","power_left","power_right","plate_vision","plate_discipline","batting_clutch","bunting_ability","drag_bunting_ability",
        "hitting_durability","fielding_ability","arm_strength","arm_accuracy","reaction_time","blocking","speed","baserunning_ability","baserunning_aggression",

    ];
    protected $casts = ['is_hitter'=>'bool'];

    public function quirks()
    {
        return $this->hasManyThrough(Quirk::class,'player_has_quirks','player_id','quirk_id','id','id');
    }
    public function pitches()
    {
        return $this->belongsToMany(Pitch::class, 'pitcher_has_pitches')
            ->withPivot('speed', 'control', 'break');
    }
    public function pitcherStats(){
        return $this->hasOne(PitcherStats::class);
    }
    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }
}
