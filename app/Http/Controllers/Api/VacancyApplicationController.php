<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Application\Contracts\CreatesApplications;
use App\Actions\Application\Contracts\DeletesApplications;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreApplicationRequest;
use App\Http\Resources\ApplicationCollection;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Apprentice;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class VacancyApplicationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource([Application::class, 'vacancy'], ['application', 'vacancy']);
    }

    /**
     * Display a listing of the vacancy applications.
     *
     * @param Request $request
     * @param Vacancy $vacancy
     * @return ApplicationCollection
     */
    public function index(Request $request, Vacancy $vacancy): ApplicationCollection
    {
        $perPage = $request->integer('per-page', null);

        $applications = $vacancy->applications()->paginate($perPage);

        return ApplicationCollection::make($applications);
    }

    /**
     *
     *
     * @param CreatesApplications $creator
     * @param StoreApplicationRequest $request
     * @param Vacancy $vacancy
     * @return JsonResponse
     */
    public function store(CreatesApplications $creator, StoreApplicationRequest $request, Vacancy $vacancy): JsonResponse
    {
        $user = $request->user();
        $request = $request->validated();

        $apprentice = match ($user->role) {
            Role::ADMIN => Apprentice::whereCode($request['apprentice'])->firstOrFail(['id', 'slug']),
            Role::APPRENTICE => $user->userable,
        };

        $creator->create($apprentice, $vacancy, $request);

        return response()->json([
            'message' => __('response.application.create.success'),
        ]);
    }

    /**
     * Display the specified vacancy application.
     *
     * @param Vacancy $vacancy
     * @param Application $application
     * @return ApplicationResource
     */
    public function show(Vacancy $vacancy, Application $application): ApplicationResource
    {
        return ApplicationResource::make($application);
    }

    /**
     * Remove the specified vacancy application from storage.
     *
     * @param DeletesApplications $deleter
     * @param Vacancy $vacancy
     * @param Application $application
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(DeletesApplications $deleter, Vacancy $vacancy, Application $application): JsonResponse
    {
        throw_unless($deleter->delete($application));

        return response()->json([
            'message' => __('response.application.delete.success'),
        ]);
    }
}
