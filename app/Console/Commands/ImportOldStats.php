<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Track;
use App\Models\ClubMember;
use App\Models\Metric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
    protected $description = 'Imports the old hotlaps data from the server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = json_decode(file_get_contents(storage_path('stats.json')), true);

        foreach($data as $pitskillId => $records){
            $driver = ClubMember::where('pitskill_id', $pitskillId)->first();

            if(!$driver){
                continue;
            }   

            foreach($records['PitSkill'] as $ps){
                Metric::firstOrCreate([
                    'driver_id' => $driver->id,
                    'type' => 'pitskill',
                    'value' => $ps['value'],
                    'measured_at' => now()->createFromTimestamp($ps['date']),
                ]);
            }

            foreach($records['PitRep'] as $pr){
                Metric::firstOrCreate([
                    'driver_id' => $driver->id,
                    'type' => 'pitrep',
                    'value' => $pr['value'],
                    'measured_at' => now()->createFromTimestamp($pr['date']),
                ]);
            }
        }
    }
}
