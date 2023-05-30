<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'pitch_movement',
        'pitcher_stats'
    ];
    protected $table = 'pitcher_stats';
    protected $with  = ['player'];

    // want to code that if is_hitter = false , to use pitcher model and not hitter model.  also want to make it a propery of a pitcher
    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    public function item()
    {
        return $this->morphMany(Item::class, 'itemable');
    }

    public function pitches()
    {
        return $this->belongsToMany(Pitch::class, 'pitcher_has_pitches')
        ->withPivot('speed', 'control', 'break');
    }

    // Override newFromBuilder method

    public function newFromBuilder($attributes = [], $connection = null)
    {
        $model = parent::newFromBuilder($attributes, $connection);

        // Check if is_hitter is false
        if (!$model->is_hitter) {
            $model = $model->newInstance([], true); // Create new instance of Pitcher model
            $model->exists = true; // Mark the model as existing
        }

        return $model;
    }
    //$player->item()->update(['itemable_type' => Pitcher::class]);


}
