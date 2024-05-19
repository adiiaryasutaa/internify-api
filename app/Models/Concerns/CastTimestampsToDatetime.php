<?php

namespace App\Models\Concerns;

trait CastTimestampsToDatetime
{
    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }
}
