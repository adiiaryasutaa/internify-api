<?php

declare(strict_types=1);

namespace Api\Admin;

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
use Tests\Feature\Api\Admin\Traits\ActingAsAdmin;
use Tests\TestCase;

final class ReviewTest extends TestCase
{
    use ActingAsAdmin;
    use RefreshDatabase;

    public function test_review_list(): void
    {
        $this->seed([
            EmployerSeeder::class,
            ApprenticeSeeder::class,
            CompanySeeder::class,
            ReviewSeeder::class,
        ]);

        $response = $this->getJson(route('admin.reviews.index'));

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

        $data = Review::factory()->for($apprentice)->for($company)->withoutCode()->withoutSlug()->raw();

        $response = $this->postJson(route('admin.reviews.store'), array_merge($data, [
            'company' => $company->code,
            'apprentice' => $apprentice->code,
        ]));

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

        $review = Review::factory()->for($apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $response = $this->getJson(route('admin.reviews.show', $review));

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

        $review = Review::factory()->for($apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $data = Review::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->putJson(route('admin.reviews.update', $review), $data);

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

        $review = Review::factory()->for($apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $response = $this->deleteJson(route('admin.reviews.destroy', $review));

        $response->assertOk();
        $response->assertJsonStructure(['message']);

        $this->assertModelMissing($review);
    }
}
