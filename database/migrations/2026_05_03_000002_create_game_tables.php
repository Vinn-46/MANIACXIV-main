<?php

use App\Models\{Player, Point, RallyGame, Team, User};
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rally_games', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['single', 'battle', 'inferno']);
            $table->timestamps();
        });

        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['single', 'battle', 'inferno']);
            $table->enum('condition', ['win', 'draw', 'lose']);
            $table->double('value')->default(0);
            $table->timestamps();
        });

        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->double('points')->default(0.0);
            $table->timestamps();
        });

        Schema::create('scores', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RallyGame::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Player::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Point::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('desc');
            $table->timestamps();
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(RallyGame::class)->constrained()->cascadeOnDelete();
            $table->timestamp('called_at');
            $table->boolean('resolved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('logs');
        Schema::dropIfExists('scores');
        Schema::dropIfExists('players');
        Schema::dropIfExists('points');
        Schema::dropIfExists('rally_games');
    }
};
