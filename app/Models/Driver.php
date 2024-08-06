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

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    
    public function hotlaps()
    {
        return $this->hasMany(Hotlap::class);
    }

    // region Accessors

    public function getReadableIdAttribute()
    {
        // Get the first name and the full last name and, trim and title case it
        return ucfirst(trim($this->first_name)) . ' ' . ucfirst($this->last_name);
    }

    public function getShortReadableIdAttribute()
    {
        // Get the first letter of the first name and the full last name and, trim and make each part title case
        return ucfirst(trim($this->first_name)[0]) . '.' . ucfirst($this->last_name);
    }
}
