<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Contracts\CreatesCategories;
use App\Actions\Category\Contracts\GeneratesCategoriesCodes;
use App\Actions\Category\Contracts\GeneratesCategoriesSlugs;
use App\Models\Category;
use Illuminate\Support\Arr;

final class CreateCategory implements CreatesCategories
{
    private array $fills;

    public function __construct(
        Category $category,
        protected GeneratesCategoriesCodes $codeGenerator,
        protected GeneratesCategoriesSlugs $slugGenerator,
    ) {
        $this->fills = array_diff($category->getFillable(), ['code', 'slug']);
    }

    public function create(array $inputs): Category
    {
        $data = Arr::only($inputs, $this->fills);
        $data['code'] = $this->codeGenerator->generate();
        $data['slug'] = $this->slugGenerator->generate($data['name']);

        return Category::create($data);
    }
}
