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
        Schema::table('players', function (Blueprint $table) {
            $table->integer('honor')->default(0);
            $table->integer('peluru')->default(0);
            $table->integer('weapon_level')->default(1);
            $table->integer('game_besar_points')->default(0);
            $table->integer('bonus_points')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn(['honor', 'peluru', 'weapon_level', 'game_besar_points', 'bonus_points']);
        });
    }
};
