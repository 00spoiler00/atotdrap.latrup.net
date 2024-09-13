<?php

namespace App\Actions;

use App\Models\Hotlap;
use App\Models\Track;

class HotlapMedals
{
    /**
     * Get the medal for the given Hotlap.
     */
    public static function medalForHotlap(Hotlap $hotlap): string
    {
        $objectives = self::trackMedals($hotlap->track);

        foreach ($objectives as $medal => $time) {
            if ($hotlap->laptime < $time) {
                return $medal;
            }
        }

        return 'none';
    }

    /**
     * Get track medal objectives.
     *
     * @param mixed $humanReadable
     */
    public static function trackMedals(Track $track, $humanReadable = false): array
    {
        $baseTime = $track->time_objective;

        $base = [
            'gold'   => $baseTime * 1.015,
            'silver' => $baseTime * 1.025,
            'bronze' => $baseTime * 1.035,
        ];

        return ($humanReadable)
            ? array_map(fn ($time) => ConvertLaptime::execute($time), $base)
            : $base;
    }
}
