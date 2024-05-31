<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Application;
use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use App\Models\Vacancy;
use Database\Seeders\ApplicationSeeder;
use Database\Seeders\ApprenticeSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\VacancySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\Traits\ActingAsAdmin;
use Tests\TestCase;

final class ApplicationTest extends TestCase
{
    use ActingAsAdmin;
    use RefreshDatabase;

    public function test_application_list(): void
    {
        $this->seed([
            EmployerSeeder::class,
            ApprenticeSeeder::class,
            CompanySeeder::class,
            VacancySeeder::class,
            ApplicationSeeder::class,
        ]);

        $response = $this->getJson(route('vacancies.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_application(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $data = Application::factory()->for($apprentice)->for($vacancy)->withoutCode()->withoutSlug()->raw();

        $response = $this->postJson(route('applications.store'), array_merge($data, [
            'vacancy' => $vacancy->slug,
            'apprentice' => $apprentice->slug,
        ]));

        $response->assertOk();
        $this->assertDatabaseHas('applications', $data);
        $response->assertJsonStructure(['message']);
    }

    public function test_show_application(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $application = Application::factory()->for($apprentice)->for($vacancy)->create();
        $this->assertModelExists($application);

        $response = $this->getJson(route('applications.show', $application));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_application(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $application = Application::factory()->for($apprentice)->for($vacancy)->create();
        $this->assertModelExists($application);

        $data = Application::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->putJson(route('applications.update', $application), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertDatabaseHas('applications', array_merge($application->toArray(), $data));
    }

    public function test_delete_application(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $application = Application::factory()->for($apprentice)->for($vacancy)->create();
        $this->assertModelExists($application);

        $response = $this->deleteJson(route('applications.destroy', $application));

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertModelMissing($application);
    }
}
