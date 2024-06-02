<?php

declare(strict_types=1);

namespace Api\Employer;

use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Employer;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Employer\Traits\ActingAsEmployer;
use Tests\TestCase;

final class CompanyReviewTest extends TestCase
{
    use ActingAsEmployer;
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

        $response = $this->postJson(route('companies.reviews.store', $company));

        $response->assertNotFound();
    }

    public function test_show_review(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('companies.reviews.show'));
        }, RouteNotFoundException::class);
    }

    public function test_update_review(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $review = Review::factory()->for($apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $response = $this->putJson(route('companies.reviews.update', [$company, $review]));

        $response->assertNotFound();
    }

    public function test_delete_review(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $apprentice = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->create()->refresh();
        $this->assertModelExists($apprentice);

        $review = Review::factory()->for($apprentice)->for($company)->create();
        $this->assertModelExists($review);

        $response = $this->deleteJson(route('companies.reviews.destroy', [$company, $review]));

        $response->assertNotFound();
    }
}
