<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Category\Contracts\CreatesCategories;
use App\Actions\Category\Contracts\DeletesCategories;
use App\Actions\Category\Contracts\UpdatesCategories;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCategoryRequest;
use App\Http\Requests\Api\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

final class CategoryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Category::class, ['category']);
    }

    public function index(Request $request): CategoryCollection
    {
        $perPage = $request->integer('per_page', null);

        $categories = Category::paginate($perPage);

        return CategoryCollection::make($categories);
    }

    public function store(CreatesCategories $creator, StoreCategoryRequest $request): JsonResponse
    {
        $data = $request->validated();

        $creator->create($data);

        return response()->json([
            'message' => __('response.category.create.success'),
        ]);
    }

    public function show(Category $category): CategoryResource
    {
        return CategoryResource::make($category);
    }

    /**
     * @throws Throwable
     */
    public function update(UpdatesCategories $updater, UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();

        throw_unless($updater->update($category, $data));

        return response()->json([
            'message' => __('response.category.update.success'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function destroy(DeletesCategories $deleter, Category $category): JsonResponse
    {
        throw_unless($deleter->delete($category));

        return response()->json([
            'message' => __('response.category.delete.success'),
        ]);
    }
}
