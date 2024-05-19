<?php

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;
}
