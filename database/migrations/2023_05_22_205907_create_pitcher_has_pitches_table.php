<?php

use App\Models\Pitch;
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
        Schema::create('player_has_pitches', function (Blueprint $table) {
            $table->foreignIdFor(Player::class,'player_id');
            $table->foreignIdFor(Pitch::class,'pitch_id');
            $table->primary(['player_id','pitch_id']);
            $table->integer('speed');
            $table->integer('control');
            $table->integer('break');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pitch_has_attributes');
    }
};
