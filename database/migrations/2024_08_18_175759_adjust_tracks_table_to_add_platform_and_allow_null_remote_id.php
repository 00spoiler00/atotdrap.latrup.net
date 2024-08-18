<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            // Modify the 'remote_id' column to allow null values
            $table->string('remote_id')->nullable()->change();
            // Add a new enum column 'platform' to the table tracks with values 'lfm' and 'pitskill'. Make it nullable
            $table->enum('platform', ['lfm', 'pitskill'])->after('id')->nullable();
        });

        // Update the existing records to be all 'pitskill'
        DB::table('tracks')->update(['platform' => 'pitskill']);

        // Step 3: Modify the 'platform' column to be not nullable
        Schema::table('tracks', function (Blueprint $table) {
            $table->enum('platform', ['lfm', 'pitskill'])
                ->nullable(false)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {

        });
    }
};
