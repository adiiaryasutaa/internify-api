<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

final class VacancySeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all(['id']);

        $vacancies = $companies->map(function (Company $company) {
            $count = random_int(2, 10);

            return Vacancy::factory()
                ->for($company)
                ->count($count)
                ->withSlug()
                ->make();
        })->flatten(1);

        $chunks = $vacancies->chunk(20);

        $chunks->each(fn($chunk) => Vacancy::insert($chunk->toArray()));
    }
}
