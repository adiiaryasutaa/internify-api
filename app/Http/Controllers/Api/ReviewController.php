<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Review\Contracts\CreatesReviews;
use App\Actions\Review\Contracts\DeletesReviews;
use App\Actions\Review\Contracts\UpdatesReviews;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReviewRequest;
use App\Http\Requests\Api\UpdateReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class ReviewController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Review::class, 'review');
    }

    public function index(Request $request): ReviewCollection
    {
        return ReviewCollection::make(Review::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesReviews $creator, StoreReviewRequest $request): JsonResponse
    {
        $request = $request->validated();

        $apprentice = Apprentice::whereCode($request['apprentice'])->firstOrFail(['id', 'slug']);
        $company = Company::whereCode($request['company'])->firstOrFail(['id', 'slug']);

        $creator->create($apprentice, $company, $request);

        return response()->json([
            'message' => __('response.review.create.success'),
        ]);
    }

    public function show(Review $review): ReviewResource
    {
        return ReviewResource::make($review);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesReviews $updater, UpdateReviewRequest $request, Review $review): JsonResponse
    {
        throw_unless($updater->update($review, $request->validated()));

        return response()->json([
            'message' => __('response.review.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesReviews $deleter, Review $review): JsonResponse
    {
        throw_unless($deleter->delete($review));

        return response()->json([
            'message' => __('response.review.delete.success'),
        ]);
    }
}
