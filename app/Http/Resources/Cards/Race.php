<?php

namespace App\Http\Resources\Cards;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class Race extends Resource
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
            'title'    => $this->readableId,
            'subtitle' => $this->enrollments()->count(),
            'avatar'   => $this->track->avatarUrl,
            'route'    => '/race/' . $this->id,
            'icon'     => 'mdi-flag-checkered',
        ];
    }
}
