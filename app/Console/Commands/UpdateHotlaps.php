<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Track;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateHotlaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-hotlaps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates the hotlaps data from server';

    private static $directory = '/home/marc/accServers/acc-server-00/results';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $files = glob(self::$directory . '/*.json');
     
        Log::info('Updating '.count($files).' hotlap files from the server');

        foreach ($files as $file) {
            // Log::info('Processing file', ['file' => $file]);
            $this->processFile($file);
            // unlink($file);
        }
    }

    private function processFile($file)
    {
        preg_match('/(\d{6})_/', basename($file), $matches);
        $fileDate = $matches[1] ?? 'unknown';
        
        $data = json_decode(mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UTF-16LE'), true);
        if (! isset($data['sessionResult']['leaderBoardLines'])) {
            return;
        }
        
        $date     = now()->createFromFormat('ymd', $fileDate)->format('Y-m-d');
        // Find the track by ingame_id
        $track = Track::where('ingame_id', $data['trackName'])->first();
        if (! $track) {
            Log::error('Track not found', $data['trackName']);
            return;
        }

        foreach ($data['sessionResult']['leaderBoardLines'] as $hotlap) {

            $car    = Car::findOrFail($hotlap['car']['carModel']);
            $driver = Driver::query()
                ->where('first_name', $hotlap['currentDriver']['firstName'])
                ->where('last_name', $hotlap['currentDriver']['lastName'])
                ->first()
            ;

            if (! $driver) {
                Log::error('Driver not found', $hotlap['currentDriver']);
                continue;
            }

            if($driver->steam_id != $hotlap['currentDriver']['playerId']) {
                $driver->update(['steam_id' => $hotlap['currentDriver']['playerId']]);
            }
                
            $laptime = $hotlap['timing']['bestLap'];
                
            // Disacard bad lap times
            if ($laptime === 0 || $laptime === 2147483647) {
                return;
            }
                
            Hotlap::firstOrCreate([
                'driver_id' => $driver->id,
                'track_id'  => $track->id,
                'car_id'    => $car->id,
                'laptime'   => $laptime,
                'measured_at'      => $date,
            ]);
        }
    }
}
