<?php

declare(strict_types=1);

namespace App\Actions\Employer\Contracts;

use App\Models\Employer;

interface UpdatesEmployers
{
    public function update(Employer $employer, array $inputs);
}
