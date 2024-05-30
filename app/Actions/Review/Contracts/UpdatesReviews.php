<?php

declare(strict_types=1);

namespace App\Actions\Review\Contracts;

use App\Models\Review;

interface UpdatesReviews
{
    public function update(Review $review, array $inputs);
}
