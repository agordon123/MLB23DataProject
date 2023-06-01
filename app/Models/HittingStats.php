<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HittingStats extends Model
{
    use HasFactory;
    protected $fillable = ['player_id', "contact_left",  "contact_right", "power_left", "power_right", "plate_vision", "plate_discipline", "batting_clutch", "bunting_ability", "drag_bunting_ability"];

    protected $table = 'player_hitting_stats';


    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
