<?php

use App\Models\Player;
use App\Models\PitchingStats;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ItemStatsCast implements CastsAttributes
{
    public function get($model, $key, $value, $attributes)
    {
        return json_decode($value, true);
    }

    public function set($model, $key, $value, $attributes)
    {
        if ($model->type === 'mlb_card') {
            // Extract player attributes
            $playerAttributes = $value['player_attributes'];

            // Create a new player and associate it with the item
            $player = new Player($playerAttributes);
            $model->player()->associate($player);

            if ($playerAttributes['is_hitter']) {
                // Extract hitter-specific attributes
                $hitterAttributes = $value['hitter_attributes'];

                // Update the player attributes with the hitter-specific attributes
                $player->fill($hitterAttributes);
            } else {
                // Extract pitcher-specific attributes
                $pitcherAttributes = $value['pitcher_attributes'];

                // Create a new pitcher and associate it with the player
                $pitcher = new PitchingStats($pitcherAttributes);
                $player->pitcher()->save($pitcher);
            }
        }

        // Save the updated item stats
        return json_encode($value);
    }
}

