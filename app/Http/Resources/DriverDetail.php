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
            'id'                   => $this->id,
            'name'                 => $this->shortReadableId,
            'avatar'               => $this->avatar_url,
            'first_name'           => $this->first_name,
            'last_name'            => $this->last_name,
            'nickname'             => $this->nickname,
            'pitskill_id'          => $this->clubMember->pitskill_id,
            'pitskill_ranking'     => Driver::where('pitskill', '>', $this->pitskill)->count() + 1,
            'pitskill'             => $this->pitskill,
            'pitrep'               => $this->pitrep,
            'pitskill_enrollments' => $this->enrollments()->count(),
            'pitskill_graph'       => $this->metrics()->where('type', 'pitskill')->orderBy('measured_at')->get(['measured_at', 'value']),
            'pitrep_graph'         => $this->metrics()->where('type', 'pitrep')->orderBy('measured_at')->get(['measured_at', 'value']),
            'lfm_id'               => $this->clubMember->lfm_id,
            'elo'                  => $this->elo,
            'sr'                   => $this->sr,
            'hotlaps_count'        => $this->hotlaps()->count(),
            'hotlaps'              => HotlapList::collection(Hotlap::whereIn('id', $bestHotlapIds)->get()),
        ];
    }
}
