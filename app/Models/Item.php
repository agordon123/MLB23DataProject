<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'uuid', 'rarity', 'team', 'name', 'img', 'baked_img'
    ];
    protected $casts = [
        'uuid'  => 'string',
        'type' => 'string',
        'name' => 'string',
        'rarity' => 'string',
        'team' => 'string',
        'img' => 'string'
    ];
    protected $attributes = ['type' => 'mlb_card'];
    protected $table = 'items';
    public function player()
    {
        return $this->belongsTo(Player::class);
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
        return $this->morphTo(Item::class);
    }
    public function imageable()
    {
        return $this->morphTo();
    }
}
