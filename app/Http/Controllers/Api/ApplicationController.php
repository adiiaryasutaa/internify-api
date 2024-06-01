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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Application::class, 'application');
    }

    public function index(Request $request): ApplicationCollection
    {
        $perPage = $request->integer('per-page', null);

        $user = $request->user();

        $applications = Application::query()
            ->when($user->role->isEmployer(), function (Builder $query) use ($user): void {
                $company = $user->loadMissing('userable.company')->userable->company;

                $query->whereRelation('vacancy.company', 'id', $company->id);
            })
            ->when($user->role->isApprentice(), fn(Builder $query) => $query->whereApprenticeId($user->userable->id))
            ->latest()
            ->paginate($perPage);

        return ApplicationCollection::make($applications);
    }

    public function store(CreatesApplications $creator, StoreApplicationRequest $request): JsonResponse
    {
        $user = $request->user();
        $request = $request->validated();

        if ($user->role->isAdmin()) {
            $apprentice = Apprentice::whereCode($request['apprentice'])->firstOrFail(['id', 'slug']);
        } else {
            $apprentice = $user->userable;
        }

        $vacancy = Vacancy::whereCode($request['vacancy'])->firstOrFail(['id', 'slug']);

        $creator->create($apprentice, $vacancy, $request);

        return response()->json([
            'message' => __('response.application.create.success'),
        ]);
    }

    public function show(Application $application): ApplicationResource
    {
        return ApplicationResource::make($application);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesApplications $updater, UpdateApplicationRequest $request, Application $application): JsonResponse
    {
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
        throw_unless($deleter->delete($application));

        return response()->json([
            'message' => __('response.application.delete.success'),
        ]);
    }
}
