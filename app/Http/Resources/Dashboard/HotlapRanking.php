<?php

namespace App\Http\Resources\Dashboard;

use App\Actions\HotlapMedals;
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
        $medalColorsMapper = [
            'gold'   => 'yellow',
            'silver' => 'white',
            'bronze' => 'brown',
            'none'   => 'gray',
        ];

        return [
            'id'       => $this->driver->id,
            'avatar'   => $this->driver->avatar_url,
            'title'    => $this->driver->shortReadableId,
            'subtitle' => $this->car->shortReadableId,
            'value'    => [
                'color' => $medalColorsMapper[HotlapMedals::medalForHotlap($this->resource)],
                'text'  => $this->readableLapTime,
            ],
        ];
    }
}
