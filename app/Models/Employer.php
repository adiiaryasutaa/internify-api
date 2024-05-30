<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class Employer extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;

    protected $with = ['user'];

    protected $fillable = [
        'slug',
        'code',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class);
    }
}
