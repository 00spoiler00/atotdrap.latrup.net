<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Track;
use Illuminate\Console\Command;

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
        foreach ($files as $file) {
            $this->processFile($file);
            // unlink($file);
        }
    }

    private function processFile($file)
    {
        preg_match('/(\d{6})_/', basename($file), $matches);
        $fileDate = $matches[1] ?? 'unknown';
        $date     = now()->createFromFormat('ymd', $fileDate)->format('Y-m-d');

        $data = json_decode(mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UTF-16LE'), true);

        if (! isset($data['sessionResult']['leaderBoardLines'])) {
            return;
        }

        $hotlaps = $data['sessionResult']['leaderBoardLines'];
        foreach ($hotlaps as $hotlap) {
            $car    = Car::findOrFail($hotlap['car']['carModel']);
            $driver = Driver::firstOrUpdate(
                ['playerId' => $hotlap['currentDriver']['playerId']],
                [
                    'steamId' => $hotlap['currentDriver']['playerId'],
                ]
            );
            $track = Track::findOrFail($data['sessionResult']['trackId']);

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
                'date'      => $date,
            ]);
        }
    }
}
