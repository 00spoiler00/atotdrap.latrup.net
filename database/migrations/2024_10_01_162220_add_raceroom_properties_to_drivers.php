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
        Schema::table('drivers', function (Blueprint $table) {
            $table->float('raceroom_rating', 4, 1)->nullable()->after('lfm_division');
            $table->float('raceroom_reputation', 4, 1)->nullable()->after('raceroom_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            // Remove the fields
            $table->dropColumn('raceroom_rating');
            $table->dropColumn('racerroom_reputation');
        });
    }
};
