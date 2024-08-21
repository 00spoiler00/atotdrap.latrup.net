<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Track;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportOldHotlaps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-old-hotlaps';

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
        $content = Storage::disk('local')->get('hotlaps.json');
        $data    = json_decode($content, true);

        foreach ($data as $track => $records) {
            if (! $track = Track::where('ingame_id', $track)->first()) {
                $this->info('Track not found: ' . $track);
                continue;
            }

            foreach ($records as $record) {
                $record['TrackId']   = $track->id;
                $record['TrackName'] = $track->name;

                // Find the driver splitting the name and surname and doing a loose comparison
                $driver = Driver::query()
                    ->where(
                        fn ($q) => $q
                            ->where('first_name', 'like', '%' . explode(' ', $record['Driver'])[0] . '%')
                            ->where('last_name', 'like', '%' . explode(' ', $record['Driver'])[1] . '%')
                    )
                    ->orWhere('steam_id', $record['DriverId'])
                    ->first();

                if (! $driver) {
                    $this->info('Driver not found: ' . $record['Driver']);
                    continue;
                }

                if (! $car = Car::find($record['CarId'])) {
                    $this->info('Car not found: ' . $record['CarId']);
                    continue;
                }

                $hotlap = Hotlap::where([
                    'driver_id'   => $driver->id,
                    'track_id'    => $track->id,
                    'car_id'      => $car->id,
                    'laptime'     => $record['Laptime'],
                    'measured_at' => now()->parse($record['Date']),
                ])->first();

                if (! $hotlap) {
                    $this->info('Hotlap not found, creating: ' . $record['Driver'] . ' - ' . $record['Laptime']);
                    $hotlap = Hotlap::create([
                        'driver_id'   => $driver->id,
                        'track_id'    => $track->id,
                        'car_id'      => $car->id,
                        'laptime'     => $record['Laptime'],
                        'measured_at' => now()->parse($record['Date']),
                        'created_at' => now()->parse($record['Date']),
                        'updated_at' => now()->parse($record['Date']),
                    ]);
                }
            }
        }

        $this->table(array_keys($records[0]), $notFound ?? []);
    }
}
