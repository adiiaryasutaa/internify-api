<?php

declare(strict_types=1);

namespace Api\Admin;

use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Api\Admin\Traits\ActingAsAdmin;
use Tests\TestCase;

final class CategoryTest extends TestCase
{
    use ActingAsAdmin;
    use RefreshDatabase;

    public function test_category_list(): void
    {
        $this->seed(CategorySeeder::class);

        $response = $this->getJson(route('admin.categories.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_category(): void
    {
        $data = Category::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->postJson(route('admin.categories.store'), $data);

        $response->assertOk();
        $this->assertDatabaseHas('categories', $data);
        $response->assertJsonStructure(['message']);
    }

    public function test_show_category(): void
    {
        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $response = $this->getJson(route('admin.categories.show', $category));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_category(): void
    {
        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $data = Category::factory()->withoutCode()->withoutSlug()->raw();

        $response = $this->putJson(route('admin.categories.update', $category), $data);

        $response->assertOk();
        $this->assertDatabaseHas('categories', $data);
        $response->assertJsonStructure(['message']);
    }

    public function test_delete_category(): void
    {
        $category = Category::factory()->create();
        $this->assertModelExists($category);

        $response = $this->deleteJson(route('admin.categories.destroy', $category));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($category);
    }
}
