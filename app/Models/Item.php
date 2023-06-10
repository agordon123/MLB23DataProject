<?php

namespace App\Models;

use ItemStatsCast;

use App\Models\Team;
use App\Models\Player;
use App\Models\Series;
use App\Models\Listing;
use App\Models\Stadium;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'uuid', 'rarity', 'team', 'name', 'img', 'baked_img','item_stats','series_id'
    ];

    protected $casts = [
        'uuid'  => 'string',
        'type' => 'string',
        'name' => 'string',
        'rarity' => 'string',
        'team' => 'string',
        'img' => 'string', 'item_stats' => ItemStatsCast::class,
    ];
    protected $table = 'items';
    public function player()
    {
        return $this->hasOne(Player::class);
    }

    public function rosterUpdates()
    {
        return $this->hasMany(RosterUpdate::class, 'item_id');
    }

    public function team()
    {
        return $this->hasOne(Team::class, 'team_id', 'id');
    }

    public function stadiums()
    {
        return $this->hasOne(Stadium::class);
    }
    public function itemable()
    {
        return $this->morphTo();
    }
    public function imageable()
    {
        return $this->morphTo();
    }
    public function listing(){
        return $this->hasMany(Listing::class);
    }
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
