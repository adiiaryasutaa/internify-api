<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Application\Contracts\CreatesApplications;
use App\Actions\Application\Contracts\DeletesApplications;
use App\Actions\Application\Contracts\UpdatesApplications;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreApplicationRequest;
use App\Http\Requests\Api\UpdateApplicationRequest;
use App\Http\Resources\ApplicationCollection;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Apprentice;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class ApplicationController extends Controller
{
    public function index(Request $request): ApplicationCollection
    {
        Gate::authorize('viewAny', Application::class);

        return ApplicationCollection::make(Application::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesApplications $creator, StoreApplicationRequest $request): JsonResponse
    {
        Gate::authorize('create', Application::class);

        $request = $request->validated();

        $apprentice = Apprentice::whereSlug(Arr::pull($request, 'apprentice'))->firstOrFail(['id', 'slug']);
        $vacancy = Vacancy::whereSlug(Arr::pull($request, 'vacancy'))->firstOrFail(['id', 'slug']);

        $creator->create($apprentice, $vacancy, $request);

        return response()->json([
            'message' => __('response.application.create.success'),
        ]);
    }

    public function show(Application $application): ApplicationResource
    {
        Gate::authorize('view', $application);

        return ApplicationResource::make($application);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesApplications $updater, UpdateApplicationRequest $request, Application $application): JsonResponse
    {
        Gate::authorize('update', $application);

        throw_unless($updater->update($application, $request->validated()));

        return response()->json([
            'message' => __('response.application.update.success'),
        ]);

    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesApplications $deleter, Application $application): JsonResponse
    {
        Gate::authorize('delete', $application);

        throw_unless($deleter->delete($application));

        return response()->json([
            'message' => __('response.application.delete.success'),
        ]);
    }
}
