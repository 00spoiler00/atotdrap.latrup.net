<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotlapList;
use App\Models\Hotlap;
use Illuminate\Http\Request;

class HotlapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Convert the comma-separated string into an array
        $driverIds = $request->has('driver_id') ? explode(',', $request->driver_id) : [];
        $trackIds  = $request->has('track_id') ? explode(',', $request->track_id) : [];
        $carIds    = $request->has('car_id') ? explode(',', $request->car_id) : [];

        $hotlaps = Hotlap::query()
            // If the request has a driver_id parameter, filter the hotlaps by driver_id
            ->when($driverIds, fn ($q) => $q->whereIn('driver_id', $driverIds))
            // If the request has a track_id parameter, filter the hotlaps by track_id
            ->when($trackIds, fn ($q) => $q->whereIn('track_id', $trackIds))
            // If the request has a car_id parameter, filter the hotlaps by car_id
            ->when($carIds, fn ($q) => $q->whereIn('car_id', $carIds))
            // If the request has a category parameter, filter the hotlaps by car's category
            ->when($request->has('category'), fn ($q) => $q->whereHas('car', fn ($q) => $q->where('category', $request->category)))
            // Sort by laptime
            ->orderBy('laptime')
            // Limit the results to 100
            ->limit(100)
            ->get();

        return HotlapList::collection($hotlaps);
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
