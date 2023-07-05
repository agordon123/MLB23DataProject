<?php

namespace Database\Seeders;

use App\Models\Quirk;
use App\Models\Player;
use Illuminate\Database\Seeder;



class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
    public function seed()
    {
    }
    private function savePlayer(array $item)
    {
        $uuid = $item['uuid'];
        $rarity = $item['rarity'];
        $name = $item['name'];
        $img = $item['img'];
        $baked_img = $item['baked_img'];
        $ovr = $item['ovr'];
        $age = $item['age'];
        $height = $item['height'];
        $bh = $item['bat_hand'];
        $th = $item['throw_hand'];
        $weight = $item['weight'];
        $is_hitter = $item['is_hitter'];
        $position = $item['display_position'];
        $secondary_position = $item['display_secondary_positions'];

        $player = new Player();

        $player->uuid = $uuid;
        $player->ovr = $ovr;
        $player->age = $age;
        $player->img = $img;
        $player->baked_img = $baked_img;
        $player->rarity = $rarity;
        $player->name = $name;
        $player->height = $height;
        $player->weight = $weight;
        $player->bat_hand = $bh;
        $player->throw_hand = $th;
        $player->position = $position;
        $player->secondary_positions = $secondary_position;
        $player->is_hitter = $is_hitter;
        $player->save();


        $this->attachQuirks($player, $item['quirks']);
        echo ($player->uuid . ' saved');
    }

    private function attachQuirks($player, $quirks)
    {
        if (count($quirks) > 0) {
            foreach ($quirks as $quirkData) {
                $quirkName = $quirkData['name'];
                $dbQuirk = Quirk::byName($quirkName)->first();
                if ($dbQuirk) {
                    $player->quirks()->attach($dbQuirk->id);
                }
            }
        }
    }
}
