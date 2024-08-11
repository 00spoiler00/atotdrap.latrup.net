<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Race extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function track()
    {
        return $this->belongsTo(Track::class);
    }

    public function broadcasts()
    {
        return $this->hasMany(Broadcast::class);
    }

    // region Accessors

    public function getEnrollLinkAttribute()
    {
        return "https://pitskill.io/event/{$this->event_id}";
    }

    // Define the date fields
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
        ];
    }
}
