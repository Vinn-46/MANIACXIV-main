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
        Schema::create('player_target_bases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Player::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\TargetBase::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('current_hp');
            $table->boolean('is_destroyed')->default(false);
            $table->timestamp('destroyed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_target_bases');
    }
};
