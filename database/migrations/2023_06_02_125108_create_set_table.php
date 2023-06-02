<?php

use App\Models\Item;
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
        Schema::create('set', function (Blueprint $table) {
            $table->id();
            $table->integer('set_id');
            $table->string('name');
            $table->foreignIdFor(Item::class,'item_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set');
    }
};
