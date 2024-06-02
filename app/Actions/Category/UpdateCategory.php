<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Contracts\GeneratesCategoriesSlugs;
use App\Actions\Category\Contracts\UpdatesCategories;
use App\Models\Category;
use Illuminate\Support\Arr;

final class UpdateCategory implements UpdatesCategories
{
    private array $fills;

    public function __construct(
        Category $category,
        protected GeneratesCategoriesSlugs $slugGenerator,
    ) {
        $this->fills = array_diff($category->getFillable(), ['code', 'slug']);
    }

    public function update(Category $category, array $inputs): bool
    {
        $data = Arr::only($inputs, $this->fills);
        $data['slug'] = $this->slugGenerator->generate($data['name']);

        return $category->update($data);
    }
}
