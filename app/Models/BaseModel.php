<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    // Allow mass assignment except for the id field
    protected $guarded = ['id'];

    use HasFactory;
}
