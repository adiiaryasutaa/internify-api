<?php

declare(strict_types=1);

namespace App\Actions\Vacancy\Contracts;

use App\Models\Company;

interface CreatesVacancies
{
    public function create(Company $company, array $inputs);
}
