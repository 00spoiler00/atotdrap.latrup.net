<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function clubMember()
    {
        return $this->belongsTo(ClubMember::class);
    }

    public function metrics()
    {
        return $this->hasMany(Metric::class);
    }
}
