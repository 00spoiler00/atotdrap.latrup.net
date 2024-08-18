<?php

namespace App\Actions;

use App\Models\Car;
use App\Models\Driver;
use App\Models\Enrollment;
use App\Models\Race;
use App\Models\Track;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateDriverLfmRegistration
{
    /**
     * Execute the console command.
     */
    public static function execute(Driver $driver, array $data)
    {
        Log::info('Updating driver registrations from the remote api');

        // Process each event
        foreach ($data as $event) {
            // If the enrollment exists, do not process to avoid overloading the remote servers
            if (Enrollment::where('driver_id', $driver->id)->where('race_id', $event['race_id'])->exists()) {
                continue;
            }

            // Fetch the race data
            $raceData = Http::get("https://api.lowfuelmotorsport.de/api/race/{$event['race_id']}")->json();

            // Remove the year from the track id, somehow the still use it and needs to be removed
            $trackId = preg_replace('/_\d{4}$/', '', $raceData['track']['acc_track_name']);

            $track = Track::updateOrCreate(
                [
                    'ingame_id' => $trackId,
                ],
                [
                    'source_platform' => 'lfm',
                    'name'            => $raceData['track']['track_name'],
                    'track_year'      => $raceData['track']['track_year'],
                    'country'         => $raceData['track']['country'],
                    'corners'         => $raceData['track']['turns'],
                    'length'          => $raceData['track']['km'],
                    'difficulty'      => $raceData['track']['turn_factor'],
                    'city'            => $raceData['track']['city'],
                    'thumbnail'       => $raceData['track']['thumbnail'],
                    'track_guide'     => $raceData['track']['track_guide_video'],
                    'max_entries'     => 0,
                ]
            );

            // Parse the start date and handle the timezone
            $raceStart = now()->parse($event['race_date'])->setTimezone(config('app.timezone'));

            $race = Race::updateOrCreate(
                [
                    'event_id' => $event['race_id'],
                    'platform' => 'lfm',
                ],
                [
                    'name'                 => $event['event_name'],
                    'starts_at'            => $raceStart,
                    'track_id'             => $track->id,
                    'registers'            => $raceData['splits']['driver_count'],
                    'max_slots'            => $raceData['server_settings']['server_settings']['settings']['data']['maxCarSlots'],
                    'registration_ends_at' => $raceStart->clone()->subMinutes(5),
                    'lfm_enrollment_code'  => $raceData['event']['url_code'],
                ]
            );

            // Find the car in the race info
            $participants = collect($raceData['participants']['entries']);

            // Find in the participants collection
            $participant = $participants->firstWhere('user_id', '=', $driver->clubMember->lfm_id);
            $car         = Car::findOrFail($participant['car_model']);

            // UpdateOrCreate the driver
            Enrollment::updateOrCreate(
                [
                    'driver_id' => $driver->id,
                    'race_id'   => $race->id,
                ],
                [
                    'car_id'      => $car->id,
                    'server_name' => $raceData['server_settings']['server_settings']['settings']['data']['serverName'],
                    'sof'         => $event['sof'],
                    'split'       => $event['split'],
                ]
            );
        }
    }
}
