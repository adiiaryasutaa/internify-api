<?php

declare(strict_types=1);

namespace App\Actions\Employer\Contracts;

interface CreatesEmployers
{
    public function create(array $inputs);
}
