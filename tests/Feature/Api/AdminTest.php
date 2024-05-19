<?php

namespace Api;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Sanctum::actingAs(User::factory()
            ->asAdmin()
            ->for(Admin::factory()->owner(), 'userable')
            ->create()
        );
    }

    public function test_admin_list()
    {
        Admin::factory()
            ->count(20)
            ->has(User::factory()->asAdmin(), 'user')
            ->create();

        $response = $this->getJson(route('admins.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_admin()
    {
        $data = User::factory()->unsafePassword()->raw();

        $response = $this->postJson(route('admins.store'), $data);

        $response->assertOk();

        Arr::forget($data, 'password');
        $this->assertDatabaseHas('users', $data);

        $response->assertJsonStructure(['message']);

    }

    public function test_show_admin()
    {
        $admin = Admin::factory()->create();

        $response = $this->getJson(route('admins.show', $admin));

        $response->assertOk();

        $response->assertJson(['data' => $admin->toArray()]);
    }

    public function test_update_admin()
    {
        $admin = Admin::factory()->create();
        $updatedData = Admin::factory()->raw();

        $response = $this->putJson(route('admins.update', $admin), $updatedData);

        $response->assertOk();
        $response->assertJson(['message' => __('response.admin.update.success')]);

        $this->assertDatabaseHas('admins', $updatedData);
    }

    public function test_delete_admin()
    {
        $admin = Admin::factory()->create();

        $response = $this->deleteJson(route('admins.destroy', $admin));

        $response->assertOk();
        $response->assertJson(['message' => __('response.admin.delete.success')]);

        $this->assertModelMissing($admin);
    }
}
