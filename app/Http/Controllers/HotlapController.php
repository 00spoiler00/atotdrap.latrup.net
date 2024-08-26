<?php

namespace App\Http\Controllers;

use App\Http\Resources\DriverTrackMedals;
use App\Http\Resources\HotlapList;
use App\Http\Resources\Selector;
use App\Models\Driver;
use App\Models\Hotlap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotlapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $driverIds = $request->has('driver_id') ? explode(',', $request->driver_id) : [];
        $trackIds  = $request->has('track_id') ? explode(',', $request->track_id) : [];
        $carIds    = $request->has('car_id') ? explode(',', $request->car_id) : [];
        $mode      = $request->input('mode', 'all'); // Default to 'all' if mode is not provided

        $hotlapsQuery = Hotlap::query()
            ->when($driverIds, fn ($q) => $q->whereIn('hotlaps.driver_id', $driverIds))
            ->when($trackIds, fn ($q) => $q->whereIn('hotlaps.track_id', $trackIds))
            ->when($carIds, fn ($q) => $q->whereIn('hotlaps.car_id', $carIds));

        // Apply the mode logic
        if ($mode === 'best_driver_combo') {
            $subQuery = DB::table('hotlaps')
                ->select('hotlaps.car_id', 'hotlaps.driver_id', 'hotlaps.track_id', DB::raw('MIN(laptime) as min_laptime'))
                ->groupBy('hotlaps.car_id', 'hotlaps.driver_id', 'hotlaps.track_id');

            $hotlapsQuery->joinSub($subQuery, 'min_laps', function ($join) {
                $join->on('hotlaps.car_id', '=', 'min_laps.car_id')
                    ->on('hotlaps.driver_id', '=', 'min_laps.driver_id')
                    ->on('hotlaps.track_id', '=', 'min_laps.track_id')
                    ->on('hotlaps.laptime', '=', 'min_laps.min_laptime');
            });
        } elseif ($mode === 'best_driver') {
            $subQuery = DB::table('hotlaps')
                ->select('hotlaps.driver_id', 'hotlaps.track_id', DB::raw('MIN(laptime) as min_laptime'))
                ->groupBy('hotlaps.driver_id', 'hotlaps.track_id');

            $hotlapsQuery->joinSub($subQuery, 'min_laps', function ($join) {
                $join->on('hotlaps.driver_id', '=', 'min_laps.driver_id')
                    ->on('hotlaps.track_id', '=', 'min_laps.track_id')
                    ->on('hotlaps.laptime', '=', 'min_laps.min_laptime');
            });
        }

        // Ensure that all where clauses are properly prefixed with table names to avoid ambiguity
        $hotlapsQuery->where(function ($query) use ($trackIds, $driverIds, $carIds) {
            if ($trackIds) {
                $query->whereIn('hotlaps.track_id', $trackIds);
            }
            if ($driverIds) {
                $query->whereIn('hotlaps.driver_id', $driverIds);
            }
            if ($carIds) {
                $query->whereIn('hotlaps.car_id', $carIds);
            }
        });

        // Sorting and limiting results
        $hotlaps = $hotlapsQuery
            ->orderBy('hotlaps.laptime')
            ->limit(100)
            ->get();

        return HotlapList::collection($hotlaps);
    }

    public function liveTrack()
    {
        return new Selector(Hotlap::orderBy('created_at', 'desc')->first()->track);
    }

    public function trackMedals()
    {
        $data = Driver::has('hotlaps')->get();

        return DriverTrackMedals::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotlap $hotlap)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hotlap $hotlap)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotlap $hotlap)
    {
    }
}
