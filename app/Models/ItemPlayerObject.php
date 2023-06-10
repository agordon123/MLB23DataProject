<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPlayerObject extends Model
{
    use HasFactory;

    protected $fillable = ['attributes','uuid'];

    protected $casts = ['attributes'=>'json'];

    public function player(){
        return $this->hasOne(Player::class,'uuid');
    }
    public function item()
    {
        return $this->hasOne(Item::class,'uuid');
    }
}
