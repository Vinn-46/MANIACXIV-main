<?php

use App\Models\Acara;
use App\Models\Admin;
use App\Models\Contest;
use App\Models\Message;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        //
        // User
        //

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'participant', 'penpos', 'si', 'supersi', 'acara', 'judge']);
            $table->timestamps();
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('acara', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('school_name');
            $table->string('school_address');
            $table->string('school_number');
            $table->enum('status', ['waiting', 'verified', 'unverified', 'deactivated']);
            $table->string('payment_photo')->nullable();
            $table->timestamps();
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('email');
            $table->enum('position', ['leader', 'member']);
            $table->string('name');
            $table->string('phone_number');
            $table->string('student_photo');
            $table->string('alergi');
            $table->timestamps();
        });

        //
        // Chat
        //

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Admin::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Message::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->longText('message');
            $table->tinyInteger('is_from_admin');
            $table->tinyInteger('status');
            $table->timestamps();
        });

        //
        // Contest
        //

        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Acara::class, 'author_id')->constrained('acara')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamp('open_date')->nullable();
            $table->timestamp('close_date')->nullable();
            $table->enum('type', ['penyisihan', 'final', 'pengumuman', 'semifinal']);
            $table->timestamps();
        });

        Schema::create('contestants', function (Blueprint $table) {
            $table->foreignIdFor(Contest::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('join_date')->nullable();
            $table->timestamps();
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Contest::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Team::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->text('link')->unique();
            $table->double('score')->nullable()->default(0.0);
            $table->timestamps();
        });

        //
        // Authentication
        //

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        //
        // Internal logging
        //

        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');

        Schema::dropIfExists('password_reset_tokens');

        Schema::dropIfExists('chats');
        Schema::dropIfExists('messages');

        Schema::dropIfExists('submissions');
        Schema::dropIfExists('contestants');
        Schema::dropIfExists('contests');

        Schema::dropIfExists('participants');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('acara');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');
    }
};
