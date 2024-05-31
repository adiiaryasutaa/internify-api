<?php

declare(strict_types=1);

namespace App\Actions\Company;

use App\Actions\Company\Contracts\GeneratesCompaniesCodes;

final class GenerateCompanyCode implements GeneratesCompaniesCodes
{
    public function generate(): string
    {
        return fake()->numerify('CO##########');
    }
}
