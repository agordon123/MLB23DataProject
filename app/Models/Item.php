<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'uuid','rarity','team','name','img'
    ];
    protected $casts = [
        'uuid'      => 'string',
        'type' => 'string',
        'name'=>'string',
        'rarity'=>'string',
        'team'=>'string'
    ];
    protected $table = 'items';
    protected function players()
    {
        return $this->hasOne(Player::class);
    }
    public function teams()
    {
        return $this->hasOne(Team::class);
    }
    public function getTypeAttribute($type)
    {
        return $this->type == $type;
    }
    public function stadiums(){
        return $this->hasOne(Stadium::class);
    }
    public function itemable()
    {
        return $this->morphTo();
    }
}
