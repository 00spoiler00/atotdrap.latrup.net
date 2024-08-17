<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class PitrepEarner extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $start = $this->metrics()->where('type', 'pitrep')->where('created_at', '<=', now()->subWeek())->last()->pitrep;
        $end   = $this->metrics()->where('type', 'pitrep')->last()->pitrep;
        $gain  = $end - $start;

        return [
            'id'     => $this->id,
            'avatar' => $this->avatar_url,
            'title'  => $this->shortReadableId,
            'value'  => [
                'color' => 'blue',
                'text'  => $gain,
            ],
        ];
    }
}
