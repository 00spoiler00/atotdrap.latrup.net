<?php

namespace App\Http\Resources;

use App\Actions\ConvertLaptime;
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
            $bestTime = Hotlap::query()
                ->where('track_id', $track->id)
                ->where('driver_id', $this->id)
                ->orderBy('laptime')
                ->first();

            $medal = match (true) {
                $bestTime && $bestTime->laptime < $track->time_objective * 1.015 => 'gold',
                $bestTime && $bestTime->laptime < $track->time_objective * 1.025 => 'silver',
                $bestTime && $bestTime->laptime < $track->time_objective * 1.035 => 'bronze',
                default                                                          => 'none',
            };

            return [
                'track'   => $track->readableId,
                'medal'   => $medal,
                'tooltip' => "{$this->readableId} - {$track->readableId} - " . ($bestTime ? ConvertLaptime::execute($bestTime->laptime) : null),
            ];
        })->toArray();

        return [
            'driver' => new DriverList($this),
            'medals' => $medals,
            'total'  => collect($medals)->filter(fn ($medal) => $medal['medal'] != 'none')->count(),
        ];
    }
}
