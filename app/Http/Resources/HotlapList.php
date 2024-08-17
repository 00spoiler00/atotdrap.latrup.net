<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class HotlapList extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->resource);

        // "driver_id" => 5
        // "track_id" => 1
        // "car_id" => 32
        // "laptime" => 138325
        // "measured_at" => "2024-08-06 00:00:00"

        return [
            'id'           => $this->id,
            'driver'       => $this->driver->readableId,
            'track'        => $this->track->name,
            'car'          => $this->car->shortReadableId,
            'car_category' => $this->car->category,
            'laptime'      => $this->laptime,
            'measured_at'  => $this->measured_at,
        ];
    }
}
