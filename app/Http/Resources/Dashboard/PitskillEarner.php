<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class PitskillEarner extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $start = $this->metrics()->where('type', 'pitskill')->where('created_at', '<=', now()->subWeek())->last()->pitskill;
        $end   = $this->metrics()->where('type', 'pitskill')->last()->pitskill;
        $gain  = $end - $start;

        return [
            'id'     => $this->id,
            'avatar' => $this->avatar_url,
            'title'  => $this->shortReadableId,
            // 'subtitle' => $this->starts_at->diffForHumans(),
            'value' => [
                'color' => 'red',
                'text'  => $gain,
            ],
        ];
    }
}
