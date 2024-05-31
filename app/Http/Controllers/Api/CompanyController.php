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
use Throwable;

final class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Company::class, 'company');
    }

    public function index(Request $request): CompanyCollection
    {
        return CompanyCollection::make(Company::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesCompanies $creator, StoreCompanyRequest $request): JsonResponse
    {
        $request = $request->validated();

        $employer = Employer::whereCode($request['employer'])->firstOrFail(['id', 'slug']);

        $creator->create($employer, $request);

        return response()->json([
            'message' => __('response.company.create.success'),
        ]);
    }

    public function show(Company $company): CompanyResource
    {
        return CompanyResource::make($company);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesCompanies $updater, UpdateCompanyRequest $request, Company $company): JsonResponse
    {
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
        throw_unless($deleter->delete($company));

        return response()->json([
            'message' => __('response.company.delete.success'),
        ]);
    }
}
