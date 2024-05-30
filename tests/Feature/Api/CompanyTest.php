<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Company;
use App\Models\Employer;
use App\Models\User;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\Feature\Api\Traits\ActingAsAdmin;
use Tests\TestCase;

final class CompanyTest extends TestCase
{
    use RefreshDatabase;
    use ActingAsAdmin;

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
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $data = array_merge(Company::factory()->raw(), [
            'employer' => $employer->slug,
            'cover' => UploadedFile::fake()->image('cover.png'),
        ]);

        $response = $this->postJson(route('companies.store'), $data);

        $response->assertOk();
        $this->assertDatabaseHas('companies', Arr::except($data, ['cover', 'employer']));
        $response->assertJsonStructure(['message']);
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
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $data = array_merge(Company::factory()->withoutSlug()->raw(), [
            'cover' => UploadedFile::fake()->image('cover.png'),
        ]);

        $response = $this->putJson(route('companies.update', $company), $data);

        $response->assertOk();
        $this->assertDatabaseHas('companies', Arr::except($data, ['cover']));
        $response->assertJsonStructure(['message']);
    }

    public function test_delete_company(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);
        $this->assertModelExists($employer->user);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $response = $this->deleteJson(route('companies.destroy', $company));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($company);
    }
}
