<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $perPage = 10;
    protected $casts = [
        'uuid'      => 'string',
        "name"      => 'string',
        "rarity"    => 'string',
        "team"      => 'string',
        "ovr"       => 'numeric',
        "age"       => 'numeric',
        "bat_hand"  => 'string',
        "throw_hand" => 'string',
        "is_hitter" => 'bool',
        "stamina"   => 'numeric',
        "pitching_clutch" => 'numeric',
        "hits_per_bf" => 'numeric',
        "k_per_bf" => 'numeric',
        "bb_per_bf" => 'numeric',
        "hr_per_bf" => 'numeric',
        "pitch_velocity" => 'numeric',
        "pitch_control" => 'numeric',
        "pitch_movement" => 'numeric',
        "contact_left" => 'numeric',
        "contact_right" => 'numeric',
        "power_left" => 'numeric',
        "power_right" => 'numeric',
        "plate_vision" => 'numeric',
        "plate_discipline" => 'numeric',
        "batting_clutch" => 'numeric',
        "bunting_ability" => 'numeric',
        "drag_bunting_ability" => 'numeric',
        "hitting_durability" => 'numeric',
        "fielding_ability" => 'numeric',
        "arm_strength" => 'numeric',
        "arm_accuracy" => 'numeric',
        "reaction_time" => 'numeric',
        "blocking" => 'numeric',
        "speed" => 'numeric',
        "baserunning_ability" => 'numeric',
        "baserunning_aggression" => 'numeric',
    ];
}
