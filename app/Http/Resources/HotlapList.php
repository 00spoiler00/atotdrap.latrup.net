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
        return [
            'id'          => $this->id,
            'category'    => $this->car->category,
            'track'       => $this->track->name,
            'driver'      => $this->driver->shortReadableId,
            'car'         => $this->car->shortReadableId,
            'laptime'     => $this->laptime,
            'measured_at' => $this->measured_at,
        ];
    }
}
