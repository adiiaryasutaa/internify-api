<?php

declare(strict_types=1);

namespace App\Actions\Application\Contracts;

use App\Models\Apprentice;
use App\Models\Vacancy;

interface CreatesApplications
{
    public function create(Apprentice $apprentice, Vacancy $vacancy, array $inputs);
}
