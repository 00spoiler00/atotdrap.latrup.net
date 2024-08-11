<?php

namespace App\Http\Controllers;

use App\Http\Resources\RaceDetail;
use App\Http\Resources\RaceList;
use App\Models\Race;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Race $race)
    {
        return new RaceDetail($race);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Race $race) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Race $race) {}

    /**
     * Get the upcoming
     */
    public function upcoming()
    {
        $races = Race::where('starts_at', '>', now())
            ->orderBy('starts_at')
            ->with('track', 'enrollments', 'enrollments.driver')
            ->get();

        return RaceList::collection($races);
    }
}
