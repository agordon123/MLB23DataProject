<?php

use App\Models\Player;
use App\Models\Quirk;
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
        Schema::create('player_has_quirks', function (Blueprint $table) {
            $table->foreignIdFor(Player::class,'player_id');
            $table->foreignIdFor(Quirk::class,'quirk_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_has_quirks');
    }
};
