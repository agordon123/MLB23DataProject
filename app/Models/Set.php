<?php

namespace App\Models;

use App\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Set extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function item(){
        return $this->belongsTo(Item::class);
    }
}
