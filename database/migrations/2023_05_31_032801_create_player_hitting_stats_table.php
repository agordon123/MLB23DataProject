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
        Schema::create('player_hitting_stats', function (Blueprint $table) {
            $table->foreignIdFor(Player::class, 'player_id');
            $table->integer('contact_left');
            $table->integer('contact_right');
            $table->integer('power_left');
            $table->integer('power_right');
            $table->integer('plate_vision');
            $table->integer('plate_discipline');
            $table->integer('batting_clutch');
            $table->integer('bunting_ability');
            $table->integer('drag_bunting_ability');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_hitting_stats');
    }
};
