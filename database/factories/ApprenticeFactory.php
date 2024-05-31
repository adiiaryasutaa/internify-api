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
    use ExceptStates;

    public function definition(): array
    {
        return [
            'slug' => app(GeneratesApprenticesSlugs::class)->generate(),
            'code' => app(GeneratesApprenticesCodes::class)->generate(),
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
