<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $request->id,
            'uuid' => $request->uuid,
            'type' => $request->type,
            'rarity' => $request->rarity,
            'name' => $request->name,
            'ovr' => $request->ovr,
            'age' => $request->age,
            'height' => $request->height,
            'weight' => $request->weight,
            'jersey_number' => $request->jersey_number,
            'bat_hand' => $request->bat_hand,
            'throw_hand' => $request->throw_hand,
            'born' => $request->born,
            'is_hitter' => $request->is_hitter,
            "stamina" => $request->stamina,
            "contact_left" => $request->contact_left,
            "contact_right" => $request->contact_right,
            "power_left" => $request->power_left,
            "power_right" => $request->power_right,
            "plate_vision" => $request->plate_vision,
            "plate_discipline" => $request->plate_discipline,
            "batting_clutch" => $request->batting_clutch,
            "bunting_ability" => $request->bunting_ability,
            "drag_bunting_ability" => $request->drag_bunting_ability,
            "hitting_durability" => $request->hitting_durability,
            "fielding_ability" => $request->fielding_ability,
            "arm_strength" => $request->arm_strength,
            "arm_accuracy" => $request->arm_accuracy,
            "reaction_time" => $request->$request->reaction_time,
            "blocking" => $request->blocking,
            "speed" => $request->speed,
            "baserunning_ability" => $request->baserunning_ability,
            "baserunning_aggression" => $request->baserunning_aggression,
        ];
    }
}
