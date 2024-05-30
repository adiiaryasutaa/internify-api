<?php

declare(strict_types=1);

namespace App\Actions\Review;

use App\Actions\Review\Contracts\GeneratesReviewsSlugs;
use Illuminate\Support\Str;

final class GenerateReviewSlug implements GeneratesReviewsSlugs
{
    public function generate(): string
    {
        return str(Str::random())->prepend('review ')->lower()->slug()->toString();
    }
}
