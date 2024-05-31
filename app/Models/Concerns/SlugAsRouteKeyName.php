<?php

namespace App\Models\Concerns;

trait SlugAsRouteKeyName
{
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
