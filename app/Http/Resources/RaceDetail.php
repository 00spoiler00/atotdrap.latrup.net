<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class RaceDetail extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'platform'  => $this->platform,
            'event_id'  => $this->event_id,
            'starts_at' => $this->starts_at,
            'name'      => $this->name,
            'registers' => $this->registers,
            'track_id'  => $this->track->id,
            'servers'   => $this
                ->enrollments
                ->pluck('server_name')
                ->unique()
                ->map(function ($server) {
                    // Get the matching enrollments
                    $enrollments = $this->enrollments()->where('server_name', $server)->orderBy('created_at', 'desc')->get();

                    // Create the resource
                    return [
                        'name'    => $server,
                        'split'   => $enrollments->first()->split,
                        'sof'     => $enrollments->first()->sof,
                        'split'   => $enrollments->first()->split,
                        'enrolls' => $enrollments->map(fn ($e) => [
                            'driver_id'          => $e->driver->id,
                            'driver_name'        => $e->driver->shortReadableId,
                            'driver_avatar'      => $e->driver->avatar_url,
                            'driver_pitskill_id' => $e->driver->clubmember->pitskill_id,
                            'driver_lfm_id'      => $e->driver->clubmember->lfm_id,
                        ]),
                    ];
                })
                ->toArray(),
        ];
    }
}
