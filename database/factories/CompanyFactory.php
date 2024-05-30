<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Company\Contracts\GeneratesCompaniesSlugs;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Company> */
final class CompanyFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'name' => $name = $this->faker->company(),
            'slug' => app(GeneratesCompaniesSlugs::class)->generate($name),
            'description' => $this->faker->realText(),
            'phone' => $this->faker->numerify('0###########'),
            'address' => $this->faker->address(),
            'link' => $this->faker->url(),
        ];
    }

    /** @deprecated */
    public function withSlug(): self
    {
        return $this->state(fn(array $attributes): array => ['slug' => app(GeneratesCompaniesSlugs::class)->generate()]);
    }

    public function withoutSlug(): self
    {
        $this->excepts[] = 'slug';

        return $this;
    }
}
