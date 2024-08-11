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
            'id'              => $this->id,
            'event_id'        => $this->event_id,
            'starts_at'       => $this->starts_at->timestamp,
            'name'            => $this->name,
            'registers'       => $this->registers,
            'drivers' => DriverWithAvatar::collection($this->enrollments->map(fn($e) => $e->driver)),
            'track_name'      => $this->track->name,
        ];
    }
}
