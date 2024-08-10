<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Track;
use Carbon\Carbon;
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

        Log::info('Updating ' . count($files) . ' hotlap files from the server');

        foreach ($files as $file) {
            Log::info('Processing file', ['file' => $file]);
            $this->processFile($file);
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

        // Find the track by ingame_id
        $track = Track::where('ingame_id', $data['trackName'])->first();
        if (! $track) {
            Log::error('Track not found', $data['trackName']);

            return;
        }

        $date = now()->createFromFormat('ymd', $fileDate);

        $fails = collect($data['sessionResult']['leaderBoardLines'])
            ->map(fn ($hotlap) => $this->processHotlap($date, $track, $hotlap))
            ->filter(fn ($fail) => $fail)
            ->isEmpty();

        // Delete the file if 'date' is older that two days
        if (! $fails && $date->diffInDays(now()) > 2) {
            Log::error('Deleting file', ['file' => $file]);
            unlink($file);
        }
    }

    private function processHotlap(Carbon $date, Track $track, array $hotlap)
    {
        // Car matching
        $car = Car::find($hotlap['car']['carModel']);

        // Otherwise just report the error
        if (! $car) {
            Log::error('Car not found', $hotlap['car']['carModel']);

            return false;
        }

        // Driver matching via first and last name or steam_id
        $driver = Driver::query()
            ->where('first_name', $hotlap['currentDriver']['firstName'])
            ->where('last_name', $hotlap['currentDriver']['lastName'])
            ->orWhere('steam_id', $hotlap['currentDriver']['playerId'])
            ->first();

        // Otherwise just report the error
        if (! $driver) {
            Log::error('Driver not found', $hotlap['currentDriver']);

            return false;
        }

        if ($driver->steam_id != $hotlap['currentDriver']['playerId']) {
            $driver->update(['steam_id' => $hotlap['currentDriver']['playerId']]);
        }

        $laptime = $hotlap['timing']['bestLap'];

        // Disacard bad lap times
        if ($laptime === 0 || $laptime === 2147483647) {
            return true;
        }

        return Hotlap::firstOrCreate([
            'driver_id'   => $driver->id,
            'track_id'    => $track->id,
            'car_id'      => $car->id,
            'laptime'     => $laptime,
            'measured_at' => $date->format('Y-m-d'),
        ]);
    }
}
