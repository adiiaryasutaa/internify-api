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
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ReviewController extends Controller
{
    public function index(Request $request): ReviewCollection
    {
        Gate::authorize('viewAny', Review::class);

        return ReviewCollection::make(Review::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesReviews $creator, StoreReviewRequest $request): JsonResponse
    {
        Gate::authorize('create', Review::class);

        $request = $request->validated();

        $apprentice = Apprentice::whereSlug(Arr::pull($request, 'apprentice'))->firstOrFail(['id', 'slug']);
        $company = Company::whereSlug(Arr::pull($request, 'company'))->firstOrFail(['id', 'slug']);

        $creator->create($apprentice, $company, $request);

        return response()->json([
            'message' => __('response.review.create.success'),
        ]);
    }

    public function show(Review $review): ReviewResource
    {
        Gate::authorize('view', $review);

        return ReviewResource::make($review);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesReviews $updater, UpdateReviewRequest $request, Review $review): JsonResponse
    {
        Gate::authorize('update', $review);

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
        Gate::authorize('delete', $review);

        throw_unless($deleter->delete($review));

        return response()->json([
            'message' => __('response.review.delete.success'),
        ]);
    }
}
