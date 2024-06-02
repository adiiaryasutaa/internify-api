<?php

declare(strict_types=1);

namespace Api\Employer;

use App\Models\Apprentice;
use App\Models\Company;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Employer\Traits\ActingAsEmployer;
use Tests\TestCase;

final class ReviewTest extends TestCase
{
    use ActingAsEmployer;
    use RefreshDatabase;

    public function test_review_list(): void
    {
        $company = Company::factory()->for($this->employer)->create();
        $this->assertModelExists($company);

        $apprentices = Apprentice::factory()->has(User::factory()->asApprentice(), 'user')->count(20)->create();
        $apprentices->each(fn(Apprentice $apprentice) => $this->assertModelExists($apprentice));

        $reviews = $apprentices->map(fn(Apprentice $apprentice) => Review::factory()->for($apprentice)->for($company)->make());
        Review::insert($reviews->toArray());
        $reviews->each(fn(Review $review) => $this->assertDatabaseHas('reviews', $review->toArray()));

        $response = $this->getJson(route('reviews.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_review(): void
    {
        $this->assertThrows(function (): void {
            $this->getJson(route('reviews.store'));
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
