<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HittingStats extends Model
{
    use HasFactory;
    protected $fillable = ["contact_left",  "contact_right", "power_left", "power_right", "plate_vision", "plate_discipline", "batting_clutch", "bunting_ability", "drag_bunting_ability"];
    protected $with  = ['player'];
    public function player(){
        return $this->belongsTo(Player::class,'player_id');
    }
}
