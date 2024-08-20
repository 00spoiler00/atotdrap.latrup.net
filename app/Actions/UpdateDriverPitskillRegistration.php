<?php

namespace App\Actions;

use App\Models\Broadcast;
use App\Models\Car;
use App\Models\Driver;
use App\Models\Enrollment;
use App\Models\Race;
use App\Models\Track;

class UpdateDriverPitskillRegistration
{
    /**
     * Execute the console command.
     */
    public static function execute(Driver $driver, array $data)
    {
        // Process each event
        foreach ($data['payload'] as $event) {
            // Handle event information
            // Make sure the track exists
            $track = Track::updateOrCreate(
                [
                    'remote_id' => $event['track']['track_id'],
                ],
                [
                    'platform'    => 'pitskill',
                    'name'        => $event['track']['track_name_long'],
                    'track_year'  => $event['track']['track_year'],
                    'ingame_id'   => $event['track']['ingame_id'],
                    'country'     => $event['track']['country'],
                    'corners'     => $event['track']['corners'],
                    'length'      => $event['track']['length'],
                    'difficulty'  => $event['track']['difficulty'],
                    'city'        => $event['track']['city'],
                    'max_entries' => $event['track']['max_entries'],
                    'thumbnail'   => $event['track']['thumbnail'],
                    'track_guide' => $event['track']['track_guide'],
                ]
            );

            // Make sure the race exists
            $race = Race::updateOrCreate(
                [
                    'event_id' => $event['event_id'],
                    'platform' => 'pitskill',
                ],
                [
                    'starts_at'            => now()->parse($event['start_date'])->setTimezone(config('app.timezone')),
                    'name'                 => $event['event_name'],
                    'track_id'             => $track->id,
                    'registers'            => $event['registration_count'],
                    'registration_ends_at' => now()->parse($event['registration_close_date'])->setTimezone(config('app.timezone')),
                    'max_slots'            => $event['max_slots'],
                ]
            );

            // Process the broadcasts
            foreach ($event['broadcasters'] as $broadcast) {
                // Make sure the broadcast exists
                $broadcast = Broadcast::updateOrCreate([
                    'race_id'        => $race->id,
                    'name'           => $broadcast['broadcast_name'],
                    'url'            => $broadcast['broadcast_url'],
                    'remote_user_id' => $broadcast['user_id'],
                ]);
            }

            // Process all registrations
            foreach ($event['event_registrations'] as $registration) {
                $car = Car::findOrFail($registration['car']['car_id']);

                // UpdateOrCreate the driver
                Enrollment::updateOrCreate(
                    [
                        'driver_id' => $driver->id,
                        'race_id'   => $race->id,
                    ],
                    [
                        'car_id'      => $car->id,
                        'server_name' => $registration['vehicle_registration']['server']['server_name'],
                        'sof'         => $registration['vehicle_registration']['server']['server_strength_of_field'],
                        'split'       => $registration['vehicle_registration']['server']['server_split_index'],
                    ]
                );
            }
        }
    }
}
