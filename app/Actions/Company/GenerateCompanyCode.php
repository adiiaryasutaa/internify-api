<?php

namespace App\Actions\Company;

use App\Actions\Company\Contracts\GeneratesCompaniesCodes;

class GenerateCompanyCode implements GeneratesCompaniesCodes
{
	public function generate(): string
	{
        return fake()->numerify('CO##########');
	}
}
