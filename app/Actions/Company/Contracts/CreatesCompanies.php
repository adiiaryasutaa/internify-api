<?php

declare(strict_types=1);

namespace App\Actions\Company\Contracts;

use App\Models\Employer;

interface CreatesCompanies
{
    public function create(Employer $employer, array $inputs);
}
