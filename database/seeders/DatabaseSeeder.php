<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            EmployerSeeder::class,
            ApprenticeSeeder::class,
            CompanySeeder::class,
            VacancySeeder::class,
            ApplicationSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
