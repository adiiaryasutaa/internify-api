<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Category\Contracts\GeneratesCategoriesCodes;
use App\Actions\Category\Contracts\GeneratesCategoriesSlugs;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Category> */
final class CategoryFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'code' => app(GeneratesCategoriesCodes::class)->generate(),
            'name' => $name = $this->faker->words(2, true),
            'slug' => app(GeneratesCategoriesSlugs::class)->generate($name),
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
