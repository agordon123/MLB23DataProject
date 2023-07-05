<?php

use App\Models\Player;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('player_fielding_stats', function (Blueprint $table) {
            $table->foreignIdFor(Player::class, 'player_id');
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_fielding_stats');
    }
};
