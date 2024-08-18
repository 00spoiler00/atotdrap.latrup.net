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
        Schema::table('metrics', function (Blueprint $table) {
            // Add types 'sr' and 'elo' to the type enum column
            $table->enum('type', ['pitskill', 'pitrep', 'sr', 'elo'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('metrics', function (Blueprint $table) {
            $table->enum('type', ['pitskill', 'pitrep'])->change();
        });
    }
};
