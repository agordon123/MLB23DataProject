
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
