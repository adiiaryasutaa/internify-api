<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Vacancy\Contracts\CreatesVacancies;
use App\Actions\Vacancy\Contracts\DeletesVacancies;
use App\Actions\Vacancy\Contracts\UpdatesVacancies;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreVacancyRequest;
use App\Http\Requests\Api\UpdateVacancyRequest;
use App\Http\Resources\VacancyCollection;
use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class VacancyController extends Controller
{
    public function index(Request $request): VacancyCollection
    {
        Gate::authorize('viewAny', Vacancy::class);

        $perPage = $request->integer('per-page', null);

        return VacancyCollection::make(
            Vacancy::paginate($perPage),
        );
    }

    public function store(CreatesVacancies $creator, StoreVacancyRequest $request): JsonResponse
    {
        Gate::authorize('create', Vacancy::class);

        $request = $request->validated();

        $company = Company::whereSlug(Arr::pull($request, 'company'))->firstOrFail(['id', 'slug']);

        $creator->create($company, $request);

        return response()->json([
            'message' => __('response.vacancy.create.success'),
        ]);
    }

    public function show(Vacancy $vacancy): VacancyResource
    {
        Gate::authorize('view', $vacancy);

        return VacancyResource::make($vacancy);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesVacancies $updater, UpdateVacancyRequest $request, Vacancy $vacancy): JsonResponse
    {
        Gate::authorize('update', $vacancy);

        throw_unless($updater->update($vacancy, $request->validated()));

        return response()->json([
            'message' => __('response.vacancy.update.success'),
        ]);

    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesVacancies $deleter, Vacancy $vacancy): JsonResponse
    {
        Gate::authorize('delete', $vacancy);

        throw_unless($deleter->delete($vacancy));

        return response()->json([
            'message' => __('response.vacancy.delete.success'),
        ]);
    }
}
