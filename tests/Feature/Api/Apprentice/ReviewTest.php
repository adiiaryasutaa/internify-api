<?php

declare(strict_types=1);

namespace Api\Apprentice;

use App\Models\Company;
use App\Models\Employer;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Apprentice\Traits\ActingAsApprentice;
use Tests\TestCase;

final class ReviewTest extends TestCase
{
    use ActingAsApprentice;
    use RefreshDatabase;

    public function test_review_list(): void
    {
        $employer = Employer::factory()->has(User::factory()->asEmployer(), 'user')->create();
        $this->assertModelExists($employer);

        $company = Company::factory()->for($employer)->create();
        $this->assertModelExists($company);

        $reviews = Review::factory()->for($company)->for($this->apprentice)->count(20)->create();
        $reviews->each(fn(Review $review) => $this->assertModelExists($review));

        $response = $this->getJson(route('reviews.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_review(): void
    {
        $this->assertThrows(function (): void {
            $this->postJson(route('reviews.store'));
        }, RouteNotFoundException::class);
    }

    public function test_show_review(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('reviews.show'));
        }, RouteNotFoundException::class);
    }

    public function test_update_review(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('reviews.update'));
        }, RouteNotFoundException::class);
    }

    public function test_delete_review(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('reviews.destroy'));
        }, RouteNotFoundException::class);
    }
}
