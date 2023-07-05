<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'ovr' => $this->ovr,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'bat_hand' => $this->bat_hand,
            'throw_hand' => $this->throw_hand,
            'born' => $this->born,
            'is_hitter' => $this->is_hitter,
            'type' => $this->item->type,
            'rarity' => $this->item->rarity,
            'name' => $this->item->name,
            'team' => $this->item->team,
            'img' => $this->item->img,
            'baked_img' => $this->item->baked_img,
            'quirks' => $this->quirks()->pluck('name'),
            
        ];
        if (!$this->is_hitter) {
            $data = array_merge($data, [
                'stamina' => $this->player_hitting_stats->stamina ?? null,
                'pitcher_stats' => $this->pitcher_stats,
            ]);
        }
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'type' => $this->item->type,
            'rarity' => $this->item->rarity,
            'name' => $this->name,
            'ovr' => $this->ovr,
            'age' => $this->age,
            'height' => $this->height,
            'weight' => $this->weight,
            'bat_hand' => $this->bat_hand,
            'throw_hand' => $this->throw_hand,
            'born' => $this->born,
            'is_hitter' => $this->is_hitter,

            'quirks' => $this->quirks()->pluck('name','id'),
            'pitches' => $this->is_hitter ? [] : $this->pitches->map(function ($pitch) {
                return [
                    'name' => $pitch->name,
                    'speed' => $pitch->pivot->speed,
                    'control' => $pitch->pivot->control,
                    'movement' => $pitch->pivot->movement,
                ];
            }),

        ];
    }
}
