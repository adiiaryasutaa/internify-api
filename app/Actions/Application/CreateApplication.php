<?php

declare(strict_types=1);

namespace App\Actions\Application;

use App\Actions\Application\Contracts\CreatesApplications;
use App\Actions\Application\Contracts\GeneratesApplicationsCodes;
use App\Models\Application;
use App\Models\Apprentice;
use App\Models\Vacancy;
use Illuminate\Support\Arr;

final class CreateApplication implements CreatesApplications
{
    private array $fills;

    public function __construct(
        Application $application,
        protected GenerateApplicationSlug $slugGenerator,
        protected GeneratesApplicationsCodes $codeGenerator,
    )
    {
        $this->fills = Arr::except($application->getFillable(), ['apprentice_id', 'vacancy_id']);
    }

    public function create(Apprentice $apprentice, Vacancy $vacancy, array $inputs): Application
    {
        $data = Arr::only($inputs, $this->fills);
        $data['code'] = $this->codeGenerator->generate();
        $data['slug'] = $this->slugGenerator->generate();
        $data['vacancy_id'] = $vacancy->id;

        return $apprentice->applications()->create($data);
    }
}
