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
            // Add 'lfm_license' (string of 20, nullable) 'lfm_sr_license' (string length of 1, nullable),  'lfm_division' (integer nullable)
            $table->string('lfm_license', 20)->nullable()->after('pitskill');
            $table->string('lfm_sr_license', 20)->nullable()->after('lfm_license');
            $table->integer('lfm_division')->nullable()->after('lfm_sr_license');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drivers', function (Blueprint $table) {
            // Remove the fields
            $table->dropColumn('lfm_license');
            $table->dropColumn('lfm_sr_license');
            $table->dropColumn('lfm_division');
        });
    }
};
