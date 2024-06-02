<?php

declare(strict_types=1);

namespace Api\Apprentice;

use App\Models\Application;
use App\Models\Category;
use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Apprentice\Traits\ActingAsApprentice;
use Tests\TestCase;

final class VacancyApplicationTest extends TestCase
{
    use ActingAsApprentice;
    use RefreshDatabase;

    public function test_application_list(): void
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

        $response = $this->getJson(route('vacancies.applications.index', $vacancy));

        $response->assertNotFound();
    }

    public function test_create_application(): void
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

        $data = Application::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->postJson(route('vacancies.applications.store', $vacancy), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('applications', $data);
    }

    public function test_show_application(): void
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

        $application = Application::factory()->for($this->apprentice)->for($vacancy)->create();
        $this->assertModelExists($application);

        $response = $this->getJson(route('vacancies.applications.show', [$vacancy, $application]));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_application(): void
    {
        $this->assertThrows(function (): void {
            $this->putJson(route('vacancies.applications.update'));
        }, RouteNotFoundException::class);
    }

    public function test_delete_application(): void
    {
        $this->assertThrows(function (): void {
            $this->deleteJson(route('applications.destroy'));
        }, RouteNotFoundException::class);
    }
}
