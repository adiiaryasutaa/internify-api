<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Employer;

use App\Models\Application;
use App\Models\Apprentice;
use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Employer\Traits\ActingAsEmployer;
use Tests\TestCase;

final class ApplicationTest extends TestCase
{
    use ActingAsEmployer;
    use RefreshDatabase;

    public function test_application_list(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $vacancy = Vacancy::factory()->for($company)->for($category)->create();
        $this->assertModelExists($vacancy);

        $apprentices = Apprentice::factory()->count(20)->has(User::factory()->asApprentice(), 'user')->create();
        $apprentices->each(fn(Apprentice $apprentice) => $this->assertModelExists($apprentice));

        $applications = $apprentices->map(fn(Apprentice $apprentice) => Application::factory()->for($apprentice)->for($vacancy)->make());
        Application::insert($applications->toArray());
        $applications->each(fn(Application $application) => $this->assertDatabaseHas('applications', $application->toArray()));

        $response = $this->getJson(route('applications.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_application(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('applications.store'));
        }, RouteNotFoundException::class);
    }

    public function test_show_application(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $vacancy = Vacancy::factory()->for($company)->for($category)->create();
        $this->assertModelExists($vacancy);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create();
        $this->assertModelExists($apprentice);

        $application = Application::factory()->for($apprentice)->for($vacancy)->create();
        $this->assertModelExists($application);

        $response = $this->getJson(route('applications.show', $application));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_application(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $vacancy = Vacancy::factory()->for($company)->for($category)->create();
        $this->assertModelExists($vacancy);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $application = Application::factory()->for($apprentice)->for($vacancy)->create();
        $this->assertModelExists($application);

        $response = $this->putJson(route('applications.update', $application));

        $response->assertNotFound();
        $response->assertJsonStructure(['message']);
    }

    public function test_delete_application(): void
    {
        $this->assertThrows(function (): void {
            $this->deleteJson(route('applications.destroy'));
        }, RouteNotFoundException::class);
    }
}
