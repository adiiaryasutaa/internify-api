<?php

declare(strict_types=1);

namespace App\Actions\Vacancy;

use App\Actions\Vacancy\Contracts\GeneratesVacanciesCodes;

final class GenerateVacancyCode implements GeneratesVacanciesCodes
{
    public function generate(): string
    {
        return fake()->numerify('VA##########');
    }
}
