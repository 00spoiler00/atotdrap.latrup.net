<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Track extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function hotlaps()
    {
        return $this->hasMany(Hotlap::class);
    }

    public function races()
    {
        return $this->hasMany(Race::class);
    }

    // region Accessors

    public function getAvatarUrlAttribute(): string
    {
        return $this->platform == 'pitskill'
            ? 'https://cdn.pitskill.io/public/TrackPhoto-' . $this->thumbnail
            : 'https://lowfuelmotorsport.com/assets/img/tracks/' . $this->thumbnail;
    }
}
