<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class DriverWithAvatar extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->shortReadableId,
            'pitskill'   => $this->pitskill,
            'pitrep'     => $this->pitrep,
            'avatar_url' => $this->avatar_url,
        ];
    }
}
