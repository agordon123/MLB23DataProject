<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quirk extends Model
{
    use HasFactory;
    protected $table = 'quirks';
    protected $fillable = ['name','description','img'];

    public function players(){
        return $this->belongsToMany(Player::class,'player_has_quirks');
    }
}
