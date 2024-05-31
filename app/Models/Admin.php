<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use App\Models\Concerns\SlugAsRouteKeyName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class Admin extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;
    use SlugAsRouteKeyName;

    protected $fillable = [
        'slug',
        'code',
    ];

    protected $with = [
        'user',
    ];

    protected $attributes = [
        'is_owner' => false,
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }

    protected function casts(): array
    {
        return [
            'is_owner' => 'boolean',
        ];
    }
}
