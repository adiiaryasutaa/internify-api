<?php

namespace App\Actions\Review;

use App\Actions\Review\Contracts\GeneratesReviewsCodes;

class GenerateReviewCode implements GeneratesReviewsCodes
{
	public function generate(): string
    {
        return fake()->numerify('RE##########');
	}
}
