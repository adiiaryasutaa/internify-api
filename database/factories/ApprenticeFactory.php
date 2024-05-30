<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Apprentice\Contracts\GeneratesApprenticesCodes;
use App\Actions\Apprentice\Contracts\GeneratesApprenticesSlugs;
use App\Models\Apprentice;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Apprentice> */
final class ApprenticeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'slug' => app(GeneratesApprenticesSlugs::class)->generate(),
            'code' => app(GeneratesApprenticesCodes::class)->generate(),
        ];
    }
}
