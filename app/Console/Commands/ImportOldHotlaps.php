<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Track;
use Illuminate\Console\Command;

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
        $data = json_decode(file_get_contents(storage_path('hotlaps.json')), true);

        foreach ($data as $track => $records) {
            if (! $track = Track::where('ingame_id', $track)->first()) {
                $this->info('Track not found: ' . $track);
                continue;
            }

            foreach ($records as $record) {
                // Find the driver splitting the name and surname and doing a loose comparison
                $driver = Driver::where('first_name', 'like', '%' . explode(' ', $record['Driver'])[0] . '%')
                    ->where('last_name', 'like', '%' . explode(' ', $record['Driver'])[1] . '%')
                    ->first();

                if (! $driver) {
                    $this->info('Driver not found: ' . $record['Driver']);
                    continue;
                }

                if (! $car = Car::find($record['CarId'])->first()) {
                    $this->info('Car not found: ' . $record['CarId']);
                    continue;
                }
            }
        }
    }
}
