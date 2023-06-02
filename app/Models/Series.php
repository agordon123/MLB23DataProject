<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    /**
     * This Model is for the Series table, which stores each series by series_id and name
     * It has a One to Many Relationship with Item
     */
    use HasFactory;
    protected $fillable = ['series_id', 'name'];

    public function item(){
        return $this->hasMany(Item::class);
    }
    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }
}
