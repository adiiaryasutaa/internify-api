<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Vacancy\Contracts\CreatesVacancies;
use App\Actions\Vacancy\Contracts\DeletesVacancies;
use App\Actions\Vacancy\Contracts\UpdatesVacancies;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\StoreVacancyRequest;
use App\Http\Requests\Api\Company\UpdateVacancyRequest;
use App\Http\Resources\VacancyCollection;
use App\Http\Resources\VacancyResource;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class CompanyVacancyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vacancy::class, ['company', 'vacancy']);
    }

    /**
     * Display a listing of the company vacancies.
     *
     * @param Request $request
     * @param Company $company
     * @return JsonResource
     */
    public function index(Request $request, Company $company): JsonResource
    {
        $perPage = $request->integer('per-page', null);

        $vacancies = $company->vacancies()->paginate($perPage);

        return VacancyCollection::make($vacancies);
    }

    /**
     * Store a newly created vacancy in storage.
     *
     * @param CreatesVacancies $creator
     * @param StoreVacancyRequest $request
     * @param Company $company
     * @return JsonResponse
     */
    public function store(CreatesVacancies $creator, StoreVacancyRequest $request, Company $company): JsonResponse
    {
        $data = $request->validated();

        $creator->create($company, $data);

        return response()->json([
            'message' => __('response.vacancy.create.success'),
        ]);
    }

    /**
     * Display the specified Vacancy.
     *
     * @param Company $company
     * @param Vacancy $vacancy
     * @return JsonResource
     */
    public function show(Company $company, Vacancy $vacancy): JsonResource
    {
        return VacancyResource::make($vacancy);
    }

    /**
     * Update the specified Vacancy in storage.
     *
     * @param UpdatesVacancies $updater
     * @param UpdateVacancyRequest $request
     * @param Company $company
     * @param Vacancy $vacancy
     * @return JsonResponse
     * @throws Throwable
     */
    public function update(UpdatesVacancies $updater, UpdateVacancyRequest $request, Company $company, Vacancy $vacancy): JsonResponse
    {
        $data = $request->validated();

        throw_unless($updater->update($vacancy, $data));

        return response()->json([
            'message' => __('response.vacancy.update.success'),
        ]);
    }

    /**
     * Remove the specified Vacancy from storage.
     *
     * @param DeletesVacancies $deleter
     * @param Company $company
     * @param Vacancy $vacancy
     * @return JsonResponse
     * @throws Throwable
     */
    public function destroy(DeletesVacancies $deleter, Company $company, Vacancy $vacancy)
    {
        throw_unless($deleter->delete($vacancy));

        return response()->json([
            'message' => __('response.vacancy.delete.success'),
        ]);
    }
}
