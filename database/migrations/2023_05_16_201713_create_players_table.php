
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
            $table->string('uuid')->unique('uuid_index');
            $table->integer('ovr')->nullable();
            $table->integer('age')->nullable();
            $table->string("height")->nullable();
            $table->integer('weight')->nullable();
            $table->string('bat_hand')->nullable();
            $table->string('throw_hand')->nullable();
            $table->boolean('is_hitter')->nullable();
            $table->string('team')->nullable();
            $table->string('rarity')->nullable();
            $table->string('img')->nullable();
            $table->string('baked_img')->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('secondary_positions')->nullable();
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
