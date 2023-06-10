<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;
    protected $fillable = ['best_sell_price','best_buy_price','sort','series_id','team','rarity','name','type'];
    public function item()
    {
        return $this->hasOne(Item::class);
    }
    
}
