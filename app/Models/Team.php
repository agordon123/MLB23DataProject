<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Team extends Model
{
    use HasFactory;
    protected $table = 'teams';
    protected $fillable = ['name', 'abbreviation'];



    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */


    /**
     * Default values for timestamps.
     *
     * @var array
     */


    public function items()
    {
        return $this->belongsTo(Item::class, 'team_id', 'id');
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->where('team_name', 'LIKE', "%{$name}%");
    }

}
