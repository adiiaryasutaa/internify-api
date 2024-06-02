<?php

declare(strict_types=1);

namespace App\Actions\Category\Contracts;

use App\Models\Category;

interface UpdatesCategories
{
    public function update(Category $category, array $inputs);
}
