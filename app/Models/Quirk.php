<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quirk extends Model
{
    use HasFactory;
    protected $table = 'quirks';
    protected $fillable = ['name','description','img','baked_img'];

    public function player(){
        return $this->belongsToMany(Player::class,'player_has_quirks','player_id','quirk_id');
    }
    public function scopeByName(){
        
    }
  /*  protected static function booted()
    {
        static::creating(function ($model) {
            $model->attribute_name = 'default_value';
        });
    }*/
}
