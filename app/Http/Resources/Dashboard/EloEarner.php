<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Metric;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class EloEarner extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $type = 'elo';

        $start = Metric::whereHas('driver', fn ($q) => $q->where('id', $this->id))
            ->where('type', $type)
            ->where('measured_at', '<', now()->subWeek())
            ->orderBy('measured_at', 'desc')
            ->first()
            ->value;

        $end = Metric::query()
            ->whereHas('driver', fn ($q) => $q->where('id', $this->id))
            ->where('type', $type)
            ->where('measured_at', '>', now()->subWeek())
            ->orderBy('measured_at', 'desc')
            ->first()
            ->value;

        $gain = round($end - $start, 2);

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
