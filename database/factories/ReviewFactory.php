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
    public function definition(): array
    {
        return [
            'code' => app(GeneratesReviewsCodes::class)->generate(),
            'slug' => app(GeneratesReviewsSlugs::class)->generate(),
            'summary' => $this->faker->text(30),
            'description' => $this->faker->paragraphs(5, true),
        ];
    }

    public function withSlug(): self
    {
        return $this->state(['slug' => app(GeneratesReviewsSlugs::class)->generate()]);
    }
}
