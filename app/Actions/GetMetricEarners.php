<?php

namespace App\Actions;

use App\Models\Driver;
use App\Models\Metric;

class GetMetricEarners
{
    /**
     * Get the pitskill earners.
     *
     * @param mixed $limit
     *
     * @return \Illuminate\Database\Eloquent\Collection<\App\Models\Driver>
     */
    public static function execute(string $type, $limit = 3): \Illuminate\Database\Eloquent\Collection
    {
        abort_if(! in_array($type, ['pitskill', 'pitrep', 'elo', 'sr']), 404);

        return Driver::query()
            ->whereHas('metrics', fn ($q) => $q->where('type', $type)->where('measured_at', '>', now()->subWeek()))
            ->whereHas('metrics', fn ($q) => $q->where('type', $type)->where('measured_at', '<', now()->subWeek()))
            ->get()
            ->sortByDesc(function ($driver) use ($type) {
                $start = Metric::whereHas('driver', fn ($q) => $q->where('id', $driver->id))
                    ->where('type', $type)
                    ->where('measured_at', '<', now()->subWeek())
                    ->orderBy('measured_at', 'desc')
                    ->first()
                    ->value;

                $end = Metric::query()
                    ->whereHas('driver', fn ($q) => $q->where('id', $driver->id))
                    ->where('type', $type)
                    ->where('measured_at', '>', now()->subWeek())
                    ->orderBy('measured_at', 'desc')
                    ->first()
                    ->value;

                return $end - $start;
            })
            ->take($limit);
    }
}
