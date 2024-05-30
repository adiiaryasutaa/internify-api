<?php

declare(strict_types=1);

namespace App\Actions\Review\Contracts;

use App\Models\Review;

interface DeletesReviews
{
    public function delete(Review $review);
}
