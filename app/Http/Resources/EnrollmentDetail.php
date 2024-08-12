<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class EnrollmentDetail extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'driver'      => new DriverWithAvatar($this->driver),
            'car'         => $this->car->readableId,
            'server_name' => $this->server_name,
            'sof'         => $this->sof,
            'split'       => $this->split,
        ];
    }
}
