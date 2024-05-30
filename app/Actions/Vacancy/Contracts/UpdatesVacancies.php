<?php

declare(strict_types=1);

namespace App\Actions\Vacancy\Contracts;

use App\Models\Vacancy;

interface UpdatesVacancies
{
    public function update(Vacancy $vacancy, array $inputs);
}
