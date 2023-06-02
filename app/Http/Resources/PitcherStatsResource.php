<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PitcherStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'player_id'=> $request->player_id,
            'stamina'=>$request->stamina,
            'k_per_bf'=>$request->k_per_bf,
            'h_per_bf'=>$request->h_per_bf,
            'pitch_velocity'=>$request->pitch_velocity,
            'pitch_control'=>$request->pitch_control,
            'pitch_movement'=>$request->pitch_movement
        ];
    }
}
