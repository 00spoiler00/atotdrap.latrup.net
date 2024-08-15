<?php

namespace App\Http\Resources\Cards;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class Track extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->shortReadableId,
            'subtitle' => $this->city,
            'avatar'   => $this->avatar_url,
            'route'    => '/track/' . $this->id,
            'icon'     => 'mdi-racetrack',
        ];
    }
}
