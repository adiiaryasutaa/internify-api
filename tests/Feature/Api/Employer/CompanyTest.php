<?php

declare(strict_types=1);

namespace Api\Employer;

use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Employer\Traits\ActingAsEmployer;
use Tests\TestCase;

final class CompanyTest extends TestCase
{
    use ActingAsEmployer;
    use RefreshDatabase;

    public function test_company_list(): void
    {
        $this->seed([
            EmployerSeeder::class,
            CompanySeeder::class,
        ]);

        $response = $this->getJson(route('companies.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_company(): void
    {
        $this->assertThrows(function (): void {
            $this->postJson(route('companies.store'));
        }, RouteNotFoundException::class);
    }

    public function test_show_company(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $response = $this->getJson(route('companies.show', $company));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_company(): void
    {
        $this->assertThrows(function (): void {
            $this->postJson(route('companies.update'));
        }, RouteNotFoundException::class);
    }

    public function test_delete_company(): void
    {
        $this->assertThrows(function (): void {
            $this->postJson(route('companies.destroy'));
        }, RouteNotFoundException::class);
    }
}
