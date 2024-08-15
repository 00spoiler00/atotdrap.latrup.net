<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasFactory;
    // Allow mass assignment except for the id field
    protected $guarded = ['id'];

    // region Accessors

    public function getReadableIdAttribute(): string
    {
        return $this->name;
    }

    public function getShortReadableIdAttribute(): string
    {
        return $this->readableId;
    }
}
