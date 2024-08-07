<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function hotlaps()
    {
        return $this->hasMany(Hotlap::class);
    }
}
