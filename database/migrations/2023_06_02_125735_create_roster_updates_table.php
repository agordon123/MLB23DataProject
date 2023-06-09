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
        Schema::create('roster_updates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('update_id');
            $table->json('attribute_changes');
            $table->json('position_changes');
            $table->json('newly_added');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roster_updates');
    }
};
