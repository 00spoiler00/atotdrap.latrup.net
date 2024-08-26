<?php

use App\Models\Track;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            // Add an integer column named `time_objective` to the `tracks` table
            $table->integer('time_objective')->nullable()->after('thumbnail');

            // Make all the existing fields nullable
            $table->string('remote_id')->nullable()->change();
            $table->string('track_year')->nullable()->change();
            $table->string('country')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->string('thumbnail')->nullable()->change();
            $table->string('track_guide')->nullable()->change();
            $table->integer('corners')->nullable()->change();
            $table->integer('length')->nullable()->change();
            $table->integer('difficulty')->nullable()->change();
            $table->integer('max_entries')->nullable()->change();
        });

        // Seed the `time_objective` column with the target times for each track

        $lapTimes = [
            'barcelona'       => 102097,
            'brands_hatch'    => 81950,
            'cota'            => 123802,
            'donington'       => 85260,
            'hungaroring'     => 101790,
            'imola'           => 99247,
            'indianapolis'    => 94062,
            'kyalami'         => 99432,
            'laguna_seca'     => 80965,
            'misano'          => 92077,
            'monza'           => 105082,
            'mount_panorama'  => 118800,
            'nurburgring'     => 112112,
            'nurburgring_24h' => 482580,
            'oulton_park'     => 91565,
            'paul_ricard'     => 111930,
            'red_bull_ring'   => 86695,
            'silverstone'     => 116135,
            'snetterton'      => 104662,
            'spa'             => 134955,
            'suzuka'          => 117225,
            'valencia'        => 89465,
            'watkins_glen'    => 102072,
            'zandvoort'       => 93905,
            'zolder'          => 86460,
        ];

        collect($lapTimes)->each(function ($time, $ingameId) {
            Track::updateOrCreate(['ingame_id' => $ingameId], [
                'name'           => $ingameId,
                'time_objective' => $time,
                'platform'       => 'pitskill',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracks', function (Blueprint $table) {
            // Drop the `time_objective` column from the `tracks` table
            $table->dropColumn('time_objective');
        });
    }
};
