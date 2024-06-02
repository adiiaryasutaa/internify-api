<?php

declare(strict_types=1);

namespace Api\Apprentice;

use App\Models\Category;
use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Apprentice\Traits\ActingAsApprentice;
use Tests\TestCase;

final class CompanyVacancyTest extends TestCase
{
    use ActingAsApprentice;
    use RefreshDatabase;

    public function test_vacancy_list(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        Vacancy::factory()->for($company)->for($category)->count(20)->create();

        $response = $this->getJson(route('companies.vacancies.index', $company));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_vacancy(): void
    {
        $this->assertThrows(function (): void {
            $this->putJson(route('companies.vacancies.store'));
        }, RouteNotFoundException::class);
    }

    public function test_show_vacancy(): void
    {
        $this->assertThrows(function (): void {
            $this->putJson(route('companies.vacancies.show'));
        }, RouteNotFoundException::class);
    }

    public function test_update_vacancy(): void
    {
        $this->assertThrows(function (): void {
            $this->putJson(route('companies.vacancies.update'));
        }, RouteNotFoundException::class);
    }

    public function test_delete_vacancy(): void
    {
        $this->assertThrows(function (): void {
            $this->putJson(route('companies.vacancies.destroy'));
        }, RouteNotFoundException::class);
    }
}
