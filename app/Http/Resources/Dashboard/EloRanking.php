<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class EloRanking extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'avatar' => $this->avatar_url,
            'title'  => $this->shortReadableId,
            // 'subtitle' => $this->starts_at->diffForHumans(),
            'value' => [
                'color' => 'red',
                'text'  => $this->elo,
            ],
        ];
    }
}
