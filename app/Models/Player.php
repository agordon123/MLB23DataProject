<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';
    protected $fillable = [
        'ovr', 'age', 'height', 'weight', 'bat_hand', 'throw_hand', 'is_hitter', 'position', 'secondary_positions', 'uuid'
    ];

    protected $with = ['playerHittingStats', 'playerFieldingStats'];

    public function pitches()
    {
        return $this->when(!$this->is_hitter, function ($query) {
            $query->belongsToMany(Pitch::class, 'player_has_pitches')
            ->withPivot('speed', 'control', 'movement');
        });
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

    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }

    public function scopeByUUID($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }
    protected function loadPitchingStatsAndPitches()
    {
        if (!$this->is_hitter) {
            $this->load('pitchingStats', 'pitches');
        }
    }

    public function newQueryWithoutScopes()
    {
        if (!$this->is_hitter) {
            $this->loadPitchingStats();
        }

        return parent::newQueryWithoutScopes();
    }
}
