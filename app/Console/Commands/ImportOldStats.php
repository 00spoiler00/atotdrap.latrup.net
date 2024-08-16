<?php

namespace App\Console\Commands;

use App\Models\ClubMember;
use App\Models\Metric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportOldStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-old-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports the old stats data from the server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $content = Storage::disk('local')->get('stats.json');
        $data    = json_decode($content, true);

        foreach ($data as $pitskillId => $records) {
            $driver = ClubMember::where('pitskill_id', $pitskillId)->first();

            if (! $driver) {
                continue;
            }

            foreach ($records['PitSkill'] as $ps) {
                Metric::firstOrCreate([
                    'driver_id'   => $driver->id,
                    'type'        => 'pitskill',
                    'value'       => $ps['value'],
                    'measured_at' => now()->createFromTimestamp($ps['date']),
                ]);
            }

            foreach ($records['PitRep'] as $pr) {
                Metric::firstOrCreate([
                    'driver_id'   => $driver->id,
                    'type'        => 'pitrep',
                    'value'       => $pr['value'],
                    'measured_at' => now()->createFromTimestamp($pr['date']),
                ]);
            }
        }
    }
}
