<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class RaceList extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->resource);
        // return parent::toArray($request);
        return [
            'id'         => $this->id,
            'event_id'   => $this->event_id,
            'starts_at'  => $this->starts_at,
            'name'       => $this->name,
            'registers'  => $this->registers,
            'drivers'    => DriverWithAvatar::collection($this->enrollments->map(fn ($e) => $e->driver)),
            'track_id'   => $this->track->id,
            'track_name' => $this->track->name,
        ];
    }
}
