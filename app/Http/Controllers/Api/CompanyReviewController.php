<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Review\Contracts\CreatesReviews;
use App\Actions\Review\Contracts\DeletesReviews;
use App\Actions\Review\Contracts\UpdatesReviews;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\StoreReviewRequest;
use App\Http\Requests\Api\Vacancy\UpdateReviewRequest;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Models\Company;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class CompanyReviewController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Review::class, ['review', 'company']);
    }

    /**
     * Display a listing of the company reviews.
     *
     * @param Request $request
     * @param Company $company
     * @return ReviewCollection
     */
    public function index(Request $request, Company $company): ReviewCollection
    {
        $perPage = $request->integer('per-page', null);

        $reviews = $company->reviews()->paginate($perPage);

        return ReviewCollection::make($reviews);
    }

    /**
     * Store a newly created company review in storage.
     *
     * @param CreatesReviews $creator
     * @param StoreReviewRequest $request
     * @param Company $company
     * @return JsonResponse
     */
    public function store(CreatesReviews $creator, StoreReviewRequest $request, Company $company): JsonResponse
    {
        $data = $request->validated();

        $apprentice = $request->user()->userable;

        $creator->create($apprentice, $company, $data);

        return response()->json([
            'message' => __('response.review.create.success'),
        ]);
    }

    /**
     * Display the specified company review.
     *
     * @param Company $company
     * @param Review $review
     * @return ReviewResource
     */
    public function show(Company $company, Review $review): ReviewResource
    {
        return ReviewResource::make($review);
    }

    /**
     * Update the specified company review in storage.
     *
     * @param UpdatesReviews $updater
     * @param UpdateReviewRequest $request
     * @param Company $company
     * @param Review $review
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdatesReviews $updater, UpdateReviewRequest $request, Company $company, Review $review): JsonResponse
    {
        throw_unless($updater->update($review, $request->validated()));

        return response()->json([
            'message' => __('response.review.update.success'),
        ]);
    }

    /**
     * Remove the specified company review from storage.
     *
     * @param DeletesReviews $deleter
     * @param Company $company
     * @param Review $review
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(DeletesReviews $deleter, Company $company, Review $review): JsonResponse
    {
        throw_unless($deleter->delete($review));

        return response()->json([
            'message' => __('response.review.delete.success'),
        ]);
    }
}
