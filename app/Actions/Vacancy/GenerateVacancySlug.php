<?php

declare(strict_types=1);

namespace App\Actions\Vacancy;

use App\Actions\Vacancy\Contracts\GeneratesVacanciesSlugs;
use Illuminate\Support\Str;

final class GenerateVacancySlug implements GeneratesVacanciesSlugs
{
    public function generate(): string
    {
        return str(Str::random())->lower()->slug()->toString();
    }
}
