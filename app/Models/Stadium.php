<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stadium extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    public function team(){
        return $this->hasOne(Team::class);
    }
}
