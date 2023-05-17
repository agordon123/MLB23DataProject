<?php

use App\Models\Quirks;
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
        Schema::create('hitters', function (Blueprint $table) {
            $table->id();
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
            $table->foreignIdFor(Quirks::class,'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hitters');
    }
};
