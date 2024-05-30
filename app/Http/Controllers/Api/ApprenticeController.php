<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Apprentice\Contracts\CreatesApprentices;
use App\Actions\Apprentice\Contracts\DeletesApprentices;
use App\Actions\Apprentice\Contracts\UpdatesApprentices;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreApprenticeRequest;
use App\Http\Requests\Api\UpdateApprenticeRequest;
use App\Http\Resources\ApprenticeCollection;
use App\Http\Resources\ApprenticeResource;
use App\Models\Apprentice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ApprenticeController extends Controller
{
    public function index(Request $request): ApprenticeCollection
    {
        Gate::authorize('viewAny', Apprentice::class);

        return ApprenticeCollection::make(Apprentice::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesApprentices $creator, StoreApprenticeRequest $request): JsonResponse
    {
        Gate::authorize('create', Apprentice::class);

        $creator->create($request->validated());

        return response()->json([
            'message' => __('response.apprentice.create.success'),
        ]);
    }

    public function show(Apprentice $apprentice): ApprenticeResource
    {
        Gate::authorize('view', $apprentice);

        return ApprenticeResource::make($apprentice);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesApprentices $updater, UpdateApprenticeRequest $request, Apprentice $apprentice): JsonResponse
    {
        Gate::authorize('update', $apprentice);

        throw_unless($updater->update($apprentice, $request->validated()));

        return response()->json([
            'message' => __('response.apprentice.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesApprentices $deleter, Apprentice $apprentice): JsonResponse
    {
        Gate::authorize('delete', $apprentice);

        throw_unless($deleter->delete($apprentice));

        return response()->json([
            'message' => __('response.apprentice.delete.success'),
        ]);
    }
}
