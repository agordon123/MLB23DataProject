<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class PitcherCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        if ($model->is_hitter) {
            return null;
        }
        return [
            'pitching_clutch' => $attributes['pitching_clutch'] ?? null,
            'hits_per_bf' => $attributes['hits_per_bf'] ?? null,
            'k_per_bf' => $attributes['k_per_bf'] ?? null,
            'bb_per_bf' => $attributes['bb_per_bf'] ?? null,
            'pitch_velocity' => $attributes['pitch_velocity'] ?? null,
            'pitch_control' => $attributes['pitch_control'] ?? null,
            'pitch_movement' => $attributes['pitch_movement'] ?? null
        ];
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value;
    }
}
