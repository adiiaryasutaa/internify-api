<?php

namespace App\Actions\Apprentice;

use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Models\Apprentice;

class CreateApprentice implements CreatesApprentices
{
    public function create(array $inputs): Apprentice
    {
        return Apprentice::create($inputs);
    }
}
