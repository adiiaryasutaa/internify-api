<?php

declare(strict_types=1);

namespace App\Actions\Vacancy;

use App\Actions\Vacancy\Contracts\CreatesVacancies;
use App\Actions\Vacancy\Contracts\GeneratesVacanciesCodes;
use App\Actions\Vacancy\Contracts\GeneratesVacanciesSlugs;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Support\Arr;

final class CreateVacancy implements CreatesVacancies
{
    private array $fill;

    public function __construct(
        Vacancy $vacancy,
        protected GeneratesVacanciesSlugs $slugGenerator,
        protected GeneratesVacanciesCodes $codesGenerator,
    )
    {
        $this->fill = array_diff($vacancy->getFillable(), ['code', 'slug', 'company_id', 'slug']);
    }

    public function create(Company $company, array $inputs): Vacancy
    {
        $data = Arr::only($inputs, $this->fill);
        $data['code'] = $this->codesGenerator->generate();
        $data['slug'] = $this->slugGenerator->generate();

        return $company->vacancies()->create($data);
    }
}
