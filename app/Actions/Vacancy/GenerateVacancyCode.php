<?php

namespace App\Actions\Vacancy;

use App\Actions\Vacancy\Contracts\GeneratesVacanciesCodes;

class GenerateVacancyCode implements GeneratesVacanciesCodes
{
	public function generate(): string
	{
        return fake()->numerify('VA##########');
	}
}
