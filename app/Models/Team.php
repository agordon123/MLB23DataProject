<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $table = 'teams';
    protected $fillable = ['team_name','team_short_name'];

    public function items()
    {
        return $this->belongsTo(Item::class);
    }
}
