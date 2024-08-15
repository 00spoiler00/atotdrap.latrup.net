<?php

namespace App\Http\Resources\Cards;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class Driver extends Resource
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
            'subtitle' => $this->pitskill . ' / ' . $this->pitrep,
            'avatar'   => $this->avatar_url,
            'route'    => '/driver/' . $this->id,
            'icon'     => 'mdi-account',
        ];
    }
}
