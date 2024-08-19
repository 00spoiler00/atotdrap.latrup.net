<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class DriverList extends Resource
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
            'name'     => $this->shortReadableId,
            'avatar'   => $this->avatar_url,
            'pitskill' => $this->pitskill,
            'pitrep'   => $this->pitrep,
            'elo'      => $this->elo,
            'sr'       => $this->sr,
        ];
    }
}
