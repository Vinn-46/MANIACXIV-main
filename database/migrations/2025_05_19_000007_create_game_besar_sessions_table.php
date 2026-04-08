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
        Schema::create('game_besar_sessions', function (Blueprint $table) {
            $table->id();
            $table->timestamp('open')->nullable();
            $table->timestamp('close')->nullable();
            $table->foreignId('mission_id');
            $table->foreign('mission_id')
                ->references('id')
                ->on('missions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('red_relic_stock')->required()->default(0);
            $table->integer('purple_relic_stock')->required()->default(0);
            $table->integer('blue_relic_stock')->required()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_besar_sessions');
    }
};
