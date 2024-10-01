<?php

namespace App\Http\Resources\Dashboard;

use App\Actions\GetMetricEarners;
use App\Actions\HotlapMedals;
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

        $upcomingRaces = Race::where('starts_at', '>', now()->subHours(1))->orderBy('starts_at', 'asc')->limit($limit)->get();

        $pitskillLeaders = Driver::where('pitskill', '>', 0)->orderBy('pitskill', 'desc')->limit($limit)->get();
        $pitrepLeaders   = Driver::where('pitrep', '>', 0)->orderBy('pitrep', 'desc')->limit($limit)->get();
        $pitskillEarners = GetMetricEarners::execute('pitskill', $limit);
        $pitreplEarners  = GetMetricEarners::execute('pitrep', $limit);

        $eloLeaders = Driver::where('elo', '>', 0)->orderBy('elo', 'desc')->limit($limit)->get();
        $srLeaders  = Driver::where('sr', '>', 0)->orderBy('sr', 'desc')->limit($limit)->get();
        $eloEarners = GetMetricEarners::execute('elo', $limit);
        $srEarners  = GetMetricEarners::execute('sr', $limit);

        $rratingLeaders     = Driver::where('raceroom_rating', '>', 0)->orderBy('raceroom_rating', 'desc')->limit($limit)->get();
        $rreputaionLeaders  = Driver::where('raceroom_reputation', '>', 0)->orderBy('raceroom_reputation', 'desc')->limit($limit)->get();
        $rratingEarners     = GetMetricEarners::execute('raceroom_rating', $limit);
        $rreputationEarners = GetMetricEarners::execute('raceroom_reputation', $limit);

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
                'title'       => "Hotlaps @ {$hotlapTrack->readableId}: " . collect(HotlapMedals::trackMedals($hotlapTrack, true))->values()->join(' - '),
                'targetModel' => 'Driver',
                'data'        => HotlapRanking::collection($hotlaps),
            ],
            'pitskill' => [
                'pitskill' => [
                    'earners' => [
                        'title'       => 'PitSkill earners (7d)',
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
                        'title'       => 'PitRep earners (7d)',
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
                        'title'       => 'ELO earners (7d)',
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
                        'title'       => 'SR earners (7d)',
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
            'raceroom' => [
                'rating' => [
                    'earners' => [
                        'title'       => 'Rating earners (7d)',
                        'targetModel' => 'Driver',
                        'data'        => RRatingEarner::collection($rratingEarners),
                    ],
                    'ranking' => [
                        'title'       => 'Reputation ranking',
                        'targetModel' => 'Driver',
                        'data'        => RRatingRanking::collection($rratingLeaders),
                    ],
                ],
                'reputation' => [
                    'earners' => [
                        'title'       => 'Rating earners (7d)',
                        'targetModel' => 'Driver',
                        'data'        => RRatingEarner::collection($rreputationEarners),
                    ],
                    'ranking' => [
                        'title'       => 'Reputation ranking',
                        'targetModel' => 'Driver',
                        'data'        => RReputationRanking::collection($rreputaionLeaders),
                    ],
                ],
            ],

        ];
    }
}
