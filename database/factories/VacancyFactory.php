<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Vacancy\Contracts\GeneratesVacanciesCodes;
use App\Actions\Vacancy\Contracts\GeneratesVacanciesSlugs;
use App\Models\Vacancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Vacancy> */
final class VacancyFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'code' => app(GeneratesVacanciesCodes::class)->generate(),
            'slug' => app(GeneratesVacanciesSlugs::class)->generate(),
            'title' => $this->faker->jobTitle(),
            'description' => $this->faker->text(),
            'deadline' => now()->addWeek()->toDateTimeString(),
            'location' => $this->faker->address(),
            'active' => true,
        ];
    }

    public function withoutCode(): self
    {
        $this->excepts[] = 'code';

        return $this;
    }

    public function withoutSlug(): self
    {
        $this->excepts[] = 'slug';

        return $this;
    }
}
