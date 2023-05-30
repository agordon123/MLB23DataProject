<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'uuid', 'rarity', 'team', 'name', 'img'
    ];
    protected $casts = [
        'uuid'  => 'string',
        'type' => 'string',
        'name' => 'string',
        'rarity' => 'string',
        'team' => 'string',
        'img' => 'string'
    ];
    protected $attributes = ['name' => ' ', 'uuid' => ' ', 'type' => 'mlb_card', 'team' => ' ', 'rarity' => ' ', 'img' => ' '];
    protected $table = 'items';
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }
    public function getTypeAttribute($type)
    {
        return $this->type == $type;
    }
    public function stadiums()
    {
        return $this->hasOne(Stadium::class);
    }
    public function itemable()
    {
        return $this->morphTo(Item::class);
    }
    public function imageable()
    {
        return $this->morphTo();
    }
}
