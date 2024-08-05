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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->integer('remote_id')->unique();
            $table->string('name')->unique();
            $table->integer('track_year');
            $table->string('ingame_id');
            $table->string('country');
            $table->integer('corners');
            $table->float('length', 5, 2);
            $table->integer('difficulty');
            $table->string('city');
            $table->integer('max_entries');
            $table->string('thumbnail');
            $table->string('track_guide')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
