<?php

declare(strict_types=1);

namespace App\Actions\Apprentice;

use App\Actions\Apprentice\Contracts\GeneratesApprenticesCodes;

final class GenerateApprenticeCode implements GeneratesApprenticesCodes
{
    public function generate(): string
    {
        return fake()->numerify('AP##########');
    }
}
