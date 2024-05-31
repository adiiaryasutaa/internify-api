<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Review\Contracts\GeneratesReviewsCodes;
use App\Actions\Review\Contracts\GeneratesReviewsSlugs;
use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Review> */
final class ReviewFactory extends Factory
{
    use ExceptStates;

    public function definition(): array
    {
        return [
            'code' => app(GeneratesReviewsCodes::class)->generate(),
            'slug' => app(GeneratesReviewsSlugs::class)->generate(),
            'summary' => $this->faker->text(30),
            'description' => $this->faker->paragraphs(5, true),
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
