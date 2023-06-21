<?php

use App\Models\RosterUpdate;
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
        Schema::create(
            'roster_changes',
            function (Blueprint $table) {
                $table->id();
                $table->json('attribute_changes');
                $table->json('newly_added');
                $table->json('position_changes');
                $table->foreignIdFor(RosterUpdate::class,'update_id');

            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
