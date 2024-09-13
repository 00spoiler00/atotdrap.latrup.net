<?php

namespace App\Http\Resources;

use App\Actions\ConvertLaptime;
use App\Actions\HotlapMedals;
use App\Models\Hotlap;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class DriverTrackMedals extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $medals = Track::all()->map(function ($track) {
            $bestHotlap = Hotlap::query()
                ->where('track_id', $track->id)
                ->where('driver_id', $this->id)
                ->orderBy('laptime')
                ->first();

            return [
                'track'   => $track->readableId,
                'medal'   => $bestHotlap ? HotlapMedals::medalForHotlap($bestHotlap) : null,
                'tooltip' => "{$this->readableId} - {$track->readableId} - " . ($bestHotlap ? ConvertLaptime::execute($bestHotlap->laptime) : null),
            ];
        })->toArray();

        return [
            'driver' => new DriverList($this),
            'medals' => $medals,
            'total'  => collect($medals)->filter(fn ($medal) => $medal['medal'] != 'none')->count(),
        ];
    }
}
