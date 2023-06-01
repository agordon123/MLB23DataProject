<?php

namespace App\Models;



use App\Models\Item;
use App\Models\Pitch;
use App\Models\Quirk;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;
    protected $table = 'players';
    protected $fillable = [
        'ovr', 'age', 'height', 'weight', 'bat_hand', 'throw_hand',  'is_hitter',  'position', 'secondary_positions', 'uuid'
    ];


    public function pitches()
    {
        return $this->belongsToMany(Pitch::class, 'player_has_pitches')
            ->withPivot('speed', 'control', 'movement');
    }

    public function quirks()
    {
        return $this->belongsToMany(Quirk::class, 'player_has_quirks');
    }


    public function item()
    {
        return $this->morphOne(Item::class, 'itemable');
    }
    public function scopeByUUID($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }
}
