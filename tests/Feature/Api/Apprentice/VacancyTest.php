<?php

declare(strict_types=1);

namespace Api\Apprentice;

use App\Models\Category;
use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use App\Models\Vacancy;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\VacancySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\Apprentice\Traits\ActingAsApprentice;
use Tests\TestCase;

final class VacancyTest extends TestCase
{
    use ActingAsApprentice;
    use RefreshDatabase;

    public function test_vacancy_list(): void
    {
        $this->seed([
            EmployerSeeder::class,
            CompanySeeder::class,
            CategorySeeder::class,
            VacancySeeder::class,
        ]);

        $response = $this->getJson(route('vacancies.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_vacancy(): void
    {
        $response = $this->postJson(route('vacancies.store'));

        $response->assertNotFound();
    }

    public function test_show_vacancy(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $vacancy = Vacancy::factory()->for($company)->for($category)->create();
        $this->assertModelExists($vacancy);

        $response = $this->getJson(route('vacancies.show', $vacancy));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_vacancy(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $vacancy = Vacancy::factory()->for($company)->for($category)->create();
        $this->assertModelExists($vacancy);

        $response = $this->putJson(route('vacancies.update', $vacancy));

        $response->assertNotFound();
    }

    public function test_delete_vacancy(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $vacancy = Vacancy::factory()->for($company)->for($category)->create();
        $this->assertModelExists($vacancy);

        $response = $this->deleteJson(route('vacancies.destroy', $vacancy));

        $response->assertNotFound();
    }
}
