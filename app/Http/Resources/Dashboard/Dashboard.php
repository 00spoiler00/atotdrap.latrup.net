<?php

namespace App\Http\Resources\Dashboard;

use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class Dashboard extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $listLimit = 3;

        $upcomingRaces   = Race::where('starts_at', '>', now())->limit($listLimit)->get();
        $pitskillLeaders = Driver::orderBy('pitskill', 'desc')->limit($listLimit)->get();
        $pitrepLeaders   = Driver::orderBy('pitrep', 'desc')->limit($listLimit)->get();

        // Compute the pitskill earners:
        // Measure the biggest increase in 'pitskill' Metric between today and one week ago
        $pitskillEarners = Driver::query()
            ->whereHas('metrics', fn ($q) => $q->where('created_at', '>', now()->subWeek()))
            ->get()->sortByDesc(function ($driver) {
                return
                    $driver->metrics()->where('type', 'pitskill')->where('created_at', '<=', now()->subWeek())->last()->pitskill
                    - $driver->metrics()->where('type', 'pitskill')->last()->pitskill;
            })
            ->take($listLimit);

        $pitreplEarners = Driver::query()
            ->whereHas('metrics', fn ($q) => $q->where('created_at', '>', now()->subWeek()))
            ->get()->sortByDesc(function ($driver) {
                return
                    $driver->metrics()->where('type', 'pitrep')->where('created_at', '<=', now()->subWeek())->last()->pitrep
                    - $driver->metrics()->where('type', 'pitrep')->last()->pitrep;
            })
            ->take($listLimit);

        // Get the track of the last recorded hotlap
        $hotlapTrack = Hotlap::orderBy('created_at', 'desc')->first()->track;
        $hotlaps     = Hotlap::whereHas('track', fn ($q) => $q->where('id', $hotlapTrack->id))->orderBy('laptime', 'asc')->limit($listLimit)->get();

        return [
            'pitskill' => [
                'races' => [
                    'title'       => 'Properes curses',
                    'targetModel' => 'Race',
                    'data'        => UpcomingRace::collection($upcomingRaces),
                ],
                'pitskill' => [
                    'earners' => [
                        'title'       => 'Pujades Skill',
                        'targetModel' => 'Driver',
                        'data'        => PitskillEarner::collection($pitskillEarners),
                    ],
                    'ranking' => [
                        'title'       => 'PitSkill ranking',
                        'targetModel' => 'Driver',
                        'data'        => PitskillRanking::collection($pitskillLeaders),
                    ],
                ],
                'pitrep' => [
                    'earners' => [
                        'title'       => 'Pujades Rep',
                        'targetModel' => 'Driver',
                        'data'        => PitrepEarner::collection($pitreplEarners),
                    ],
                    'ranking' => [
                        'title'       => 'PitRep ranking',
                        'targetModel' => 'Driver',
                        'data'        => PitrepRanking::collection($pitrepLeaders),
                    ],
                ],
                'hotlaps' => [
                    'title'       => 'Hotlaps ' . $hotlapTrack->readableId,
                    'targetModel' => 'Driver',
                    'data'        => HotlapRanking::collection($hotlaps),
                ],
            ],
        ];
    }
}
