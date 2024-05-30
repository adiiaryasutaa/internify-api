<?php

declare(strict_types=1);

namespace App\Actions\Review\Contracts;

use App\Models\Apprentice;
use App\Models\Company;

interface CreatesReviews
{
    public function create(Apprentice $apprentice, Company $company, array $inputs);
}
