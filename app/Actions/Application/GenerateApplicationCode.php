<?php

declare(strict_types=1);

namespace App\Actions\Application;

use App\Actions\Application\Contracts\GeneratesApplicationsCodes;

final class GenerateApplicationCode implements GeneratesApplicationsCodes
{
    public function generate(): string
    {
        return fake()->numerify('AC##########');
    }
}
