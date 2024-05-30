<?php

declare(strict_types=1);

namespace App\Actions\Review;

use App\Actions\Review\Contracts\DeletesReviews;
use App\Models\Review;

final class DeleteReview implements DeletesReviews
{
    public function delete(Review $review): bool
    {
        return $review->delete();
    }
}
