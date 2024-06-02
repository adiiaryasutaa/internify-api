<?php

declare(strict_types=1);

namespace Api\Employer;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tests\Feature\Api\Employer\Traits\ActingAsEmployer;
use Tests\TestCase;

final class CategoryTest extends TestCase
{
    use ActingAsEmployer;
    use RefreshDatabase;

    public function test_category_list(): void
    {
        $this->seed(CategorySeeder::class);

        $response = $this->getJson(route('categories.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_category(): void
    {
        $this->assertThrows(function (): void {
            $this->postJson(route('categories.store'));
        }, RouteNotFoundException::class);
    }

    public function test_show_category(): void
    {
        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $response = $this->getJson(route('categories.show', $category));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_category(): void
    {
        $this->assertThrows(function (): void {
            $category = Category::factory()->create();
            $this->assertModelExists($category);

            $this->postJson(route('categories.update', $category));
        }, RouteNotFoundException::class);
    }

    public function test_delete_category(): void
    {
        $this->assertThrows(function (): void {
            $category = Category::factory()->create();
            $this->assertModelExists($category);

            $this->postJson(route('categories.destroy', $category));
        }, RouteNotFoundException::class);
    }
}
