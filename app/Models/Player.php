<?php

namespace App\Models;



use App\Models\Item;
use App\Models\Pitch;
use App\Models\Quirk;
use App\Models\HittingStats;
use App\Models\PitchingStats;
use App\Casts\PitchAttributesCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    protected $table = 'players';
    protected $fillable = [
        'ovr', 'age', 'height', 'weight', 'bat_hand', 'throw_hand',  'is_hitter',  'position', 'secondary_positions',
       

    ];


    //  protected $casts = [
    //       'pitcher_stats' => PitchAttributesCast::class,
    //   ];

    public function pitches()
    {
        return $this->belongsToMany(Pitch::class, 'pitcher_has_pitches')
        ->withPivot('speed', 'control', 'break');
    }

    public function quirks()
    {
        return $this->hasManyThrough(Quirk::class, 'player_has_quirks', 'player_id', 'quirk_id', 'id', 'id');
    }

    public function pitchingStats()
    {
        return $this->hasOne(PitchingStats::class, 'player_id');
    }
    public function hittingStats(){
        return $this->hasOne(HittingStats::class);
    }
    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }

}
