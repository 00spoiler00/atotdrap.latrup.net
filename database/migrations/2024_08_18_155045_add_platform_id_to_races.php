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
        Schema::table('races', function (Blueprint $table) {
            // Add an enum column to the table races with values 'lfm' and 'pitskill'. Make it nullable
            $table->enum('platform', ['lfm', 'pitskill'])->after('id')->nullable();
        });

        // Update the existing records to be all 'pitskill'
        DB::table('races')->update(['platform' => 'pitskill']);

        // Step 3: Modify the 'platform' column to be not nullable
        Schema::table('races', function (Blueprint $table) {
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
        Schema::table('races', function (Blueprint $table) {
            // Remove the columns
            $table->dropColumn('platform');
        });
    }
};
