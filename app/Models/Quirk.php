<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quirk extends Model
{
    /**
     * This Model is for the Quirks table, which stores data for each Quirk
     * It has a belong to many relationship with Player, and a function to scope queries by name instead of ID
     */
    use HasFactory;
    protected $table = 'quirks';
    protected $fillable = ['name','description','img','baked_img'];

    public function player(){
        return $this->belongsToMany(Player::class,'player_has_quirks');
    }
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }


}
