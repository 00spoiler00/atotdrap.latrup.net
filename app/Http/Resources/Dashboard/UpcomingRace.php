<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource as Resource;

class UpcomingRace extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $enrollments = $this->enrollments()->count();
        switch ($enrollments) {
            case 1:
                $color = 'blue';
                break;
            case 2:
                $color = 'orange';
                break;
            default:
                $color = 'red';
        }

        return [
            'id'       => $this->id,
            'platform' => $this->platform,
            'avatar'   => $this->track->avatar_url,
            'title'    => $this->name,
            'subtitle' => $this->starts_at->diffForHumans(),
            'value'    => [
                'color' => $color,
                'text'  => $enrollments . ' / ' . $this->registers,
            ],
        ];
    }
}
