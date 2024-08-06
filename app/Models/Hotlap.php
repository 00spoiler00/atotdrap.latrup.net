<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotlap extends BaseModel
{
    use HasFactory;

    // Define the date fields
    protected function casts(): array
    {
        return [
            'measured_at' => 'datetime',
        ];
    }

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

    // region Accessors

    public function getReadableLapTimeAttribute()
    {
        // Calculate minutes, seconds, and remaining milliseconds
        $minutes = floor($this->laptime / 60000);
        $seconds = floor(($this->laptime % 60000) / 1000);
        $milliseconds = $this->laptime % 1000;

        // Format each component to ensure proper zero-padding
        $minutesFormatted = str_pad($minutes, 2, "0", STR_PAD_LEFT);
        $secondsFormatted = str_pad($seconds, 2, "0", STR_PAD_LEFT);
        $millisecondsFormatted = str_pad($milliseconds, 3, "0", STR_PAD_RIGHT);

        // Combine the formatted components
        return "{$minutesFormatted}:{$secondsFormatted}.{$millisecondsFormatted}";        

    }
    
}
