<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Company\Contracts\CreatesCompanies;
use App\Actions\Company\Contracts\DeletesCompanies;
use App\Actions\Company\Contracts\UpdatesCompanies;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCompanyRequest;
use App\Http\Requests\Api\UpdateCompanyRequest;
use App\Http\Resources\CompanyCollection;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Employer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class CompanyController extends Controller
{
    public function index(Request $request): CompanyCollection
    {
        Gate::authorize('viewAny', Company::class);

        return CompanyCollection::make(Company::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesCompanies $creator, StoreCompanyRequest $request): JsonResponse
    {
        Gate::authorize('create', Company::class);

        $request = $request->validated();

        $employer = Employer::whereSlug(Arr::pull($request, 'employer'))->firstOrFail(['id', 'slug']);

        $creator->create($employer, $request);

        return response()->json([
            'message' => __('response.company.create.success'),
        ]);
    }

    public function show(Company $company): CompanyResource
    {
        Gate::authorize('view', $company);

        return CompanyResource::make($company);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesCompanies $updater, UpdateCompanyRequest $request, Company $company): JsonResponse
    {
        Gate::authorize('update', $company);

        throw_unless($updater->update($company, $request->validated()));

        return response()->json([
            'message' => __('response.company.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesCompanies $deleter, Company $company): JsonResponse
    {
        Gate::authorize('delete', $company);

        throw_unless($deleter->delete($company));

        return response()->json([
            'message' => __('response.company.delete.success'),
        ]);
    }
}
