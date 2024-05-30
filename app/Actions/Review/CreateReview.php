<?php

declare(strict_types=1);

namespace App\Actions\Review;

use App\Actions\Review\Contracts\CreatesReviews;
use App\Actions\Review\Contracts\GeneratesReviewsSlugs;
use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Review;
use Illuminate\Support\Arr;

final class CreateReview implements CreatesReviews
{
    private array $fills;

    public function __construct(Review $review, protected GeneratesReviewsSlugs $slugGenerate)
    {
        $this->fills = Arr::except($review->getFillable(), ['apprentice_id', 'company_id']);
    }

    public function create(Apprentice $apprentice, Company $company, array $inputs): Review
    {
        $data = Arr::only($inputs, $this->fills);
        $data['slug'] = $this->slugGenerate->generate();
        $data['company_id'] = $company->id;

        return $apprentice->reviews()->create($data);
    }
}
