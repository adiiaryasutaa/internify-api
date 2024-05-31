<?php

namespace App\Actions\Application;

use App\Actions\Application\Contracts\GeneratesApplicationsCodes;

class GenerateApplicationCode implements GeneratesApplicationsCodes
{
	public function generate(): string
    {
        return fake()->numerify('AC##########');
	}
}
