<?php

declare(strict_types=1);

namespace App\Actions\Vacancy;

use App\Actions\Vacancy\Contracts\DeletesVacancies;
use App\Models\Vacancy;

final class DeleteVacancy implements DeletesVacancies
{
    public function delete(Vacancy $vacancy): bool
    {
        return (bool) $vacancy->delete();
    }
}
