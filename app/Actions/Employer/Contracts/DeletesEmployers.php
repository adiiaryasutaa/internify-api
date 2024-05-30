<?php

declare(strict_types=1);

namespace App\Actions\Employer\Contracts;

use App\Models\Employer;

interface DeletesEmployers
{
    public function delete(Employer $employer);
}
