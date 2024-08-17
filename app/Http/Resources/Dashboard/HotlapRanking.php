<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class HotlapRanking extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->driver->id,
            'avatar'   => $this->driver->avatar_url,
            'title'    => $this->driver->shortReadableId,
            'subtitle' => $this->car->readableId,
            'value'    => [
                'color' => 'success',
                'text'  => $this->readableLapTime,
            ],
        ];
    }
}
