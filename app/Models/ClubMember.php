<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClubMember extends BaseModel
{
    use HasFactory;

    // region Relationships

    public function driver()
    {
        return $this->hasOne(Driver::class);
    }
}
