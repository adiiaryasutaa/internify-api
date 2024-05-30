<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Employer\Contracts\GeneratesEmployersCodes;
use App\Actions\Employer\Contracts\GeneratesEmployersSlugs;
use App\Models\Employer;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Employer> */
final class EmployerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => app(GeneratesEmployersSlugs::class)->generate(),
            'code' => app(GeneratesEmployersCodes::class)->generate(),
        ];
    }
}