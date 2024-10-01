<?php

namespace App\Http\Resources;

use App\Models\Driver;
use App\Models\Hotlap;
use Illuminate\Http\Request;
// use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource as Resource;
use Illuminate\Support\Facades\DB;

class DriverDetail extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Create the records for the driver, based on the best hotlap on each track
        $bestHotlapsSubquery = DB::table('hotlaps')
            ->select('track_id', DB::raw('MIN(laptime) as best_laptime'))
            ->where('driver_id', $this->id)
            ->groupBy('track_id');

        $bestHotlapIds = DB::table('hotlaps')
            ->joinSub($bestHotlapsSubquery, 'best_laps', function ($join) {
                $join->on('hotlaps.track_id', '=', 'best_laps.track_id')
                    ->on('hotlaps.laptime', '=', 'best_laps.best_laptime');
            })
            ->where('hotlaps.driver_id', $this->id)
            ->pluck('id');

        return [
            'id'         => $this->id,
            'name'       => $this->shortReadableId,
            'avatar'     => $this->avatar_url,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'nickname'   => $this->nickname,
            'pitskill'   => [
                'id'             => $this->clubMember->pitskill_id,
                'ranking'        => Driver::where('pitskill', '>', $this->pitskill)->count() + 1,
                'enrollments'    => $this->enrollments()->whereHas('race', fn ($q) => $q->where('platform', 'pitskill'))->count(),
                'pitskill'       => $this->pitskill,
                'pitrep'         => $this->pitrep,
                'pitskill_graph' => $this->metrics()->where('type', 'pitskill')->orderBy('measured_at')->get(['measured_at', 'value']),
                'pitrep_graph'   => $this->metrics()->where('type', 'pitrep')->orderBy('measured_at')->get(['measured_at', 'value']),
            ],
            'lfm' => [
                'id'          => $this->clubMember->lfm_id,
                'ranking'     => Driver::where('elo', '>', $this->elo)->count() + 1,
                'enrollments' => $this->enrollments()->whereHas('race', fn ($q) => $q->where('platform', 'lfm'))->count(),
                'elo'         => $this->elo,
                'sr'          => $this->sr,
                'elo_graph'   => $this->metrics()->where('type', 'elo')->orderBy('measured_at')->get(['measured_at', 'value']),
                'sr_graph'    => $this->metrics()->where('type', 'sr')->orderBy('measured_at')->get(['measured_at', 'value']),
            ],
            'raceroom' => [
                'id'               => $this->clubMember->raceroom_id,
                'ranking'          => Driver::where('raceroom_rating', '>', $this->raceroom_rating)->count() + 1,
                'elo'              => $this->raceroom_rating,
                'sr'               => $this->raceroom_reputation,
                'rating_graph'     => $this->metrics()->where('type', 'raceroom_rating')->orderBy('measured_at')->get(['measured_at', 'value']),
                'reputation_graph' => $this->metrics()->where('type', 'raceroom_reputation')->orderBy('measured_at')->get(['measured_at', 'value']),
            ],
            'hotlaps_count' => $this->hotlaps()->count(),
            'hotlaps'       => HotlapList::collection(Hotlap::whereIn('id', $bestHotlapIds)->get()),
        ];
    }
}
