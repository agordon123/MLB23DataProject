<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingStats extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'pitching_clutch',
        'hits_per_bf',
        'k_per_bf',
        'bb_per_bf',
        'hr_per_bf',
        'pitch_velocity',
        'pitch_control',
        'pitch_movement',
        'pitcher_stats',
        "stamina",
    ];
    protected $table = 'pitcher_stats';

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
    // public function setKperNineAttribute($key, $value)
    // {
    // }
    // public function setHperNineAttribute($key, $value)
    // {
    // }
    // public function setPitchingClutchAttribute($key, $value)
    // {
    // }
    // public function setBBPperNineAttribute($key, $value)
    // {
    // }
    // public function setPitchVelocityAttribute($key, $value)
    // {
    // }
    // public function setPitchMovementAttribute($key, $value)
    // {
    // }
    // public function setPitchControlAttribute($key, $value)
    // {
    // }
    // public function setStaminaAttribute($key, $value)
    // {
    // }




    // Override newFromBuilder method

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);

        // Check if is_hitter is false
        if (!$model->is_hitter) {
            $model = $model->newInstance([], true); // Create new instance of PitchingStats model
            $model->exists = true; // Mark the model as existing
        }

        return $model;
    }
}
