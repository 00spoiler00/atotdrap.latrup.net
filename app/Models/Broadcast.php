<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Broadcast extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
