<?php

declare(strict_types=1);

namespace Api\Employer;

use App\Models\Company;
use App\Models\Vacancy;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\VacancySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\Employer\Traits\ActingAsEmployer;
use Tests\TestCase;

final class VacancyTest extends TestCase
{
    use ActingAsEmployer;
    use RefreshDatabase;

    public function test_vacancy_list(): void
    {
        $this->seed([
            EmployerSeeder::class,
            CompanySeeder::class,
            VacancySeeder::class,
        ]);

        $response = $this->getJson(route('vacancies.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_vacancy(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $data = Vacancy::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->postJson(route('vacancies.store'), $data);

        $response->assertOk();
        $this->assertDatabaseHas('vacancies', $data);
        $response->assertJsonStructure(['message']);
    }

    public function test_show_vacancy(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $response = $this->getJson(route('vacancies.show', $vacancy));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_vacancy(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $data = Vacancy::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->putJson(route('vacancies.update', $vacancy), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('vacancies', array_merge($vacancy->toArray(), $data));
    }

    public function test_delete_vacancy(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $vacancy = Vacancy::factory()->for($company)->create();
        $this->assertModelExists($vacancy);

        $response = $this->deleteJson(route('vacancies.destroy', $vacancy));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($vacancy);
    }
}
