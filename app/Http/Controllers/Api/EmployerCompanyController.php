<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Company\Contracts\CreatesCompanies;
use App\Actions\Company\Contracts\DeletesCompanies;
use App\Actions\Company\Contracts\UpdatesCompanies;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCompanyRequest;
use App\Http\Requests\Api\StoreEmployerRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\Employer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class EmployerCompanyController extends Controller
{
    public function index(Employer $employer): JsonResource
    {
        Gate::authorize('view', Company::class);

        return CompanyResource::make($employer->load('company')->company);
    }

    public function store(CreatesCompanies $creator, StoreEmployerRequest $request, Employer $employer): JsonResponse
    {
        Gate::authorize('create', [Company::class, $employer]);

        $creator->create($employer, $request->validated());

        return response()->json([
            'message' => __('response.company.create.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesCompanies $updater, StoreCompanyRequest $request, Employer $employer, Company $company): JsonResponse
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
    public function destroy(DeletesCompanies $deleter, Employer $employer, Company $company): JsonResponse
    {
        Gate::authorize('delete', $company);

        throw_unless($deleter->delete($company));

        return response()->json([
            'message' => __('response.company.delete.success'),
        ]);
    }
}