<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Team extends Model
{
    use HasFactory;
    protected $table = 'teams';
    protected $fillable = ['team_name', 'team_short_name'];
    protected $casts = ['team_name' => 'string', 'team_short_name' => 'string'];
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Default values for timestamps.
     *
     * @var array
     */
    protected $attributes = [
        'created_at' => null,
        'updated_at' => null,
    ];

    public function items()
    {
        return $this->belongsTo(Item::class);
    }
    public function scopeSearchByName($query, $name)
    {
        return $query->where('team_name', 'LIKE', "%{$name}%");
    }

}
