<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $directory = config('atotdrap.hotlaps.directory');

        // Get all the files from the hotlaps storage
        // dd(Storage::disk('hotlaps')->allFiles());

        $files = glob($directory . '/*.json');

        Log::info('Updating ' . count($files) . ' hotlap files from the server');

        foreach ($files as $file) {
            // Reenable when files are getting deleted
            // Log::info('Processing file', ['file' => $file]);
            $this->processFile($file);
        }
    }

    protected function finishAndReport(bool $deleteFile, string $file, string $message): void
    {
        if ($deleteFile) {
            Log::info('Deleting file. Finished: ', ['message' => $message, 'file' => $file]);

            // Move the file from the 'hotlaps' storage to 'local' storage, in folder 'hotlap_archive'
            // Storage::disk('local')->move($file, 'hotlap_archive/' . basename($file));

        } else {
            Log::info('Finished:', ['message' => $message, 'file' => $file]);
        }
    }

    protected function processHotlap(Carbon $date, Track $track, array $hotlap): true|string
    {
        // Car matching
        $car = Car::find($hotlap['car']['carModel']);

        // Otherwise just report the error
        if (! $car) {
            return 'Car not found' . $hotlap['car']['carModel'];
        }

        // Driver matching via first and last name or steam_id
        $driver = Driver::query()
            ->where('first_name', $hotlap['currentDriver']['firstName'])
            ->where('last_name', $hotlap['currentDriver']['lastName'])
            ->orWhere('steam_id', $hotlap['currentDriver']['playerId'])
            ->first();

        // Otherwise just report the error
        if (! $driver) {
            return 'Driver not found' . $hotlap['currentDriver']['firstName'] . ' ' . $hotlap['currentDriver']['lastName'];
        }

        if ($driver->steam_id != $hotlap['currentDriver']['playerId']) {
            $driver->update(['steam_id' => $hotlap['currentDriver']['playerId']]);
        }

        $laptime = $hotlap['timing']['bestLap'];

        // Discard bad lap times
        if ($laptime === 0 || $laptime === 2147483647) {
            return true;
        }

        Hotlap::firstOrCreate([
            'driver_id' => $driver->id,
            'track_id'  => $track->id,
            'car_id'    => $car->id,
            'laptime'   => $laptime,
        ], [
            'measured_at' => $date,
        ]);

        return true;
    }

    private function processFile(string $file)
    {
        if (preg_match('/(\d{6})_/', basename($file), $matches)) {
            $date = now()->createFromFormat('ymd', $matches[1]);
        }

        if (! $date) {
            return $this->finishAndReport(false, $file, 'ERROR: Unparseable date in filename');
        }

        $data = json_decode(mb_convert_encoding(file_get_contents($file), 'UTF-8', 'UTF-16LE'), true);

        // Find the track by ingame_id

        if (! isset($data['trackName'])) {
            return $this->finishAndReport(true, $file, 'ERROR: trackName key not found in record, probably and entrylist file');
        }

        $track = Track::where('ingame_id', $data['trackName'])->first();
        if (! $track) {
            return $this->finishAndReport(false, $file, 'ERROR: Track not found ' + $data['trackName']);
        }

        if (! isset($data['sessionResult']['leaderBoardLines'])) {
            return $this->finishAndReport(true, $file, 'No leaderBoardLines key found in record');
        }

        $results = collect($data['sessionResult']['leaderBoardLines']);

        if ($results->isEmpty()) {
            return $this->finishAndReport(true, $file, 'No leaderBoardLines found in record');
        }

        $fails = $results
            ->map(fn ($hotlap) => $this->processHotlap($date, $track, $hotlap))
            ->filter(fn ($response) => $response !== true);

        return $fails->isEmpty()
            ? $this->finishAndReport(true, $file, 'File processed successfully')
            : $this->finishAndReport(false, $file, 'File failed processing: ' . $fails->join('||'));
    }
}
