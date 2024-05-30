<?php

declare(strict_types=1);

namespace App\Actions\Apprentice\Contracts;

interface CreatesApprentices
{
    public function create(array $inputs);
}
