<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Admin\Contracts\CreatesAdmins;
use App\Actions\Admin\Contracts\DeletesAdmins;
use App\Actions\Admin\Contracts\UpdatesAdmins;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAdminRequest;
use App\Http\Requests\Api\UpdateAdminRequest;
use App\Http\Resources\AdminCollection;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Throwable;

final class AdminController extends Controller
{
    public function index(Request $request): AdminCollection
    {
        Gate::authorize('viewAny', Admin::class);

        return AdminCollection::make(Admin::paginate(
            perPage: $request->integer('per-page', null),
        ));
    }

    public function store(CreatesAdmins $creator, StoreAdminRequest $request): JsonResponse
    {
        Gate::authorize('create', Admin::class);

        $creator->create($request->validated());

        return response()->json([
            'message' => __('response.admin.create.success'),
        ]);
    }

    public function show(Admin $admin): AdminResource
    {
        Gate::authorize('view', $admin);

        return AdminResource::make($admin);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesAdmins $updater, UpdateAdminRequest $request, Admin $admin): JsonResponse
    {
        Gate::authorize('update', $admin);

        throw_unless($updater->update($admin, $request->validated()));

        return response()->json([
            'message' => __('response.admin.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesAdmins $deleter, Admin $admin): JsonResponse
    {
        Gate::authorize('delete', $admin);

        throw_unless($deleter->delete($admin));

        return response()->json([
            'message' => __('response.admin.delete.success'),
        ]);
    }
}
