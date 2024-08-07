<?php

declare(strict_types=1);

namespace Api\Admin;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Tests\Feature\Api\Admin\Traits\ActingAsAdmin;
use Tests\TestCase;

final class AdminTest extends TestCase
{
    use ActingAsAdmin;
    use RefreshDatabase;

    public function test_admin_list(): void
    {
        Admin::factory()->count(20)->has(User::factory()->asAdmin(), 'user')->create();
        $response = $this->getJson(route('admin.admins.index'));

        $response->assertOk();
        $response->assertJsonCount(15, 'data');
    }

    public function test_create_admin(): void
    {
        $data = User::factory()->unsafePassword()->raw();

        $response = $this->postJson(route('admin.admins.store'), $data);

        $response->assertOk();
        $this->assertDatabaseHas('users', Arr::except($data, ['password']));
        $response->assertJsonStructure(['message']);
    }

    public function test_show_admin(): void
    {
        $admin = Admin::factory()->has(User::factory()->asAdmin(), 'user')->create();
        $this->assertModelExists($admin);
        $this->assertModelExists($admin->user);

        $response = $this->getJson(route('admin.admins.show', $admin));

        $response->assertOk();
        $response->assertJsonStructure(['data']);
    }

    public function test_update_admin(): void
    {
        $admin = Admin::factory()->has(User::factory()->asAdmin(), 'user')->create();
        $this->assertModelExists($admin);
        $this->assertModelExists($admin->user);

        $data = User::factory()->asAdmin()->withoutPassword()->raw();
        $data['avatar'] = UploadedFile::fake()->image('avatar.png');

        $response = $this->putJson(route('admin.admins.update', $admin), $data);

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertDatabaseHas('users', Arr::except($data, 'avatar'));
    }

    public function test_delete_admin(): void
    {
        $admin = Admin::factory()->has(User::factory()->asAdmin(), 'user')->create();
        $this->assertModelExists($admin);
        $this->assertModelExists($admin->user);

        $response = $this->deleteJson(route('admin.admins.destroy', $admin));

        $response->assertOk();
        $response->assertJsonStructure(['message']);
        $this->assertModelMissing($admin);
        $this->assertModelMissing($admin->user);
    }
}
