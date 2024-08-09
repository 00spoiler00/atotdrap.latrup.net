<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('steam_id')->unique()->nullable();
            $table->foreignIdFor(\App\Models\ClubMember::class)->constrained();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('short_name');
            $table->string('nickname');
            $table->string('avatar_url');
            $table->string('discord_uid')->nullable();
            $table->float('pitrep', 4, 1)->default(0);
            $table->float('pitskill', 4, 1)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
