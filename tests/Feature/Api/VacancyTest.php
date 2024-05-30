<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use App\Models\Vacancy;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\VacancySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class VacancyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(
            User::factory()
                ->asAdmin()
                ->for(Admin::factory()->owner(), 'userable')
                ->create(),
        );
    }

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
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $data = Vacancy::factory()->for($company)->state(['company' => $company->slug])->raw();

        $response = $this->postJson(route('vacancies.store'), $data);

        $response->assertOk();

        Arr::forget($data, ['company']);

        $this->assertDatabaseHas('vacancies', $data);

        $response->assertJsonStructure(['message']);
    }

    public function test_show_vacancy(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $company = Company::factory()->for($employer)->create();
        $vacancy = Vacancy::factory()->for($company)->withSlug()->create();

        $response = $this->getJson(route('vacancies.show', $vacancy));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_vacancy(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $company = Company::factory()->for($employer)->create();
        $vacancy = Vacancy::factory()->for($company)->withSlug()->create();

        $data = Vacancy::factory()->raw();

        $response = $this->putJson(route('vacancies.update', $vacancy), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertDatabaseHas('vacancies', array_merge($vacancy->toArray(), $data));
    }

    public function test_delete_vacancy(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $company = Company::factory()->for($employer)->create();
        $vacancy = Vacancy::factory()->for($company)->withSlug()->create();

        $response = $this->deleteJson(route('vacancies.destroy', $vacancy));

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertModelMissing($vacancy);
    }
}
