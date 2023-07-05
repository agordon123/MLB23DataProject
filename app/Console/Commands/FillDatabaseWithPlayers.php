<?php

namespace App\Console\Commands;

use App\Models\Quirk;
use App\Models\Player;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;



class FillDatabaseWithPlayers extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed {page : The page number to start from}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'seed the database with players from json files';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startPage = $this->argument('page');
        for ($page = $startPage; $page <= 116; $page++) {
            $filePath = storage_path("app/public/json/items{$page}.json");
            $data = file_get_contents($filePath);
            $dataJson = json_decode($data, true);

            foreach ($dataJson['items'] as $item) {
                try {
                    $this->savePlayer($item);
                    echo ($item['uuid'] . ' saved');
                } catch (\Throwable $th) {
                    echo ($th);
                }
            }
            unset($dataJson);
            unset($data);

            $this->info('Page ' . $page . ' saved');
        }
    }
    protected function savePlayer(array $item)
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
    protected function attachQuirks($player, $quirks)
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
