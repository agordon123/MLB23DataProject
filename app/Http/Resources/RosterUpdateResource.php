<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RosterUpdateResource extends JsonResource
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
            'name' => $request->name,
            'update_id' => $request->update_id,
            'attribute_changes' => $request->attribute_changes,
            'position_changes' => $request->position_changes,
            'newly_added' => $request->newly_added
        ];
    }
}
