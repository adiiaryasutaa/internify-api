<?php

declare(strict_types=1);

namespace Api\Apprentice;

use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Employer;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Apprentice\Traits\ActingAsApprentice;
use Tests\TestCase;

final class CompanyReviewTest extends TestCase
{
    use ActingAsApprentice;
    use RefreshDatabase;

    public function test_review_list(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $apprentices = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->count(20)->create();
        $apprentices->each(fn(Apprentice $apprentice) => $this->assertModelExists($apprentice));

        $reviews = $apprentices->map(fn(Apprentice $apprentice) => Review::factory()->for($apprentice)->for($company)->make());
        Review::insert($reviews->toArray());
        $reviews->each(fn(Review $review) => $this->assertDatabaseHas('reviews', $review->toArray()));

        $response = $this->getJson(route('companies.reviews.index', $company));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_review(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $data = Review::factory()->for($this->apprentice)->for($company)->withoutCode()->withoutSlug()->raw();

        $response = $this->postJson(route('companies.reviews.store', $company), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('reviews', $data);
    }

    public function test_show_review(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('companies.reviews.show'));
        }, RouteNotFoundException::class);
    }

    public function test_update_review(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $review = Review::factory()->for($this->apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $data = Review::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->putJson(route('companies.reviews.update', [$company, $review]), $data);

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

        $review = Review::factory()->for($this->apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $response = $this->deleteJson(route('companies.reviews.destroy', [$company, $review]));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($review);
    }
}
