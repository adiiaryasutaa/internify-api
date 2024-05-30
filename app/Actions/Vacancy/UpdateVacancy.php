<?php

declare(strict_types=1);

namespace App\Actions\Vacancy;

use App\Actions\Vacancy\Contracts\UpdatesVacancies;
use App\Models\Vacancy;
use Illuminate\Support\Arr;

final class UpdateVacancy implements UpdatesVacancies
{
    private array $fill = [];

    public function __construct(Vacancy $vacancy)
    {
        $this->fill = Arr::except($vacancy->getFillable(), ['company_id']);
    }

    public function update(Vacancy $vacancy, array $inputs): bool
    {
        $data = Arr::only($inputs, $this->fill);

        return $vacancy->update($data);
    }
}
