<?php

declare(strict_types=1);

namespace App\Actions\Category\Contracts;

use App\Models\Category;

interface DeletesCategories
{
    public function delete(Category $category);
}
