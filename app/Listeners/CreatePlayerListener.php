<?php

namespace App\Listeners;

use App\Events\CreatePitcherEvent;
use App\Models\Player;
use App\Events\CreatePlayerEvent;
use App\Models\FieldingStats;
use App\Models\HittingStats;
use App\Models\Quirk;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;

class CreatePlayerListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }
    /**
     * The name of the connection the job should be sent to.
     *
     * @var string|null
     */


    /**
     * The name of the queue the job should be sent to.
     *
     * @var string|null
     */
    public $queue = 'listeners';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 3;
    /**
     * Handle the event.
     */
    public function handle(CreatePlayerEvent $event): void
    {
        $item = $event->data;
        $uuid = $item->uuid;
        $data = $event->data;


        $playerCheck = Player::where('uuid', $uuid)->first();
        if (!$playerCheck) {
            $quirks = $data['quirks'];

            $player = Player::create([
                'item_id' => $item->id,
                'uuid' => $item->uuid,
                'age' => $data['age'],
                'ovr' => $data['ovr'],
                'bat_hand' => $data['bat_hand'],
                'throw_hand' => $data['throw_hand'],
                'height' => $data['height'],
                'weight' => $data['weight'],
                'display_position' => $data['display_position'],
                'secondary_positions' => $data['display_secondary_positions'],
                'is_hitter' => $data['is_hitter']
            ]);
            $player->save();
            $item->player()->associate($player);

            $hittingStats = [
                'contact_left' =>    $data['contact_left'],
                'contact_right' =>    $data['contact_right'],
                'power_left' =>    $data['power_left'],
                'power_right' =>    $data['power_right'],
                'plate_vision' =>    $data['plate_vision'],
                'plate_discipline' =>    $data['plate_discipline'],
                'batting_clutch' =>    $data['batting_clutch'],
                'bunting_ability' =>    $data['bunting_ability'],
                'drag_bunting_ability' => $data['drag_bunting_ability']
            ];
            $hitting = new HittingStats($hittingStats);
            $player->hittingStats($hitting);
            $baserunning_ability = $data['baserunning_ability'];
            $baserunning_aggression = $data['baserunning_aggression'];
            $fielding_ability = $data['fielding_ability'];
            $durability = $data['fielding_durability'];
            $armAcc = $data['arm_accuracy'];
            $armStrength = $data['arm_strength'];
            $reaction = $data['reaction_time'];
            $blocking = $data['blocking'];
            $speed = $data['speed'];
            $hitting_durability = $data['hitting_durability'];

            $fielding_stats = [
                'baserunning_ability' => $baserunning_ability, 'baserunning_aggression' => $baserunning_aggression, 'fielding_ability' => $fielding_ability,
                'durability' => $durability, 'arm_accuracy' => $armAcc, 'arm_strength' => $armStrength, 'reaction' => $reaction, 'blocking' => $blocking, 'speed' => $speed, 'hiting_durability' => $hitting_durability,
                'fielding_durability' => $durability
            ];
            $fielding = new FieldingStats($fielding_stats);
            $player->fieldingStats($fielding);
            foreach($quirks as $quirkData){
                $name = $quirkData['name'];
                $quirk = Quirk::where('name',$name)->pluck('id');
                $player->quirks()->attach($quirk->id);
                $player->refresh();
            }
            if(!$player->is_hitter){
                event(new CreatePitcherEvent($player));
            }
        }


    }
}
