<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use App\Models\Concerns\SlugAsRouteKeyName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class Apprentice extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;
    use SlugAsRouteKeyName;

    protected $with = [
        'user',
    ];

    protected $fillable = [
        'slug',
        'code',
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
