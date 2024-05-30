<?php

declare(strict_types=1);

namespace App\Actions\Vacancy\Contracts;

use App\Models\Vacancy;

interface DeletesVacancies
{
    public function delete(Vacancy $vacancy);
}
