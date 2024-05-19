<?php

namespace App\Models;

use App\Models\Concerns\CastTimestampsToDatetime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Admin extends Model
{
    use CastTimestampsToDatetime;
    use HasFactory;

    protected $with = [
        'user',
    ];

    protected $attributes = [
        'is_owner' => false,
    ];

    protected function casts(): array
    {
        return [
            'is_owner' => 'boolean',
        ];
    }

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'userable');
    }
}
