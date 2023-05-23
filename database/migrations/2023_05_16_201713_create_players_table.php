
<?php


use App\Models\Player;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->references('id')->on('items');
            $table->integer('ovr');
            $table->integer('age');
            $table->string("height");
            $table->integer('weight');
            $table->string('bat_hand');
            $table->boolean('is_hitter');
            $table->integer('contact_left');
            $table->integer('contact_right');
            $table->integer('power_left');
            $table->integer('power_right');
            $table->integer('plate_vision');
            $table->integer('plate_discipline');
            $table->integer('batting_clutch');
            $table->integer('bunting_ability');
            $table->integer('drag_bunting_ability');
            $table->integer('hitting_durability');
            $table->integer('fielding_durability');
            $table->integer('fielding_ability');
            $table->integer('arm_strength');
            $table->integer('arm_accuracy');
            $table->integer('reaction_time');
            $table->integer('blocking');
            $table->integer('speed');
            $table->integer('baserunning_ability')->nullable();
            $table->integer('baserunning_aggression')->nullable();
            $table->timestamps();
        });
        Schema::create('pitcher_stats',function (Blueprint $table){
            $table->foreignIdFor(Player::class,'player_id');
            $table->integer('stamina')->nullable();
            $table->integer('pitching_clutch')->nullable();
            $table->integer('hits_per_bf')->nullable();
            $table->integer('k_per_bf')->nullable();
            $table->integer('bb_per_bf')->nullable();
            $table->integer('pitch_velocity')->nullable();
            $table->integer('pitch_control')->nullable();
            $table->integer('pitch_movement')->nullable();
            $table->timestamps();
        });
        Schema::create('pitches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
