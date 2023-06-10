<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldingStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'player_id'=>$this->player_id,
            'fielding_ability' => $this->fielding_ability,
            'arm_strength' => $this->arm_strength,
            'arm_accuracy' => $this->arm_accuracy,
            'reaction_time' => $this->reaction_time,
            'blocking' => $this->blocking,
            'fielding_durability'=>$this->fielding_durability,
            ''
        ];
    }
}
