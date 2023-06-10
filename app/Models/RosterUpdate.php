<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RosterUpdate extends Model
{
    use HasFactory;
    protected $fillable = ['update_id','name','attribute_changes','position_changes','newly_added'];


    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function addedItems()
    {
        return $this->hasMany(Item::class, 'roster_update_id');
    }
}
