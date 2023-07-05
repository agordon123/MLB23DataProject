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
            'fielding_ability' => $this->player_fielding_stats->fielding_ability ?? null,
            'arm_strength' => $this->player_fielding_stats->arm_strength ?? null,
            'arm_accuracy' => $this->player_fielding_stats->arm_accuracy ?? null,
            'reaction_time' => $this->player_fielding_stats->reaction_time ?? null,
            'blocking' => $this->player_fielding_stats->blocking ?? null,
            'speed' => $this->player_fielding_stats->speed ?? null,
            'baserunning_ability' => $this->player_fielding_stats->baserunning_ability ?? null,
            'baserunning_aggression' => $this->player_fielding_stats->baserunning_aggression ?? null,
        ];
    }
}
