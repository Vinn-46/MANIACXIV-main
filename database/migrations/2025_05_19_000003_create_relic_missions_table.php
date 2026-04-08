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
        Schema::create('relic_missions', function (Blueprint $table) {
            $table->foreignId('relic_id');
            $table->foreign('relic_id')
                ->references('id')
                ->on('relics')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('mission_id');
            $table->foreign('mission_id')
                ->references('id')
                ->on('missions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relic_missions');
    }
};
