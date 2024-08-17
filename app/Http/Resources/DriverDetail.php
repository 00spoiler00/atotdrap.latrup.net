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
                'enrollments'    => $this->enrollments()->count(),
                'pitskill'       => $this->pitskill,
                'pitrep'         => $this->pitrep,
                'pitskill_graph' => $this->metrics()->where('type', 'pitskill')->orderBy('measured_at')->get(['measured_at', 'value']),
                'pitrep_graph'   => $this->metrics()->where('type', 'pitrep')->orderBy('measured_at')->get(['measured_at', 'value']),
            ],
            'lfm' => [
                'id'          => $this->clubMember->lfm_id,
                'ranking'     => '?',
                'enrollments' => 0,
                'elo'         => 0,
                'sr'          => 0,
                'elo_graph'   => [],
                'sr_graph'    => [],
            ],
            'hotlaps_count' => $this->hotlaps()->count(),
            'hotlaps'       => HotlapList::collection(Hotlap::whereIn('id', $bestHotlapIds)->get()),
        ];
    }
}
