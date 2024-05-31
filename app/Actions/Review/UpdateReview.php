<?php

declare(strict_types=1);

namespace App\Actions\Review;

use App\Actions\Review\Contracts\UpdatesReviews;
use App\Models\Review;
use Illuminate\Support\Arr;

final class UpdateReview implements UpdatesReviews
{
    private array $fills;

    public function __construct(Review $review)
    {
        $this->fills = array_diff($review->getFillable(), ['code', 'slug', 'apprentice_id', 'company_id']);
    }

    public function update(Review $review, array $inputs): bool
    {
        $data = Arr::only($inputs, $this->fills);

        return $review->update($data);
    }
}
