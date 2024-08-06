<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotlap extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    
}
