<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function race()
    {
        return $this->belongsTo(Race::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
