<?php

declare(strict_types=1);

namespace App\Actions\Category;

use App\Actions\Category\Contracts\DeletesCategories;
use App\Models\Category;

final class DeleteCategory implements DeletesCategories
{
    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
