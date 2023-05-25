<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [ 'id'=>$request->id,
                    'uuid'=>$request->uuid,
                  'type'=>$request->type,
                'rarity'=>$request->rarity,
                'name'=>$request->name  ];
    }
}
