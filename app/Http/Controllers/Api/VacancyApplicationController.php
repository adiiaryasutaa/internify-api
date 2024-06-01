<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Application\Contracts\DeletesApplications;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationCollection;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class VacancyApplicationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Application::class, ['vacancy', 'application']);
    }

    /**
     * Display a listing of the vacancy applications.
     *
     * @param Request $request
     * @param Vacancy $vacancy
     * @return JsonResponse
     */
    public function index(Request $request, Vacancy $vacancy): JsonResponse
    {
        $perPage = $request->integer('per-page', null);

        $applications = $vacancy->applications()->paginate($perPage);

        return ApplicationCollection::make($applications);
    }

    /**
     * Display the specified vacancy application.
     *
     * @param Vacancy $vacancy
     * @param Application $application
     * @return JsonResponse
     */
    public function show(Vacancy $vacancy, Application $application): JsonResponse
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
