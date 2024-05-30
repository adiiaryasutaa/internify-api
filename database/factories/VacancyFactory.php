<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Vacancy\GenerateVacancySlug;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Vacancy> */
final class VacancyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'deadline' => now()->addWeek()->toDateTimeString(),
            'location' => $this->faker->address(),
            'active' => true,
        ];
    }

    public function withSlug(): self
    {
        return $this->state(['slug' => app(GenerateVacancySlug::class)->generate()]);
    }
}
