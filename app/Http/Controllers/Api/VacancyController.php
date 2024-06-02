<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Vacancy\Contracts\CreatesVacancies;
use App\Actions\Vacancy\Contracts\DeletesVacancies;
use App\Actions\Vacancy\Contracts\UpdatesVacancies;
use App\Enums\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreVacancyRequest;
use App\Http\Requests\Api\UpdateVacancyRequest;
use App\Http\Resources\VacancyCollection;
use App\Http\Resources\VacancyResource;
use App\Models\Category;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class VacancyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Vacancy::class, 'vacancy');
    }

    public function index(Request $request): VacancyCollection
    {
        $perPage = $request->integer('per-page', null);

        return VacancyCollection::make(
            Vacancy::paginate($perPage),
        );
    }

    public function store(CreatesVacancies $creator, StoreVacancyRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $company = match ($user->role) {
            Role::ADMIN => Company::whereCode($request['company'])->first(['id', 'slug']),
            Role::EMPLOYER => $user->loadMissing('userable.company')->userable->company,
        };

        $category = Category::whereCode($request['category'])->first(['id', 'slug']);

        $creator->create($company, $category, $data);

        return response()->json([
            'message' => __('response.vacancy.create.success'),
        ]);
    }

    public function show(Vacancy $vacancy): VacancyResource
    {
        return VacancyResource::make($vacancy);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesVacancies $updater, UpdateVacancyRequest $request, Vacancy $vacancy): JsonResponse
    {
        $data = $request->validated();

        $data['category'] = Category::whereCode($request['category'])->first(['id', 'slug']);

        throw_unless($updater->update($vacancy, $data));

        return response()->json([
            'message' => __('response.vacancy.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesVacancies $deleter, Vacancy $vacancy): JsonResponse
    {
        throw_unless($deleter->delete($vacancy));

        return response()->json([
            'message' => __('response.vacancy.delete.success'),
        ]);
    }
}
