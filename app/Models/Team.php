<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Team extends Model
{
    use HasFactory;
    protected $table = 'teams';
    protected $fillable = ['name', 'abbreviation'];

    public function items()
    {
        return $this->belongsTo(Item::class);
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }

}
