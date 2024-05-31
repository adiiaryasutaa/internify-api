<?php

declare(strict_types=1);

namespace App\Actions\Review;

use App\Actions\Review\Contracts\GeneratesReviewsCodes;

final class GenerateReviewCode implements GeneratesReviewsCodes
{
    public function generate(): string
    {
        return fake()->numerify('RE##########');
    }
}
