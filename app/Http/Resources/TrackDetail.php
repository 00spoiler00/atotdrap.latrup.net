<?php

namespace App\Http\Resources;

use App\Actions\HotlapMedals;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class TrackDetail extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'track_year'  => $this->track_year,
            'ingame_id'   => $this->ingame_id,
            'country'     => $this->country,
            'corners'     => $this->corners,
            'length'      => $this->length,
            'difficulty'  => $this->difficulty,
            'city'        => $this->city,
            'max_entries' => $this->max_entries,
            'avatar'      => $this->avatar_url,
            'track_guide' => $this->track_guide,
            'hotlaps'     => HotlapList::collection($this->hotlaps()->orderBy('laptime')->limit(10)->get()),
            'medals'      => HotlapMedals::trackMedals($this->resource, true),
        ];
    }
}
