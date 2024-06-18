<?php

declare(strict_types=1);

namespace Api;

use Database\Seeders\ApplicationSeeder;
use Database\Seeders\ApprenticeSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\VacancySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class SearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search(): void
    {
        $this->seed([
            EmployerSeeder::class,
            CompanySeeder::class,
            CategorySeeder::class,
            VacancySeeder::class,
            ApprenticeSeeder::class,
            ApplicationSeeder::class,
        ]);

        $response = $this->get(route('search', [
            'search' => 'Ah',
            'filters' => ['company', 'vacancy'],
        ]));

        $response->assertStatus(200);
    }
}
