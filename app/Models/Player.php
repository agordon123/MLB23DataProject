<?php

namespace App\Models;

use Illuminate\Support\LazyCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';
    protected $fillable = [
        'ovr', 'age', 'height', 'weight', 'bat_hand', 'throw_hand', 'is_hitter', 'position', 'secondary_positions', 'uuid',  'team', 'name', 'series_year'
    ];
    protected $hidden = ['img', 'baked_img', 'rarity'];


    //  public function pitches()
    //  {
    //      return $this->when(!$this->is_hitter, function ($query) {
    //          return new LazyCollection(function () {
    //              return $this->belongsToMany(Pitch::class, 'player_has_pitches')
    //                  ->withPivot('speed', 'control', 'movement')
    //                  ->get()
    //                  ->lazy();
    //          });
    //      });
    //  }
    public function pitches()
    {
        return $this->when(!$this->is_hitter, function ($query) {
            return $this->belongsToMany(Pitch::class, 'player_has_pitches')
                ->withPivot('speed', 'control', 'movement');
        });
    }
    public function rosterUpdate()
    {
        return $this->belongsTo(RosterUpdate::class);
    }
    public function quirks()
    {
        return $this->belongsToMany(Quirk::class, 'player_has_quirks');
    }
    public function pitchingStats()
    {
        return $this->hasOne(PitchingStats::class);
    }
    public function hittingStats()
    {
        return $this->hasOne(HittingStats::class);
    }

    public function fieldingStats()
    {
        return $this->hasOne(FieldingStats::class);
    }
    public function scopeByUUID($query, $uuid)
    {
        return $query->where('uuid', $uuid)->lazy();
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }
    public function team()
    {
        return $this->hasOne(Team::class);
    }
}
