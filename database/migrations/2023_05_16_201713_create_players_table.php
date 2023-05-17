
<?php

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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique('mlb_card_uuid');
            $table->string('name');
            $table->string('rarity');
            $table->string('team');
            $table->integer('ovr');
            $table->integer('age');
            $table->string('bat_hand');
            $table->boolean('is_hitter');
            $table->timestamps();
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
