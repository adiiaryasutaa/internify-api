<?php

declare(strict_types=1);

namespace App\Actions\Employer;

use App\Actions\Employer\Contracts\GeneratesEmployersCodes;

final class GenerateEmployerCode implements GeneratesEmployersCodes
{
    public function generate(): string
    {
        return fake()->numerify('EM##########');
    }
}
