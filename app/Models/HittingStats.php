<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HittingStats extends Model
{
    use HasFactory;
    protected $fillable = ['player_id', "contact_left",  "contact_right", "power_left", "power_right", "plate_vision", "plate_discipline", "batting_clutch", "bunting_ability", "drag_bunting_ability"];

    protected $table = 'player_hitting_stats';


    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id');
    }
    //  public function setContactLeftAttribute($key, $value)
    //  {

    //      if ($key === 'CON L') {
    //          $this->attributes['contact_left'] = $value;
    //      }
    //  }
    //  public function setContactRightAttribute($key, $value)
    //  {
    //      if ($key == 'CON R') {
    //          $this->attributes['contact_right'] = $value;
    //      }
    //  }
    //  public function setPowerLeftAttribute($key, $value)
    //  {
    //      if ($key == 'POW L') {
    //          $this->attributes['power_left'] = $value;
    //      }
    //  }
    //  public function setPowerRightAttribute($key, $value)
    //  {
    //      if ($key == 'POW R') {
    //          $this->attributes['power_right'] = $value;
    //      }
    //  }
    //  public function setPlateVisionAttribute($key, $value)
    //  {
    //      if ($key == 'VIS') {
    //          $this->attributes['plate_vision'] = $value;
    //      }
    //  }
    //  public function setPlateDisciplineAttribute($key, $value)
    //  {
    //      if ($key == 'DISC') {
    //          $this->attributes['plate_discipline'] = $value;
    //      }
    //  }
    //  public function setBattingClutchAttribute($key, $value)
    //  {
    //      if ($key == 'CLU') {
    //          $this->attributes['contact_right'] = $value;
    //      }
    //  }
    //  public function setBuntingAbilityAttribute($key, $value)
    //  {
    //      if ($key == 'BNT') {
    //          $this->attributes['bunting_ability'] = $value;
    //      }
    //  }
    //  public function setDragBuntingAbilityAttribute($key, $value)
    //  {
    //      if ($key == 'DBUNT') {
    //          $this->attributes['drag_bunting_ability'] = $value;
    //      }
    //  }
}
