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

final class ApplicationTest extends TestCase
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

        $vacancies = Vacancy::factory()->count(20)->for($company)->for($category)->create();
        $vacancies->each(fn(Vacancy $vacancy) => $this->assertModelExists($vacancy));

        $applications = $vacancies->map(fn(Vacancy $vacancy) => Application::factory()->for($this->apprentice)->for($vacancy)->make());
        Application::insert($applications->toArray());
        $applications->each(fn(Application $application) => $this->assertDatabaseHas('applications', $application->toArray()));

        $response = $this->getJson(route('applications.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_application(): void
    {
        $this->assertThrows(function (): void {
            $this->postJson(route('applications.store'));
        }, RouteNotFoundException::class);
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

        $response = $this->getJson(route('applications.show', $application));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_application(): void
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

        $data = Application::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->putJson(route('applications.update', $application), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('applications', array_merge($application->toArray(), $data));
    }

    public function test_delete_application(): void
    {
        $this->assertThrows(function (): void {
            $this->deleteJson(route('applications.destroy'));
        }, RouteNotFoundException::class);
    }
}
