<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PitchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'player_id' => $request->player_id,
            'pitch_id' => $request->pitch_id,
            'name' => $request->name,
            'speed' => $request->speed,
            'control' => $request->break
        ];
    }
}
