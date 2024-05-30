<?php

declare(strict_types=1);

namespace App\Actions\Company\Contracts;

use App\Models\Company;

interface DeletesCompanies
{
    public function delete(Company $company);
}
