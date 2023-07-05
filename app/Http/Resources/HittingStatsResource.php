<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HittingStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contact_left' => $this->contact_left ?? null,
            'contact_right' => $this->contact_right ?? null,
            'power_left' => $this->power_left ?? null,
            'power_right' => $this->power_right ?? null,
            'plate_vision' => $this->plate_vision ?? null,
            'plate_discipline' => $this->plate_discipline ?? null,
            'batting_clutch' => $this->batting_clutch ?? null,
            'bunting_ability' => $this->bunting_ability ?? null,
            'drag_bunting_ability' => $this->drag_bunting_ability ?? null,
        ];
    }
}
