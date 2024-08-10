<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Metric extends BaseModel
{
    use HasFactory;
    public $timestamps = false;

    // region Relationships

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    // Define the date fields
    protected function casts(): array
    {
        return [
            'measured_at' => 'datetime',
        ];
    }
}
