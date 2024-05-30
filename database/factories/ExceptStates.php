<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait ExceptStates
{
    protected array $excepts = [];

    public function raw($attributes = [], ?Model $parent = null): array
    {
        return Arr::except(parent::raw($attributes, $parent), $this->excepts);
    }
}
