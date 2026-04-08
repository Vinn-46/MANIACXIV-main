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
        Schema::create('relic_chosens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('score_id');
            $table->foreign('score_id')
                ->references('id')
                ->on('scores')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('red_relic_qty')->required()->default(0);
            $table->integer('blue_relic_qty')->required()->default(0);
            $table->integer('purple_relic_qty')->required()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relic_chosens');
    }
};
