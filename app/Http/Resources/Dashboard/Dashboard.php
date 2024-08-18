<?php

namespace App\Http\Resources\Dashboard;

use App\Actions\GetMetricEarners;
use App\Models\Driver;
use App\Models\Hotlap;
use App\Models\Race;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use Illuminate\Support\Facades\DB;

class Dashboard extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $limit = $request->get('limit', 5);

        $upcomingRaces   = Race::where('starts_at', '>', now())->limit($limit)->get();
        $pitskillLeaders = Driver::orderBy('pitskill', 'desc')->limit($limit)->get();
        $pitrepLeaders   = Driver::orderBy('pitrep', 'desc')->limit($limit)->get();

        // Compute the pitskill earners:
        // Measure the biggest increase in 'pitskill' Metric between today and one week ago
        $pitskillEarners = GetMetricEarners::execute('pitskill', $limit);
        $pitreplEarners  = GetMetricEarners::execute('pitrep', $limit);

        // Get the track of the last recorded hotlap
        $hotlapTrack = Hotlap::orderBy('created_at', 'desc')->first()->track;
        $subQuery    = Hotlap::select('driver_id', DB::raw('MIN(laptime) as best_laptime'))
            ->where('track_id', $hotlapTrack->id)
            ->groupBy('driver_id');

        $hotlaps = Hotlap::where('track_id', $hotlapTrack->id)
            ->whereIn(DB::raw('(driver_id, laptime)'), function ($query) use ($subQuery) {
                $query->select('driver_id', 'best_laptime')
                    ->from(DB::raw("({$subQuery->toSql()}) as sub"))
                    ->mergeBindings($subQuery->getQuery());
            })
            ->orderBy('laptime', 'asc')
            ->limit($limit)
            ->get();

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
