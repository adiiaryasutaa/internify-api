<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\Admin;
use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Employer;
use App\Models\Review;
use App\Models\User;
use Database\Seeders\ApprenticeSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\EmployerSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

final class ReviewTest extends TestCase
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

    public function test_review_list(): void
    {
        $this->seed([
            EmployerSeeder::class,
            ApprenticeSeeder::class,
            CompanySeeder::class,
            ReviewSeeder::class,
        ]);

        $response = $this->getJson(route('reviews.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_review(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $data = Review::factory()->for($apprentice)->for($company)->state([
            'company' => $company->slug,
            'apprentice' => $apprentice->slug,
        ])->raw();

        $response = $this->postJson(route('reviews.store'), $data);

        Arr::forget($data, ['company', 'apprentice']);

        $response->assertOk();
        $this->assertDatabaseHas('reviews', $data);
        $response->assertJsonStructure(['message']);
    }

    public function test_show_review(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $review = Review::factory()->for($apprentice)->for($company)->withSlug()->create();
        $this->assertModelExists($review);

        $response = $this->getJson(route('reviews.show', $review));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_review(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $review = Review::factory()->for($apprentice)->for($company)->withSlug()->create();
        $this->assertModelExists($review);

        $data = Review::factory()->raw();

        $response = $this->putJson(route('reviews.update', $review), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertDatabaseHas('reviews', array_merge($review->toArray(), $data));
    }

    public function test_delete_review(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $review = Review::factory()->for($apprentice)->for($company)->withSlug()->create();
        $this->assertModelExists($review);

        $response = $this->deleteJson(route('reviews.destroy', $review));

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertModelMissing($review);
    }
}
