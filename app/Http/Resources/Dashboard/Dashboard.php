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

        $upcomingRaces = Race::where('starts_at', '>', now())->limit($limit)->get();

        $pitskillLeaders = Driver::orderBy('pitskill', 'desc')->limit($limit)->get();
        $pitrepLeaders   = Driver::orderBy('pitrep', 'desc')->limit($limit)->get();
        $pitskillEarners = GetMetricEarners::execute('pitskill', $limit);
        $pitreplEarners  = GetMetricEarners::execute('pitrep', $limit);

        $eloLeaders = Driver::orderBy('elo', 'desc')->limit($limit)->get();
        $srLeaders  = Driver::orderBy('sr', 'desc')->limit($limit)->get();
        $eloEarners = GetMetricEarners::execute('elo', $limit);
        $srEarners  = GetMetricEarners::execute('sr', $limit);

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
            'races' => [
                'title'       => 'Properes curses',
                'targetModel' => 'Race',
                'data'        => UpcomingRace::collection($upcomingRaces),
            ],
            'hotlaps' => [
                'title'       => 'Hotlaps ' . $hotlapTrack->readableId,
                'targetModel' => 'Driver',
                'data'        => HotlapRanking::collection($hotlaps),
            ],
            'pitskill' => [
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

            ],
            'lfm' => [
                'elo' => [
                    'earners' => [
                        'title'       => 'Pujades ELO',
                        'targetModel' => 'Driver',
                        'data'        => EloEarner::collection($eloEarners),
                    ],
                    'ranking' => [
                        'title'       => 'ELO ranking',
                        'targetModel' => 'Driver',
                        'data'        => EloRanking::collection($eloLeaders),
                    ],
                ],
                'sr' => [
                    'earners' => [
                        'title'       => 'Pujades SR',
                        'targetModel' => 'Driver',
                        'data'        => SrEarner::collection($srEarners),
                    ],
                    'ranking' => [
                        'title'       => 'SR ranking',
                        'targetModel' => 'Driver',
                        'data'        => SrRanking::collection($srLeaders),
                    ],
                ],
            ],
        ];
    }
}
