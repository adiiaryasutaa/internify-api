<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Employer\Contracts\CreatesEmployers;
use App\Actions\Employer\Contracts\DeletesEmployers;
use App\Actions\Employer\Contracts\UpdatesEmployers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreEmployerRequest;
use App\Http\Requests\Api\UpdateEmployerRequest;
use App\Http\Resources\EmployerCollection;
use App\Http\Resources\EmployerResource;
use App\Models\Employer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class EmployerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Employer::class, 'employer');
    }

    public function index(Request $request): EmployerCollection
    {
        return EmployerCollection::make(Employer::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesEmployers $creator, StoreEmployerRequest $request): JsonResponse
    {
        $creator->create($request->validated());

        return response()->json([
            'message' => __('response.employer.create.success'),
        ]);
    }

    public function show(Employer $employer): EmployerResource
    {
        return EmployerResource::make($employer);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesEmployers $updater, UpdateEmployerRequest $request, Employer $employer): JsonResponse
    {
        throw_unless($updater->update($employer, $request->validated()));

        return response()->json([
            'message' => __('response.employer.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesEmployers $deleter, Employer $employer): JsonResponse
    {
        throw_unless($deleter->delete($employer));

        return response()->json([
            'message' => __('response.employer.delete.success'),
        ]);
    }
}
