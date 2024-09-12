<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubMember extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }

    // region Scopes

    public function scopeWithAnEnrollmentBeforeDate($q, Carbon $referenceDate)
    {
        // The clubMember must have a driver that has an enrollment on the last week
        return $q->whereHas(
            'driver',
            fn ($q) => $q->whereHas(
                'enrollments',
                fn ($q) => $q->where('created_at', '>=', $referenceDate)
            )
        );
    }
}
