<?php

declare(strict_types=1);

namespace App\Actions\Vacancy\Contracts;

interface GeneratesVacanciesSlugs
{
    public function generate(): string;
}
