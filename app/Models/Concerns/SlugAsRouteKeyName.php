<?php

declare(strict_types=1);

namespace App\Models\Concerns;

trait SlugAsRouteKeyName
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
