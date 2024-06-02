<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

final class VacancySeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all(['id']);
        $categories = Category::all(['id']);

        $vacancies = $companies->map(function (Company $company) use ($categories) {
            $count = random_int(2, 10);

            $categories = $categories->random($count);

            $sequences = $categories->map(fn(Category $category) => ['category_id' => $category->id])->toArray();

            return Vacancy::factory()
                ->for($company)
                ->count($count)
                ->sequence(...$sequences)
                ->make();
        })->flatten(1);

        $chunks = $vacancies->chunk(20);

        $chunks->each(fn($chunk) => Vacancy::insert($chunk->toArray()));
    }
}
