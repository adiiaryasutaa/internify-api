<?php

namespace App\Actions\Employer;

use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Models\Employer;

class CreateEmployer implements CreatesEmployers
{
    public function create(array $inputs): Employer
    {
        return Employer::create($inputs);
    }
}
