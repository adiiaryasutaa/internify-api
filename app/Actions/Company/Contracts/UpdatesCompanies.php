<?php

declare(strict_types=1);

namespace App\Actions\Company\Contracts;

use App\Models\Company;

interface UpdatesCompanies
{
    public function update(Company $company, array $inputs);
}
